<?php

namespace app\fixtures\providers;

use Faker\Provider\Base;
use yii\db\Exception;

class Status extends Base
{

    private const STATUSES = [
        [
            'system_name' => \app\models\Status::STATUS_NEW,
            'human_name' => 'Новое',
        ],
        [
            'system_name' => \app\models\Status::STATUS_CANCELED,
            'human_name' => 'Отменено',
        ],
        [
            'system_name' => \app\models\Status::STATUS_IN_PROCESS,
            'human_name' => 'В работе',
        ],
        [
            'system_name' => \app\models\Status::STATUS_COMPLETED,
            'human_name' => 'Выполнено',
        ],
        [
            'system_name' => \app\models\Status::STATUS_FAILED,
            'human_name' => 'Провалено',
        ],
    ];

    public function status(int $index): array
    {
        if (empty(self::STATUSES[$index])) {
            throw new Exception('Does not exist Status');
        }
        return self::STATUSES[$index];
    }
}
