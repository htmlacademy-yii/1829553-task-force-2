<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

use app\fixtures\UserFixture;
use app\models\Category;

$userFixture = new UserFixture();
$performerIds = $userFixture->getAllPerformerId();
$performerId = $performerIds[$index % count($performerIds)];

$categories = Category::find()->all();
$category = $categories[$index % count($categories)];

return [
    'performer_id' => $performerId,
    'category_id' => $category['id'],
];
