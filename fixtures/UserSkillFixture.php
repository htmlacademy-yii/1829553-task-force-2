<?php

namespace app\fixtures;

use yii\test\ActiveFixture;

class UserSkillFixture extends ActiveFixture
{
    public $modelClass = 'app\models\UserSkill';
    public $depends = [
        'app\fixtures\UserFixture',
    ];
}
