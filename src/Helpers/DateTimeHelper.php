<?php

namespace Mar4hk0\Helpers;

use DateInterval;
use DateTime;

class DateTimeHelper
{
    public static function diff(DateTime $dateTime): DateInterval
    {
        $currentDate = new DateTime();
        return $currentDate->diff($dateTime);
    }
}
