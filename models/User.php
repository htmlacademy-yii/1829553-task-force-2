<?php

namespace app\models;

use cebe\markdown\tests\MarkdownOLStartNumTest;
use DateTime;
use Mar4hk0\Helpers\DateTimeHelper;
use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $email
 * @property string $name
 * @property string $password
 * @property string $birthday
 * @property int $is_client
 * @property string|null $about
 * @property string|null $phone
 * @property string|null $telegram
 * @property string|null $avatar
 * @property int|null $hide_contacts
 * @property int $city_id
 * @property string $created
 * @property float|null $rating
 *
 * @property City $city
 * @property File[] $files
 * @property string $USER [char(32)]
 * @property int $CURRENT_CONNECTIONS [bigint]
 * @property int $TOTAL_CONNECTIONS [bigint]
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{

    public const CLIENT = true;

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
            [['email', 'name', 'password', 'birthday', 'is_client', 'city_id', 'created'], 'required'],
            [['birthday', 'created'], 'safe'],
            [['hide_contacts', 'city_id'], 'integer'],
            [['about'], 'string'],
            [['rating'], 'number'],
            [['is_client'], 'boolean'],
            [['email', 'name', 'avatar'], 'string', 'max' => 255],
            [['password', 'telegram'], 'string', 'max' => 64],
            ['phone', 'match', 'pattern' => '/^[\d]{11}/i', 'message' => 'Номер телефона должен состоять из 11 цифр'],
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

    public function getCurrentAge(): int
    {
        return DateTimeHelper::diff(new DateTime($this->birthday))->y;
    }

    public function getPathAvatar()
    {
        return '/uploads/avatars/' . $this->avatar;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }

        return null;
    }

    public function setPassword(string $password)
    {
        $this->password = Yii::$app->getSecurity()->generatePasswordHash($password);
    }

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public function getId()
    {
        return $this->getPrimaryKey();
    }

    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }


    public function validatePassword($password): bool
    {
        return \Yii::$app->security->validatePassword($password, $this->password);
    }
}
