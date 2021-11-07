<?php

namespace app\fixtures;

use yii\test\ActiveFixture;

class BidFixture extends ActiveFixture
{
    public $modelClass = 'app\models\Bid';
    public $depends = [
        'app\fixtures\UserFixture',
        'app\fixtures\TaskFixture',
    ];



}
