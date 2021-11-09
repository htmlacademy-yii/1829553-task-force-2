<?php

namespace app\models;

/**
 * @property Bid[] $bids
 * @property Category[] $categories
 * @property PerformerCategories[] $performerCategories
 * @property Review[] $reviews
 * @property Task[] $tasks
 * @property string $USER [char(32)]
 * @property int $CURRENT_CONNECTIONS [bigint]
 * @property int $TOTAL_CONNECTIONS [bigint]
 */
class Performer extends User
{
    /**
     * @var false
     */
    private bool $status;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'name', 'password', 'birthday', 'is_client', 'city_id', 'created'], 'required'],
            [['birthday', 'created', 'status'], 'safe'],
            [['is_client', 'hide_contacts', 'city_id'], 'integer'],
            [['about'], 'string'],
            [['rating'], 'number'],
            [['email', 'name', 'avatar'], 'string', 'max' => 255],
            [['password', 'telegram'], 'string', 'max' => 64],
            [['phone'], 'string', 'max' => 11],
            [['email'], 'unique'],
            [['city_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => City::className(),
                'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    public function afterFind()
    {
        parent::afterFind();

        $this->status = false;
        if ($this->getTasks()->where(['status_id' => Status::STATUS_IN_PROCESS])->all()) {
            $this->status = true;
        }
    }

    /**
     * Gets query for [[Bids]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBids()
    {
        return $this->hasMany(Bid::className(), ['performer_id' => 'id']);
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this
            ->hasMany(Category::className(), ['id' => 'category_id'])
            ->viaTable('performers_categories', ['performer_id' => 'id']
        );
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::className(), ['performer_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['performer_id' => 'id']);
    }

    /**
     * Gets query for [[PerformerCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerformerCategories()
    {
        return $this->hasMany(PerformerCategories::className(), ['performer_id' => 'id']);
    }

    public function getPathAvatar()
    {
        return '/uploads/avatars/' . $this->avatar;
    }

    public function getStarts()
    {
        $result = [];
        $rating = round($this->rating);
        for ($i = 1; $i <= 5; $i++) {
            $result[$i] = 0;
            if ($i <= $rating) {
                $result[$i] = 1;
            }
        }
        return $result;
    }

    public function getNumberTaskCompleted()
    {
        return $this->getNumberTask(Status::STATUS_COMPLETED);
    }

    public function getNumberTaskFailed()
    {
        return $this->getNumberTask(Status::STATUS_FAILED);
    }

    public function getNumberTask(string $status)
    {
        return $this->getTasks()->where(['status_id' => $status])->count();
    }

    public function getPlaceRating(): int
    {
        $performers = User::find()->where(['is_client' => 0])->orderBy(['rating' => SORT_DESC])->all();
        foreach ($performers as $index => $performer) {
            if ($performer->id == $this->id) {
                return ++$index;
            }
        }
        return count($performers);
    }

    public function getStatusHuman(): string
    {
        $msg = 'Открыт для новых заказов';
        if ($this->status) {
            $msg = 'Занят';
        }
        return $msg;
    }
}
