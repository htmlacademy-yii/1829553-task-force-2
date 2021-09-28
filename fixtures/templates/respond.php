<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

use app\fixtures\UserFixture;
use app\models\Task;

$userFixture = new UserFixture();
$specialistIds = $userFixture->getAllIdSpecialist();
$specialistId = $specialistIds[$index % count($specialistIds)];

$created = $faker->dateTimeBetween('-2 weeks', '-1 week')
    ->format('Y-m-d H:i:s');

$tasks = Task::find()->all();
$task = $tasks[$index % count($tasks)];

$minPrice = $task['price'] - round($task['price'] * 0.3);
$maxPrice = $task['price'] + round($task['price'] * 0.05);

return [
    'id_specialist' => $specialistId,
    'description' => $faker->description(),
    'rate' => rand($minPrice, $maxPrice),
    'id_task' => $task['id'],
    'rejected' => $faker->boolean(),
    'created' => $created
];
