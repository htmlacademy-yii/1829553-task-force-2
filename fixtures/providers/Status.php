<?php

namespace app\fixtures\providers;

use Faker\Provider\Base;
use yii\db\Exception;

class Status extends Base
{

    private const STATUSES = [
        [
            'system_name' => 'new',
            'human_name' => 'Новое',
        ],
        [
            'system_name' => 'canceled',
            'human_name' => 'Отменено',
        ],
        [
            'system_name' => 'in_process',
            'human_name' => 'В работе',
        ],
        [
            'system_name' => 'completed',
            'human_name' => 'Выполнено',
        ],
        [
            'system_name' => 'failed',
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
