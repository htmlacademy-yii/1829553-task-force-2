<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "notification".
 *
 * @property int $id
 * @property int $id_user
 * @property int $new_message
 * @property int $actions_task
 * @property int $new_reviews
 *
 * @property User $user
 */
class Notification extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'notification';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_user', 'new_message', 'actions_task', 'new_reviews'], 'required'],
            [['id_user', 'new_message', 'actions_task', 'new_reviews'], 'integer'],
            [['id_user'], 'unique'],
            [
                ['id'],
                'exist',
                'skipOnError' => false,
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
            'id_user' => 'Id User',
            'new_message' => 'New Message',
            'actions_task' => 'Actions Task',
            'new_reviews' => 'New Reviews',
        ];
    }

    /**
     * Gets query for [[Id0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'id_user']);
    }
}
