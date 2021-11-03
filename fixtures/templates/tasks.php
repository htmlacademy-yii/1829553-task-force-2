<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

use app\fixtures\UserFixture;
use app\models\City;
use app\models\Category;
use app\models\Status;
use app\models\Task;


$userFixture = new UserFixture();
$clientId = $userFixture->getRandomClientId();

$categoriesIDs = Category::find()
    ->select('id')
    ->column();
$cityIds = City::find()
    ->select('id')
    ->column();
$statuses = Status::find()->all();
$status = $statuses[$index % count($statuses)];

$performerId = null;
if ($status['system_name'] == Status::STATUS_IN_PROCESS) {
    $performerId = $userFixture->getRandomPerformerId();
}
else if ($status['system_name'] == Status::STATUS_COMPLETED) {
    $performerId = $userFixture->getRandomPerformerId();
}
else if ($status['system_name'] == Status::STATUS_FAILED) {
    $performerId = $userFixture->getRandomPerformerId();
}

$deadline = null;
if ($faker->boolean()) {
    $deadline = $faker->dateTimeBetween('+1 week', '+2 month')
        ->format('Y-m-d H:i:s');
}

$cityId = null;
$address = null;
$long = null;
$lat = null;
if ($faker->boolean(80)) {
    $cityId = $faker->randomElement($cityIds);
    $city = City::findOne($cityId);
    $lat = $city['lat'];
    $long = $city['long'];
    $cityProvider = new \app\fixtures\providers\City($faker);
    $address = $cityProvider->getStreetHouse();
}

$price = null;
if ($faker->boolean(20)) {
    $price = random_int(100, 9999);
}

$data = $faker->getTaskData();
$title = $data['name'];
$description = $data['description'];

$created = $faker->dateTimeBetween('-1 months', '-1 week')
    ->format('Y-m-d H:i:s');

return [
    'title' => $title,
    'description' => $description,
    'city_id' => $cityId,
    'price' => $price,
    'category_id' => $faker->randomElement($categoriesIDs),
    'client_id' => $faker->randomElement($categoriesIDs),
    'performer_id' => $performerId,
    'deadline' => $deadline,
    'address' => $address,
    'long' => $long,
    'lat' => $lat,
    'created' => $created,
    'status_id' => $status['id']
];
