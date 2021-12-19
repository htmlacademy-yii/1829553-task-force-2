<?php

namespace app\services\Geo;

abstract class Geo
{
    protected array $data;

    abstract public function getListAddress(): array;
}
