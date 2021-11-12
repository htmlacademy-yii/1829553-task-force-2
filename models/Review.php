<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reviews".
 *
 * @property int $id
 * @property int $client_id
 * @property int $performer_id
 * @property int $task_id
 * @property string $description
 * @property int $grade
 * @property string $created
 *
 * @property Client $client
 * @property Performer $performer
 * @property Task $task
 */
class Review extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'client_id', 'performer_id', 'task_id', 'description', 'grade', 'created'], 'required'],
            [['id', 'client_id', 'performer_id', 'task_id', 'grade'], 'integer'],
            [['created'], 'safe'],
            [['description'], 'string', 'max' => 255],
            [['client_id', 'performer_id', 'task_id'],
                'unique',
                'targetAttribute' => ['client_id', 'performer_id', 'task_id']],
            [['id'], 'unique'],
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
            [['task_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Task::className(),
                'targetAttribute' => ['task_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_id' => 'ID Клиента',
            'performer_id' => 'ID Исполнителя',
            'task_id' => 'ID задачи',
            'description' => 'Отзыв',
            'grade' => 'Оценка',
            'created' => 'Created',
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $this->performer->updateRating($this->grade);
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
     * Gets query for [[Performer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerformer()
    {
        return $this->hasOne(Performer::className(), ['id' => 'performer_id']);
    }

    /**
     * Gets query for [[Task]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTask()
    {
        return $this->hasOne(Task::className(), ['id' => 'task_id']);
    }
}
