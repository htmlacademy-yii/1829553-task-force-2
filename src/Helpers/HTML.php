<?php

namespace Mar4hk0\Helpers;

class HTML
{
    public static function starts(?float $rating, string $size = 'small'): string
    {
        if (is_null($rating)) {
            return '';
        }
        $output = '<div class="stars-rating ' . $size . '">';
        foreach(static::getStarts($rating) as $index => $isFill) {
            if ($isFill) {
                $output .= '<span class="fill-star">&nbsp;</span>';
            }
            else {
                $output .= '<span>&nbsp;</span>';
            }
        }
        $output .= '</div>';
        return $output;
    }

    public static function getStarts(float $rating): array
    {
        $result = [];
        $rating = round($rating);
        for ($i = 1; $i <= 5; $i++) {
            $result[$i] = 0;
            if ($i <= $rating) {
                $result[$i] = 1;
            }
        }
        return $result;
    }
}
