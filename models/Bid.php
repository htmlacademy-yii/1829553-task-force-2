<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bids".
 *
 * @property int $id
 * @property string $description
 * @property int $price
 * @property int $task_id
 * @property int $is_refused
 * @property int $performer_id
 * @property string $created
 *
 * @property Performer $performer
 * @property Task $task
 */
class Bid extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bids';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['description', 'price', 'task_id', 'is_refused', 'performer_id', 'created'], 'required'],
            [['description'], 'string'],
            [['is_refused'], 'boolean'],
            [['price', 'task_id', 'performer_id'], 'integer'],
            [['id', 'created'], 'safe'],
            [['task_id'], 'exist', 'skipOnError' => true, 'targetClass' => Task::className(), 'targetAttribute' => ['task_id' => 'id']],
            [['performer_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['performer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'description' => 'Description',
            'price' => 'Price',
            'task_id' => 'Task ID',
            'is_refused' => 'Is Refused',
            'performer_id' => 'Performer ID',
            'created' => 'Created',
        ];
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

    public function refuse(): void
    {
        $this->is_refused = true;
    }
}
