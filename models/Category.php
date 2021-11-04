<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $name
 * @property string $icon
 *
 * @property Task[] $tasks
 * @property Performer[] $performers
 * @property PerformerCategories[] $performerCategories
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'icon'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['icon'], 'string', 'max' => 64],
            [['name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'icon' => 'Icon',
        ];
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['category_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerformers()
    {
        return $this
            ->hasMany(Performer::className(), ['id' => 'performer_id'])
            ->viaTable('performers_categories', ['category_id' => 'id']);
    }

    /**
     * Gets query for [[PerformerCategories]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPerformerCategories()
    {
        return $this->hasMany(PerformerCategories::className(), ['category_id' => 'id']);
    }

//    написать миграцию для замены столбцов
//    переделай фикстуры тоже, проблема со временем в задачах

}
