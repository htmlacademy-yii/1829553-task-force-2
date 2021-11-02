<?php

namespace app\fixtures\providers;

use Faker\Provider\Base;
use yii\db\Exception;

class Category extends Base
{

    private const CATEGORIES = [
        [
            'name' => 'Переводы',
            'icon' => 'translation',
        ],
        [
            'name' => 'Уборка',
            'icon' => 'clean',
        ],
        [
            'name' => 'Переезды',
            'icon' => 'cargo',
        ],
        [
            'name' => 'Компьютерная помощь',
            'icon' => 'neo',
        ],
        [
            'name' => 'Ремонт квартирный',
            'icon' => 'flat',
        ],
        [
            'name' => 'Ремонт техники',
            'icon' => 'repair',
        ],
        [
            'name' => 'Красота',
            'icon' => 'beauty',
        ],
        [
            'name' => 'Фото',
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
