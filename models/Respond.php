<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "respond".
 *
 * @property int $id
 * @property int $id_specialist
 * @property string|null $description Описание отклика
 * @property int|null $rate Исполнитель предлагает свою цену за работу
 * @property int $id_task
 * @property int $rejected Заказчик отклонил данный отклик
 * @property string $created
 *
 * @property User $specialist
 * @property Task $task
 */
class Respond extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'respond';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_specialist', 'id_task', 'rejected', 'created'], 'required'],
            [['id_specialist', 'rate', 'id_task', 'rejected'], 'integer'],
            [['description'], 'string'],
            [['created'], 'safe'],
            [['id_specialist', 'id_task'], 'unique', 'targetAttribute' => ['id_specialist', 'id_task']],
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
                'targetAttribute' => ['id_task' => 'id']
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
            'id_specialist' => 'Идентификатор специалиста',
            'description' => 'Описание отклика',
            'rate' => 'Цена исполнителя',
            'id_task' => 'Идентификатор задачи',
            'rejected' => 'Отклонил заказчик',
            'created' => 'Создан',
        ];
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
