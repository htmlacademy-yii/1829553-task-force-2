<?php

namespace app\models;


/**
 * @property Review[] $reviews
 * @property Task[] $tasks
 */
class Client extends User
{

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::className(), ['client_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['client_id' => 'id']);
    }
}
