<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

use app\models\City;
use app\models\Role;

$roleIds = Role::find()->select('id')->column();
$cityIds = City::find()->select('id')->column();
$nick = $faker->word;
$birthday = $faker->dateTimeBetween('-50 years', '-20 years')
    ->format('Y-m-d H:i:s');
$created = $faker->dateTimeBetween('-6 months', '-1 week')
    ->format('Y-m-d H:i:s');

return [
    'name' => $faker->name,
    'email' => $faker->email,
    'birthday' => $birthday,
    'password' => Yii::$app->getSecurity()->generatePasswordHash('password_' . $index),
    'about' => $faker->about(),
    'hide_profile' =>  rand(0, 1) == 1,
    'hide_contacts' =>  rand(0, 1) == 1,
    'id_role' =>  $faker->randomElement($roleIds),
    'id_city' =>  $faker->randomElement($cityIds),
    'rating' => number_format($faker->randomFloat(5, 0, 5), 2),
    'phone' => substr($faker->e164PhoneNumber, 1, 11),
    'skype' => $nick,
    'telegram' => '@' . $nick,
    'created' => $created,
];
