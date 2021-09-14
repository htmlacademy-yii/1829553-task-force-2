<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "chat".
 *
 * @property int $id
 * @property int $id_task
 * @property int $id_customer
 * @property int $id_specialist
 * @property string $message
 * @property string $created
 *
 * @property User $customer
 * @property User $specialist
 * @property Task $task
 */
class Chat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_task', 'id_customer', 'id_specialist', 'message', 'created'], 'required'],
            [['id_task', 'id_customer', 'id_specialist'], 'integer'],
            [['message'], 'string'],
            [['created'], 'safe'],
            [
                ['id_customer'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['id_customer' => 'id']
            ],
            [
                ['id_specialist'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['id_specialist' => 'id']
            ],
            [
                ['id_task'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Task::className(),
                'targetAttribute' => ['id_task' => 'id']]
            ,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_task' => 'ID Задачи',
            'id_customer' => 'ID Заказчика',
            'id_specialist' => 'ID Специалиста',
            'message' => 'Сообщение',
            'created' => 'Создан',
        ];
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
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'id_task']);
    }
}
