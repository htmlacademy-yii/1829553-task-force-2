<?php

namespace app\services\Geo;

class Street extends GeoPoint
{
    protected string $street;

    public function __construct(string $locality, string $street, array $geoCoordinates)
    {
        $this->locality = $locality;
        $this->street = $street;
        $this->long = $geoCoordinates['long'];
        $this->lat = $geoCoordinates['lat'];
    }

    public function getFullAddress(): string
    {
        return $this->street;
    }

}
