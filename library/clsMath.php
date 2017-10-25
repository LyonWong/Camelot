<?php


class clsMath
{
    public static function division($dividend, $divisor, $precision=2)
    {
        if ($divisor) {
            return round($dividend / $divisor, $precision);
        } else {
            return false;
        }
    }

    public static function percent($base, $part, $precision=2)
    {
        return self::division($base*100, $part, $precision);
    }

}