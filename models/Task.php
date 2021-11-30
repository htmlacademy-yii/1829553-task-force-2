<?php

namespace app\models;

use Mar4hk0\Exceptions\ExceptionTask;
use Yii;

/**
 * This is the model class for table "tasks".
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property int|null $city_id
 * @property int|null $price
 * @property int $category_id
 * @property int $client_id
 * @property int|null $performer_id
 * @property string|null $deadline
 * @property string|null $address
 * @property string|null $long
 * @property string|null $lat
 * @property int $status_id
 * @property string $created
 *
 * @property Bid[] $bids
 * @property Category $category
 * @property City $city
 * @property Client $client
 * @property File[] $files
 * @property Performer $performer
 * @property Review[] $reviews
 * @property Status $status
 */
class Task extends \yii\db\ActiveRecord
{
    public bool $remoteJob;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tasks';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'category_id', 'client_id', 'status_id', 'created'], 'required'],
            [['description'], 'string'],
            [['city_id', 'price', 'category_id', 'client_id', 'performer_id', 'status_id'], 'integer'],
            [['id', 'deadline', 'created', 'remoteJob'], 'safe'],
            [['title', 'address'], 'string', 'max' => 255],
            [['long', 'lat'], 'string', 'max' => 100],
            [['city_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => City::className(),
                'targetAttribute' => ['city_id' => 'id']],
            [['category_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Category::className(),
                'targetAttribute' => ['category_id' => 'id']],
            [['client_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['client_id' => 'id']],
            [['performer_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['performer_id' => 'id']],
            [['status_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Status::className(),
                'targetAttribute' => ['status_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'description' => 'Description',
            'city_id' => 'City ID',
            'price' => 'Price',
            'category_id' => 'Category ID',
            'client_id' => 'Client ID',
            'performer_id' => 'Performer ID',
            'deadline' => 'Deadline',
            'address' => 'Address',
            'long' => 'Long',
            'lat' => 'Lat',
            'status_id' => 'Status ID',
            'created' => 'Created',
            'remoteJob' => 'remoteJob',
        ];
    }

    public function afterFind()
    {
        parent::afterFind();

        $this->remoteJob = false;
        if (empty($this->city_id) || (empty($this->lat) && empty($this->long))) {
            $this->remoteJob = true;
        }
    }

    /**
     * Gets query for [[Bids]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBids()
    {
        return $this->hasMany(Bid::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Client]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }

    /**
     * Gets query for [[Files]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Performer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerformer()
    {
        return $this->hasOne(Performer::className(), ['id' => 'performer_id']);
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::className(), ['task_id' => 'id']);
    }

    /**
     * Gets query for [[Status]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStatus()
    {
        return $this->hasOne(Status::className(), ['id' => 'status_id']);
    }



    public function getRemoteJobHuman(): string
    {
        $result = 'Работа не удаленная';
        if ($this->remoteJob) {
            $result = 'Работа удаленная';
        }
        return $result;
    }

    public function getDeadlineHuman()
    {
        if (empty($this->deadline)) {
            return 'Срок не определен';
        }
        return Yii::$app->formatter->format($this->deadline, ['datetime', 'php:j F, H:i']);
    }

    public static function getTasks(string $statusName): array
    {
        $statusId = Status::getStatusId($statusName);
        return Task::find()
            ->where(['status_id' => $statusId])
            ->orderBy(['created' => SORT_DESC])
            ->indexBy('id')
            ->all();
    }

    public static function getLastTasks(int $num): array
    {
        $statusId = Status::getStatusNewId();
        return Task::find()
            ->where(['status_id' => $statusId])
            ->orderBy(['created' => SORT_DESC])
            ->indexBy('id')
            ->limit($num)
            ->all();
    }

    public function getAction(User $user): array
    {
        $actions = [];
        $allowedActions = [];
        if ($this->status_id == Status::getStatusNewId()) {
            $allowedActions = array_merge($allowedActions, [new CancelAction(), new BidAction()]);
            // Если есть отклики, то еще может быть действие "Старт задания"
            if (!empty($this->bids)) {
                $allowedActions[] = new StartAction();
            }
        }
        if ($this->status_id == Status::getStatusInProcessId()) {
            $allowedActions = array_merge($allowedActions, [new RefuseAction(), new FinishAction()]);
        }

        if (empty($allowedActions)) {
            throw new ExceptionTask(
                'Could not get Action by status: ' . $this->status_id
            );
        }

        foreach ($allowedActions as $action) {
            if ($action->checkPermissions($this->performer_id, $this->client_id, $user)) {
                $actions[] = $action;
            }
        }
        return $actions;
    }

    public function getAllowedBids(User $user): array
    {
        if ($this->client_id == $user->id && $user->is_client) {
            return $this->bids;
        }
        if (!$user->is_client) {
            foreach ($this->bids as $bid) {
                if ($bid->performer_id == $user->id) {
                    return [$bid];
                }
            }
        }
        return [];
    }

    public function isShowButtonBids(User $user): bool
    {
        if ($this->client_id == $user->id) {
            return true;
        }

        return false;
    }

}
