<?php

namespace app\models;

/**
 * @property Bid[] $bids
 * @property Category[] $categories
 * @property PerformerCategories[] $performerCategories
 * @property Review[] $reviews
 * @property Task[] $tasks
 * @property string $USER [char(32)]
 * @property int $CURRENT_CONNECTIONS [bigint]
 * @property int $TOTAL_CONNECTIONS [bigint]
 */
class Performer extends User
{
    /**
     * Gets query for [[Bids]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBids()
    {
        return $this->hasMany(Bid::className(), ['performer_id' => 'id']);
    }

    /**
     * Gets query for [[Categories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this
            ->hasMany(Category::className(), ['id' => 'category_id'])
            ->viaTable('performers_categories', ['performer_id' => 'id']
        );
    }

    /**
     * Gets query for [[Reviews]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getReviews()
    {
        return $this->hasMany(Review::className(), ['performer_id' => 'id']);
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['performer_id' => 'id']);
    }

    /**
     * Gets query for [[PerformerCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerformerCategories()
    {
        return $this->hasMany(PerformerCategories::className(), ['performer_id' => 'id']);
    }

    public function getPathAvatar()
    {
        return '/uploads/avatars/' . $this->avatar;
    }

    public function getStarts()
    {
        $result = [];
        $rating = round($this->rating);
        for ($i = 1; $i <= 5; $i++) {
            $result[$i] = 0;
            if ($i <= $rating) {
                $result[$i] = 1;
            }
        }
        return $result;
    }
}
