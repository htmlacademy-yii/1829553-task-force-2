<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $human_name
 * @property string $system_name
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
            [['human_name', 'system_name'], 'required'],
            [['human_name'], 'string', 'max' => 100],
            [['system_name'], 'string', 'max' => 64],
            [['human_name'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'human_name' => 'Название',
            'system_name' => 'system_name',
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

    public function getHumanName(): ?string
    {
        return $this->human_name ?? 'Категория не существует';
    }

    public static function getAll()
    {
        return self::find()->indexBy('id')->all();
    }

}
