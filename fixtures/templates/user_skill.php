<?php

/**
 * @var $faker \Faker\Generator
 * @var $index integer
 */

use app\fixtures\UserFixture;
use app\models\Skill;

$userFixture = new UserFixture();
$specialistIds = $userFixture->getAllSpecialistId();
$specialistId = $specialistIds[$index % count($specialistIds)];

$skills = Skill::find()->all();
$skill = $skills[$index % count($skills)];

return [
    'id_specialist' => $specialistId,
    'id_skill' => $skill['id'],
];
