<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

use app\fixtures\UserFixture;
use app\fixtures\TaskFixture;
use \app\models\Status;
use \app\fixtures\Helper;

$userFixture = new UserFixture();
$performerIds = $userFixture->getAllPerformerId();
$performerId = $performerIds[$index % count($performerIds)];

$taskFixture = new TaskFixture();
$tasks = $taskFixture->getTasks(Status::STATUS_NEW);
$num = count($tasks) * 0.3;
for ($i = $num; $i > 0; --$i) {
    $key = array_key_last($tasks);
    unset($tasks[$key]);
}
$task = $tasks[$index % count($tasks)];

$minPrice = $task['price'] - round($task['price'] * 0.3);
$endDate = Helper::convertToRelativeTime($task['created']);

$created = $faker->dateTimeBetween('-1 month', $endDate)
    ->format('Y-m-d H:i:s');

return [
    'description' => $faker->description(),
    'price' => random_int($minPrice, $task['price']),
    'task_id' => $task['id'],
    'is_refused' => $faker->boolean(30),
    'performer_id' => $performerId,
    'created' => $created
];
