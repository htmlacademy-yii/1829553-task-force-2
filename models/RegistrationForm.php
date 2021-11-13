<?php

namespace app\models;

use Yii;
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
            [['name', 'password', 'passwordRepeat', 'email'], 'required'],
            ['name', 'string', 'min' => 3],
            ['isClient', 'boolean'],
            [['name', 'password'], 'string'],
            ['email', 'email'],
        ];
    }

    public function createUser()
    {
        if (!$this->validate()) {
           return false;
        }



    }

}
