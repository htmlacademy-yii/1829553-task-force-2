<?php

namespace app\fixtures;

use DateTime;

class Helper
{
    public static function convertToRelativeTime(string $date, string $currentDate = 'now'): string
    {
        $dateTime = new DateTime($date);
        $currentDate = new DateTime($currentDate);
        $diff = $currentDate->diff($dateTime);
        return $diff->format('%R%a days');
    }

}
