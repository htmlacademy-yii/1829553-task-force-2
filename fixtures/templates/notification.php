<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

use app\models\User;

$userIds = User::find()
    ->select('id')
    ->column();

return [
    'id_user' => $userIds[$index],
    'new_message' => rand(0, 1) == 1,
    'actions_task' => rand(0, 1) == 1,
    'new_reviews' => rand(0, 1) == 1,
];
