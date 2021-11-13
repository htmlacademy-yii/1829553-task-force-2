<?php

namespace app\models;


/**
 * @property Review[] $reviews
 * @property Task[] $tasks
 */
class Client extends User
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email', 'name', 'password', 'birthday', 'is_client', 'city_id', 'created'], 'required'],
            [['birthday', 'created'], 'safe'],
            [['is_client', 'hide_contacts', 'city_id'], 'integer'],
            [['about'], 'string'],
            [['rating'], 'number'],
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
            'rating' => 'Rating',
        ];
    }

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
