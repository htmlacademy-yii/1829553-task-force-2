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

    public function getHumanCategories(): array
    {
        $result = [];
        foreach ($this->categories as $categoryId => $item) {
            $result[$categoryId] = $item->human_name;
        }
        return $result;
    }
}
