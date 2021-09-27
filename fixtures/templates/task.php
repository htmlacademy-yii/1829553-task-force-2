<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

use app\fixtures\RoleFixture;
use app\fixtures\UserFixture;
use app\models\City;
use app\models\Skill;

$skillIds = Skill::find()
    ->select('id')
    ->column();

$cityIds = City::find()
    ->select('id')
    ->column();

$roleFixture = new RoleFixture();
$specialistRoleID = $roleFixture->getRoleIDByName($roleFixture->getRoleNameSpecialist());
$customerRoleID = $roleFixture->getRoleIDByName($roleFixture->getRoleNameCustomer());

$userFixture = new UserFixture();
$idSpecialist = $userFixture->getRandomUserIDByRole($specialistRoleID);
$idCustomer = $userFixture->getRandomUserIDByRole($customerRoleID);

$deadline = $faker->dateTimeBetween('+1 week', '+2 month')
    ->format('Y-m-d H:i:s');
$created = $faker->dateTimeBetween('-1 months', '-1 week')
    ->format('Y-m-d H:i:s');

$data = $faker->getData();
$name = $data['name'];
$description = $data['description'];

return [
    'id_specialist' => $idSpecialist,
    'id_customer' => $idCustomer,
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
];
