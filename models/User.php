<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $email
 * @property string $name
 * @property string $password
 * @property string $birthday
 * @property int $is_client
 * @property string $about
 * @property string $phone
 * @property string $telegram
 * @property string|null $avatar
 * @property int $hide_contacts
 * @property int $city_id
 * @property string $created
 *
 * @property City $city
 * @property File[] $files
 * @property string $USER [char(32)]
 * @property int $CURRENT_CONNECTIONS [bigint]
 * @property int $TOTAL_CONNECTIONS [bigint]
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email',
                'name',
                'password',
                'birthday',
                'is_client',
                'about',
                'phone',
                'telegram',
                'hide_contacts',
                'city_id',
                'created'], 'required'],
            [['birthday', 'created'], 'safe'],
            [['is_client', 'hide_contacts', 'city_id'], 'integer'],
            [['about'], 'string'],
            [['email', 'name', 'avatar'], 'string', 'max' => 255],
            [['password', 'telegram'], 'string', 'max' => 64],
            [['phone'], 'string', 'max' => 11],
            [['email'], 'unique'],
            [['city_id'],
                'exist',
                'skipOnError' => true,
                'targetClass' => City::className(),
                'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'name' => 'Имя',
            'password' => 'Пароль',
            'birthday' => 'День рождения',
            'is_client' => 'Является клиентом',
            'about' => 'Информация о себе',
            'phone' => 'Номер телефона',
            'telegram' => 'Telegram',
            'avatar' => 'Аватар',
            'hide_contacts' => 'Скрыть контакты?',
            'city_id' => 'City ID',
            'created' => 'Created',
        ];
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'city_id']);
    }

    /**
     * Gets query for [[Files]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['user_id' => 'id']);
    }
}
