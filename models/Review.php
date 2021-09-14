<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "review".
 *
 * @property int $id
 * @property int $id_task
 * @property string $review Описание отзыва на работу
 * @property int $grade Оценка за работу
 * @property string $created
 *
 * @property Task $task
 */
class Review extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'review';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_task', 'review', 'grade', 'created'], 'required'],
            [['id_task', 'grade'], 'integer'],
            [['review'], 'string'],
            [['created'], 'safe'],
            [['id_task'], 'unique'],
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
            'id_task' => 'Идентификатор задачи',
            'review' => 'Отзыв',
            'grade' => 'Оценка за работу',
            'created' => 'Создан',
        ];
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
