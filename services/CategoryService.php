<?php

namespace app\services;

class CategoryService
{
    /* @var $categories array of Category */
    private array $categories;

    public function __construct(array $categories)
    {
        $this->categories = $categories;
    }

    public function getHumanName(?int $categoryId): string
    {
        return $this->categories[$categoryId]->human_name ?? 'Категория не существует';
    }
}
