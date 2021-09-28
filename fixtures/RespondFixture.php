<?php

namespace app\fixtures;

use yii\test\ActiveFixture;

class RespondFixture extends ActiveFixture
{
    public $modelClass = 'app\models\Respond';
    public $depends = [
        'app\fixtures\UserFixture',
        'app\fixtures\TaskFixture',
    ];
}
