<?php

namespace Mar4hk0\Helpers;

class Price
{
    public static function getPriceHuman($price): string
    {
        $sign = '₽';
        if (empty($price)) {
            return 'Договорная';
        }
        return $price . ' ' . $sign;
    }
}
