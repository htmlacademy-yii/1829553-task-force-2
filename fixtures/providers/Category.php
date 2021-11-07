<?php

namespace app\fixtures\providers;

use Faker\Provider\Base;
use yii\db\Exception;

class Category extends Base
{

    private const CATEGORIES = [
        [
            'human_name' => 'Переводы',
            'system_name' => 'translation',
        ],
        [
            'human_name' => 'Уборка',
            'system_name' => 'clean',
        ],
        [
            'human_name' => 'Переезды',
            'system_name' => 'cargo',
        ],
        [
            'human_name' => 'Компьютерная помощь',
            'system_name' => 'neo',
        ],
        [
            'human_name' => 'Ремонт квартирный',
            'system_name' => 'flat',
        ],
        [
            'human_name' => 'Ремонт техники',
            'system_name' => 'repair',
        ],
        [
            'human_name' => 'Красота',
            'system_name' => 'beauty',
        ],
        [
            'human_name' => 'Фото',
            'system_name' => 'photo',
        ],
    ];

    public function category(int $index): array
    {
        if (empty(self::CATEGORIES[$index])) {
            throw new Exception('Does not exist Category');
        }
        return self::CATEGORIES[$index];
    }
}
