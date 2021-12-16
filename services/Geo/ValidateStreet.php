<?php

namespace app\services\Geo;

class ValidateStreet implements Validate
{
    private ?string $locality;
    private ?string $street;

    public function __construct(?string $locality, ?string $street)
    {
        $this->locality = $locality;
        $this->street = $street;
    }

    public function check(): bool
    {
        return !empty($this->locality) && !empty($this->street);
    }
}
