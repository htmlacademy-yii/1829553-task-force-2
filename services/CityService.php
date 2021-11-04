<?php

namespace app\services;

class CityService
{
    /* @var $cities array of City */
    private array $cities;

    public function __construct(array $cities)
    {
        $this->cities = $cities;
    }

    public function getHumanName(?int $cityId): string
    {
        return $this->cities[$cityId]->name ?? 'Работа удаленная';
    }
}
