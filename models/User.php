<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $birthday
 * @property string $password
 * @property string|null $about
 * @property int|null $hide_profile
 * @property int|null $hide_contacts
 * @property int $id_role
 * @property int|null $id_city
 * @property float|null $rating
 * @property string|null $phone
 * @property string|null $skype
 * @property string|null $telegram
 * @property string $created
 *
 * @property Chat[] $customerChats
 * @property Chat[] $SpecialistChats
 * @property City $city
 * @property File[] $files
 * @property Notification $notification
 * @property Respond[] $responds
 * @property Role $role
 * @property Skill[] $skills
 * @property Task[] $customerTasks
 * @property Task[] $specialistTasks
 * @property UserSkill[] $userSkills
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'birthday', 'password', 'id_role'], 'required'],
            [['birthday', 'created'], 'safe'],
            [['about'], 'string'],
            [['hide_profile', 'hide_contacts', 'id_role', 'id_city'], 'integer'],
            [['rating'], 'number'],
            [['name', 'email'], 'string', 'max' => 100],
            [['password', 'skype'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 12],
            [['telegram'], 'string', 'max' => 64],
            [['email'], 'unique'],
            [
                ['id_role'],
                'exist',
                'skipOnError' => true,
                'targetClass' => Role::className(),
                'targetAttribute' => ['id_role' => 'id']
            ],
            [
                ['id_city'],
                'exist',
                'skipOnError' => true,
                'targetClass' => City::className(),
                'targetAttribute' => ['id_city' => 'id']
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
            'name' => 'Имя',
            'email' => 'e-mail',
            'birthday' => 'День рождения',
            'password' => 'Пароль',
            'about' => 'О себе',
            'hide_profile' => 'Скрыть профиль',
            'hide_contacts' => 'Скрыть контакты',
            'id_role' => 'ID Роли',
            'id_city' => 'ID Города',
            'rating' => 'Рейтинг',
            'phone' => 'Номер телефона',
            'skype' => 'Skype-nick',
            'telegram' => 'Telegram-nick',
            'created' => 'Создан',
        ];
    }

    /**
     * Gets query for [[CustomerChats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerChats()
    {
        return $this->hasMany(Chat::className(), ['id_customer' => 'id']);
    }

    /**
     * Gets query for [[SpecialistChats]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSpecialistChats()
    {
        return $this->hasMany(Chat::className(), ['id_specialist' => 'id']);
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::className(), ['id' => 'id_city']);
    }

    /**
     * Gets query for [[Files]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(File::className(), ['id_user' => 'id']);
    }

    /**
     * Gets query for [[Notification]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNotification()
    {
        return $this->hasOne(Notification::className(), ['id_user' => 'id']);
    }

    /**
     * Gets query for [[Responds]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getResponds()
    {
        return $this->hasMany(Respond::className(), ['id_specialist' => 'id']);
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::className(), ['id' => 'id_role']);
    }

    /**
     * Gets query for [[Skills]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSkills()
    {
        return $this->hasMany(Skill::className(), ['id' => 'id_skill'])
            ->viaTable('user_skill', ['id_specialist' => 'id']);
    }

    /**
     * Gets query for [[SpecialistTasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSpecialistTasks()
    {
        return $this->hasMany(Task::className(), ['id_specialist' => 'id']);
    }

    /**
     * Gets query for [[CustomerTasks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCustomerTasks()
    {
        return $this->hasMany(Task::className(), ['id_customer' => 'id']);
    }

    /**
     * Gets query for [[UserSkills]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserSkills()
    {
        return $this->hasMany(UserSkill::className(), ['id_specialist' => 'id']);
    }
}
