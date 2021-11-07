<?php

namespace app\fixtures;

use yii\test\ActiveFixture;

class PerformerCategoriesFixture extends ActiveFixture
{
    public $modelClass = 'app\models\PerformerCategories';
    public $depends = [
        'app\fixtures\UserFixture',
        'app\fixtures\CategoryFixture',
    ];
}
