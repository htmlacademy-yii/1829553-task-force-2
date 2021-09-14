<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property int|null $id_specialist
 * @property int $id_customer
 * @property string $name
 * @property string $description
 * @property int|null $price
 * @property int|null $deadline UTC Fortmat
 * @property int $remote
 * @property int $id_skill
 * @property int|null $id_city
 * @property float|null $longitude
 * @property float|null $latitude
 * @property string|null $address
 * @property string $created
 *
 * @property Chat[] $chats
 * @property City $city
 * @property User $customer
 * @property File[] $files
 * @property Respond[] $responds
 * @property Review $review
 * @property Skill $skill
 * @property User $specialist
 * @property User[] $respondedSpecialists
 * @property TaskFile[] $taskFiles
 */
class Task extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_specialist', 'id_customer', 'price', 'deadline', 'remote', 'id_skill', 'id_city'], 'integer'],
            [['id_customer', 'name', 'description', 'remote', 'id_skill', 'created'], 'required'],
            [['description', 'address'], 'string'],
            [['longitude', 'latitude'], 'number'],
            [['created'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [
                ['id_specialist'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['id_specialist' => 'id']
            ],
            [
                ['id_customer'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['id_customer' => 'id']
            ],
            [
                ['id_skill'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Skill::className(),
                'targetAttribute' => ['id_skill' => 'id']
            ],
            [
                ['id_city'],
                'exist',
                'skipOnError' => true,
                'targetClass' => City::className(),
                'targetAttribute' => ['id_city' => 'id']
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_specialist' => 'ID специалиста',
            'id_customer' => 'ID Заказчика',
            'name' => 'Название',
            'description' => 'Описание',
            'price' => 'Цена',
            'deadline' => 'Сроки',
            'remote' => 'Удаленная работа',
            'id_skill' => 'ID Навыка',
            'id_city' => 'ID Города',
            'longitude' => 'Долгота',
            'latitude' => 'Широта',
            'address' => 'Адрес',
            'created' => 'Создан',
        ];
    }

    /**
     * Gets query for [[Chats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getChats()
    {
        return $this->hasMany(Chat::className(), ['id_task' => 'id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'id_city']);
    }

    /**
     * Gets query for [[Customer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(User::className(), ['id' => 'id_customer']);
    }

    /**
     * Gets query for [[Specialist]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSpecialist()
    {
        return $this->hasOne(User::className(), ['id' => 'id_specialist']);
    }

    /**
     * Gets query for [[Files]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['id' => 'id_file'])
            ->viaTable('task_file', ['id_task' => 'id']);
    }

    /**
     * Gets query for [[Responds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponds()
    {
        return $this->hasMany(Respond::className(), ['id_task' => 'id']);
    }

    /**
     * Gets query for [[Review]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReview()
    {
        return $this->hasOne(Review::className(), ['id_task' => 'id']);
    }

    /**
     * Gets query for [[Skill]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSkill()
    {
        return $this->hasOne(Skill::className(), ['id' => 'id_skill']);
    }

    /**
     * Gets query for [[Specialists]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRespondedSpecialists()
    {
        return $this->hasMany(User::className(), ['id' => 'id_specialist'])
            ->viaTable('respond', ['id_task' => 'id']);
    }

    /**
     * Gets query for [[TaskFiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskFiles()
    {
        return $this->hasMany(TaskFile::className(), ['id_task' => 'id']);
    }
}
