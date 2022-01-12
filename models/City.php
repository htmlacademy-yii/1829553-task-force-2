<?php

namespace app\models;

use phpDocumentor\Reflection\Types\This;
use Yii;

/**
 * This is the model class for table "cities".
 *
 * @property int $id
 * @property string $name
 * @property string|null $lat
 * @property string|null $long
 *
 * @property Task[] $tasks
 * @property User[] $users
 */
class City extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['lat', 'long'], 'string', 'max' => 100],
            [['name', 'lat', 'long'], 'unique', 'targetAttribute' => ['name', 'lat', 'long']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'lat' => 'Lat',
            'long' => 'Long',
        ];
    }

    /**
     * Gets query for [[Tasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTasks()
    {
        return $this->hasMany(Task::className(), ['city_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['city_id' => 'id']);
    }

    public static function getDefaultCity(): self
    {
        return self::find()->limit(1)->one();
    }

    public static function getBatch(array $ids): array
    {
        return self::find()->where(['id' => $ids])->indexBy('id')->all();
    }

    public static function getCityIdByName(string $name): ?int
    {
        $result = self::findOne(['name' => $name]);
        return $result->id ?? null;
    }
}
