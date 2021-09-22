<?php

namespace app\fixtures;

use yii\test\ActiveFixture;

class NotificationFixture extends ActiveFixture
{
    public $modelClass = 'app\models\Notification';
    public $depends = ['app\fixtures\UserFixture'];
}
