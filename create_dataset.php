<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Mar4hk0\Fakers\Faker;

try {
    $faker = new Faker();
    $faker->run();
} catch (Exception $e) {
    var_dump($e->getMessage());
}
