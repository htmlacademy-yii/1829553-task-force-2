<?php

namespace app\models;

use yii\base\Model;

/**
 * RegistrationForm is the model behind the login form.
 */
class RegistrationForm extends Model
{
    public string $name = '';
    public string $email = '';
    public string $cityName = '';
    public int $cityId = 1;
    public string $password = '';
    public string $passwordRepeat = '';
    public bool $isClient = false;
    public string $birthday = '';

    public function __construct($config = [])
    {
        parent::__construct($config);

        $this->cityId = City::getDefaultCity()->id;
        $this->cityName = City::getDefaultCity()->name;
    }

    public function rules()
    {
        return [
            [['name', 'password', 'passwordRepeat', 'email', 'birthday'], 'required'],
            ['name', 'string', 'min' => 3],
            ['isClient', 'boolean'],
            [['name', 'password'], 'string'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::class],
            ['password', 'string', 'min' => 4, 'max' => 12],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают'],
            ['birthday', 'datetime', 'format' => 'php:Y-m-d']
        ];
    }

    public function signup(): bool
    {
        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->city_id = $this->cityId;
        $user->setPassword($this->password);
        $user->is_client = !(boolean) $this->isClient;
        $user->birthday = $this->birthday;
        $user->created = date('Y-m-d H:i:s');
        return $user->save();
    }

}
