<?php

namespace Mar4hk0\Helpers;

use DateInterval;
use DateTime;

class DateTimeHelper
{

    public static function convertTimeToRelative(string $created): string
    {
        $interval = self::diff(new DateTime($created));
        if ($year = $interval->format('%y')) {
            return StringHelper::getPluralNoun($year, 'год', 'года', 'лет');
        }
        if ($month = $interval->format('%m')) {
            return StringHelper::getPluralNoun($month, 'месяц', 'месяца', 'месяцев');
        }
        if ($day = $interval->format('%d')) {
            return StringHelper::getPluralNoun($day, 'день', 'дня', 'дней');
        }
        if ($hour = $interval->format('%h')) {
            return StringHelper::getPluralNoun($hour, 'час', 'часа', 'часов');
        }
        if ($minute = $interval->format('%i')) {
            return StringHelper::getPluralNoun($minute, 'минута', 'минуты', 'минут');
        }
        return 'только что';
    }

    public static function diff(DateTime $dateTime): DateInterval
    {
        $currentDate = new DateTime();
        return $currentDate->diff($dateTime);
    }

}
