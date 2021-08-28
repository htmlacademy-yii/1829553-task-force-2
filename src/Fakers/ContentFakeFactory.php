<?php

namespace Mar4hk0\Fakers;

use Mar4hk0\Exceptions\ExceptionContentFakeFactory;

class ContentFakeFactory
{
    public static function generate(string $type)
    {
        switch ($type) {
            case 'string':
                $result = self::generateRandomString(16);
                break;
            case 'text':
                $result = self::generateRandomText(16);
                break;
            case 'int':
                $result = rand(1, 20);
                break;
            case 'float':
                $result = self::generateFloat(1, 20);
                break;
            case 'email':
                $result = self::generateEmail();
                break;
            case 'date':
                $result = self::generateDate();
                break;
            case 'bool':
                $result = self::generateBool();
                break;
            default:
                throw new ExceptionContentFakeFactory();

        }
        return $result;
    }

    private static function generateBool(): string
    {
        return (bool)rand(0,1);
    }

    private static function generateDate(): string
    {
        return date("Y-m-d H:i:s", mt_rand(1566898037,1630056452));
    }

    private static function generateEmail(): string
    {
        return 'email' . self::generateRandomString(5) . '@fakeemail.com';
    }

    private static function generateFloat(int $min, int $max): float
    {
        $number = rand($min, $max) . rand($min,$max);
        return floatval($number);
    }

    private static function generateRandomText($numWords = 20): string
    {
        $result = [];
        for($i = 0; $i < $numWords; $i++) {
            $result[] = static::generateRandomString();
        }
        return implode(' ', $result);
    }

    private static function generateRandomString(int $length = 10): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
