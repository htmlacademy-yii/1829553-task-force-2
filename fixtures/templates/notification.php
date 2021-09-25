<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

use app\models\Notification;
use app\models\User;

$userIds = User::find()
    ->select('id')
    ->column();

// Делаем генерацию в цикле, для того чтобы проверить на уникальность
// поле id_user. Но это не работает, ведь потому что в БД еще ничего
// не записалось, а значит через AR не получить. Данные пишутся в файл
// app/fixtures/data/notification.php
// мне нужно как-то получить данные из файла app/fixtures/data/notification.php
// для того чтобы проверять не будет ли нарушения с уникальными полями

do {
    $userID = $faker->randomElement($userIds);
} while (empty(Notification::findOne($userID)));

return [
    'id_user' => $userID,
//    'id_user' => getUniqueUserID(),
    'new_message' => rand(0, 1) == 1,
    'actions_task' => rand(0, 1) == 1,
    'new_reviews' => rand(0, 1) == 1,
];
