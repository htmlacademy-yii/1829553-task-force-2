<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

use app\models\Task;

$created = $faker->dateTimeBetween('-2 weeks', '-1 week')
    ->format('Y-m-d H:i:s');

$tasks = Task::find()
    ->select('id')
    ->column();

$data = $faker->getData();
$grade = $data['grade'];
$review = $data['review'];

return [
    'id_task' => $tasks[$index],
    'review' => $review,
    'grade' => $grade,
    'created' => $created
];
