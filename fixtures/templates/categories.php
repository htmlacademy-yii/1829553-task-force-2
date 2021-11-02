<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

$category = $faker->category($index);

return [
    'name' => $category['name'],
    'icon' => $category['icon'],
];
