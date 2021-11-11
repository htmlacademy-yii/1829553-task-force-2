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

$isClient = $faker->boolean(30);
$cityIds = City::find()->select('id')->column();

$userName = $faker->name;
$avatar = new LasseRafn\InitialAvatarGenerator\InitialAvatar();
$image = $avatar->name($userName)
    ->size(191)
    ->background('#8BC34A')
    ->color('#fff')
    ->generate();
$fileName = Yii::$app->security->generateRandomString(10) . '.png';
$filePath = Yii::getAlias('@avatars') . '/' . $fileName;
$image->save($filePath);

$user = [
    'email' => $faker->email,
    'name' => $userName,
    'password' => Yii::$app->getSecurity()->generatePasswordHash('password_' . $index),
    'birthday' => $birthday,
    'is_client' => $isClient,
    'city_id' =>  $faker->randomElement($cityIds),
    'created' => $created,
    'avatar' => $fileName,
];

if (!$isClient) {
    $user += [
        'about' => $faker->about(),
        'phone' => substr($faker->e164PhoneNumber, 1, 11),
        'telegram' => '@' . $faker->word,
        'hide_contacts' => $faker->boolean(30),
        'rating' => number_format($faker->randomFloat(5, 0, 5), 2),
    ];
}

return $user;
