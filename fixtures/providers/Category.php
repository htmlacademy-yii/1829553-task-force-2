<?php

namespace app\fixtures\providers;

use Faker\Provider\Base;
use yii\db\Exception;

class Category extends Base
{

    private const CATEGORIES = [
        [
            'human_name' => 'Переводы',
            'icon' => 'translation',
        ],
        [
            'human_name' => 'Уборка',
            'icon' => 'clean',
        ],
        [
            'human_name' => 'Переезды',
            'icon' => 'cargo',
        ],
        [
            'human_name' => 'Компьютерная помощь',
            'icon' => 'neo',
        ],
        [
            'human_name' => 'Ремонт квартирный',
            'icon' => 'flat',
        ],
        [
            'human_name' => 'Ремонт техники',
            'icon' => 'repair',
        ],
        [
            'human_name' => 'Красота',
            'icon' => 'beauty',
        ],
        [
            'human_name' => 'Фото',
            'icon' => 'photo',
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
