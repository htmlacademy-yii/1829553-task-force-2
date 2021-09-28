<?php

namespace app\fixtures\providers;

use Faker\Provider\Base;

class Review extends Base
{
    protected static $data = [
        [
            'review' => 'Все сделал хорошо. Остался доволен',
            'grade' => 5
        ],
        [
            'review' => 'Опоздал, но сделал все отлично',
            'grade' => 4
        ],
        [
            'review' => 'Долго шел, работу сделал, криво-косо',
            'grade' => 4
        ],
        [
            'review' => 'Пришел без инструмента, работу не сделал мои инструментом',
            'grade' => 3
        ],
        [
            'review' => 'Не пришел, не позвонил, потерялся',
            'grade' => 2
        ],
        [
            'review' => 'Все испортил!!!!',
            'grade' => 1
        ],
    ];

    public function getData()
    {
        return static::randomElement(static::$data);
    }
}
