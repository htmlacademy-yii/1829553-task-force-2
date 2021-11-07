<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

$city = $faker->getCityName($index);

return [
    'name' => $city[0],
    'lat' => $city[1],
    'long' => $city[2],
];
