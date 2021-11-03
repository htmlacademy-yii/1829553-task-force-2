<?php

namespace app\fixtures;

use app\models\Status;
use yii\test\ActiveFixture;

class StatusFixture extends ActiveFixture
{
    public $modelClass = 'app\models\Status';
    public $tableName = 'statuses';

    public function getStatus(string $statusSystemName)
    {
        return Status::findOne(['system_name' => $statusSystemName]);
    }
}
