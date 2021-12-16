<?php

namespace app\services\Geo;

class House extends Street
{
    protected string $house;

    public function __construct(string $locality, string $street, string $house, array $geoCoordinates)
    {
        parent::__construct($locality, $street, $geoCoordinates);
        $this->house = $house;
    }

    public function getFullAddress(): string
    {
        return parent::getFullAddress() . ', ' . $this->house;
    }
}
