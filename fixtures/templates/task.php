<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

use app\fixtures\UserFixture;
use app\models\City;
use app\models\Skill;
use app\models\Task;

$skillIds = Skill::find()
    ->select('id')
    ->column();

$cityIds = City::find()
    ->select('id')
    ->column();

$userFixture = new UserFixture();
$specialistId = $userFixture->getRandomSpecialistId();
$customerId = $userFixture->getRandomCustomerId();

$deadline = $faker->dateTimeBetween('+1 week', '+2 month')
    ->format('Y-m-d H:i:s');
$created = $faker->dateTimeBetween('-1 months', '-1 week')
    ->format('Y-m-d H:i:s');

$data = $faker->getTaskData();
$name = $data['name'];
$description = $data['description'];

$specialistId = $faker->boolean() ? $specialistId : null;
$status = Task::NEW;
if ($specialistId) {
    $status = $faker->randomElement(Task::STATUSES);
}

return [
    'id_specialist' => $specialistId,
    'id_customer' => $customerId,
    'name' => $name,
    'description' => $description,
    'price' => rand(100, 80000),
    'deadline' => $deadline,
    'remote' => $faker->boolean(),
    'id_skill' => $faker->randomElement($skillIds),
    'id_city' => $faker->randomElement($cityIds),
    'longitude' => null,
    'latitude' => null,
    'address' => '',
    'created' => $created,
    'status' => $status
];
