<?php

class TaskGeo
{
    private int $idCity;
    private float $longitude;
    private float $latitude;

    public function __construct(int $idCity)
    {
        $this->idCity = $idCity;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): void
    {
        $this->latitude = $latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): void
    {
        $this->longitude = $longitude;
    }

    public function getIdCity(): int
    {
        return $this->idCity;
    }

}
