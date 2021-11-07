<?php

namespace Mar4hk0\Helpers;

class StringHelper
{
    public static function getPluralNoun(int $amount, string $singular, string $plural, string $other): string
    {
        $noun = $amount%10==1&&$amount%100!=11?$singular:($amount%10>=2&&$amount%10<=4&&($amount%100<10||$amount%100>=20)?$plural:$other);
        return $amount . ' ' . $noun;
    }
}
