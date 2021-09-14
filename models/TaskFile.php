<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "task_file".
 *
 * @property int $id
 * @property int $id_task
 * @property int $id_file
 *
 * @property File $file
 * @property Task $task
 */
class TaskFile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'task_file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_task', 'id_file'], 'required'],
            [['id_task', 'id_file'], 'integer'],
            [['id_task', 'id_file'], 'unique', 'targetAttribute' => ['id_task', 'id_file']],
            [
                ['id_task'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Task::className(),
                'targetAttribute' => ['id_task' => 'id']
            ],
            [
                ['id_file'],
                'exist',
                'skipOnError' => true,
                'targetClass' => File::className(),
                'targetAttribute' => ['id_file' => 'id']
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
            'id_task' => 'ID Задачи',
            'id_file' => 'ID Файла',
        ];
    }

    /**
     * Gets query for [[File]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(File::className(), ['id' => 'id_file']);
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
