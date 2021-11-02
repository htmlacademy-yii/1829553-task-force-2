<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

$status = $faker->status($index);

return [
    'system_name' => $status['system_name'],
    'human_name' => $status['human_name'],
];
