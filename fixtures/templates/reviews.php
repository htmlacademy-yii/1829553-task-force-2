<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

$created = $faker->dateTimeBetween('-2 weeks', '-1 week')
    ->format('Y-m-d H:i:s');

$taskFixture = new \app\fixtures\TaskFixture();
$tasks = $taskFixture->getTasks(\app\models\Status::STATUS_COMPLETED);
$task = $tasks[$index % count($tasks)];

$data = $faker->getData();
$grade = $data['grade'];
$review = $data['review'];

return [
    'client_id' => $task['client_id'],
    'performer_id' => $task['performer_id'],
    'task_id' => $task['id'],
    'description' => $review,
    'grade' => $grade,
    'created' => $created,
];
