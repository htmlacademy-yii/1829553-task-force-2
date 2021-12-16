<?php

namespace app\services\Geo;

abstract class GeoPoint
{
    protected string $locality;
    protected string $lat;
    protected string $long;

    abstract public function getFullAddress(): string;

    public function getLat()
    {
        return $this->lat;
    }

    public function getLong()
    {
        return $this->long;
    }
}
