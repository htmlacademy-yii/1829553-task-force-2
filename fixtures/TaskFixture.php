<?php

namespace app\fixtures;

use app\models\Task;
use yii\test\ActiveFixture;

class TaskFixture extends ActiveFixture
{
    public $modelClass = 'app\models\Task';
    public $depends = [
        'app\fixtures\UserFixture',
        'app\fixtures\StatusFixture',
    ];

    public function getTasks(string $statusSystemName)
    {
        $statusFixture = new StatusFixture();
        $status = $statusFixture->getStatus($statusSystemName);
        return Task::findAll(['status_id' => $status['id']]);
    }
}
