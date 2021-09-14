<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "file".
 *
 * @property int $id
 * @property string $path
 * @property int $id_user
 * @property string $file_name
 * @property string $file_types
 * @property string $created
 *
 * @property TaskFile[] $taskFiles
 * @property Task[] $tasks
 * @property User $user
 */
class File extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['path', 'id_user', 'file_name', 'file_types', 'created'], 'required'],
            [['id_user'], 'integer'],
            [['created'], 'safe'],
            [['path', 'file_name'], 'string', 'max' => 255],
            [['file_types'], 'string', 'max' => 100],
            [
                ['id_user'],
                'exist',
                'skipOnError' => true,
                'targetClass' => User::className(),
                'targetAttribute' => ['id_user' => 'id']
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
            'path' => 'Путь к файлу',
            'id_user' => 'ID пользователя',
            'file_name' => 'Название файла',
            'file_types' => 'Тип файла',
            'created' => 'Создан',
        ];
    }

    /**
     * Gets query for [[TaskFiles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTaskFiles()
    {
        return $this->hasMany(TaskFile::className(), ['id_file' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['id' => 'id_task'])
            ->viaTable('task_file', ['id_file' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }
}
