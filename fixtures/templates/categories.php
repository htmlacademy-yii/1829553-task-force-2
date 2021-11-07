<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

$category = $faker->category($index);

return [
    'human_name' => $category['human_name'],
    'system_name' => $category['system_name'],
];
