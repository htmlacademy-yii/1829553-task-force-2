<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

use app\models\City;

$birthday = $faker->dateTimeBetween('-50 years', '-20 years')
    ->format('Y-m-d H:i:s');
$created = $faker->dateTimeBetween('-6 months', '-1 week')
    ->format('Y-m-d H:i:s');

$is_client = $faker->boolean(30);
$cityIds = City::find()->select('id')->column();

$user = [
    'email' => $faker->email,
    'name' => $faker->name,
    'password' => Yii::$app->getSecurity()->generatePasswordHash('password_' . $index),
    'birthday' => $birthday,
    'is_client' => $is_client,
    'city_id' =>  $faker->randomElement($cityIds),
    'created' => $created,
];

if (!$is_client) {
    $avatar = new LasseRafn\InitialAvatarGenerator\InitialAvatar();
    $image = $avatar->name($user['name'])
        ->size(191)
        ->background('#8BC34A')
        ->color('#fff')
        ->generate();
    $fileName = Yii::$app->security->generateRandomString(7) . '.png';
    $filePath = Yii::getAlias('@avatars') . '/' . $fileName;
    $image->save($filePath);
    $user += [
        'about' => $faker->about(),
        'phone' => substr($faker->e164PhoneNumber, 1, 11),
        'telegram' => '@' . $faker->word,
        'avatar' => $fileName,
        'hide_contacts' => $faker->boolean(30),
        'rating' => number_format($faker->randomFloat(5, 0, 5), 2),
    ];
}

return $user;
