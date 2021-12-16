<?php

namespace app\services\Geo;

class ValidateHouse implements Validate
{
    private ?string $locality;
    private ?string $street;
    private ?string $house;

    public function __construct(?string $locality, ?string $street, ?string $house)
    {
        $this->locality = $locality;
        $this->street = $street;
        $this->house = $house;
    }

    public function check(): bool
    {
        return !empty($this->locality) && !empty($this->street) && !empty($this->house);
    }
}
