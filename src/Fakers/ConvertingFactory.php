<?php

namespace Mar4hk0\Fakers;

class ConvertingFactory
{
    public static function create(): ConvertingCSV
    {
        switch ($_ENV['convert_type']) {
            case 'MySQL':
                return new ConveringCSVMySQL();
        }
    }
}
