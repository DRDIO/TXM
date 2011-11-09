<?php

class Helper_Time
{
    public static function getFancyOffset($dateTime)
    {
        $offset = time() - strtotime($dateTime);

        if ($offset >= 31556926) {
            $fancyOff = floor($offset / 31556926) . ' Years';
        } else if ($offset >= 2629743) {
            $fancyOff = floor($offset / 2629743) . ' Months';
        } else if ($offset >= 604800) {
            $fancyOff = floor($offset / 604800) . ' Weeks';
        } else if ($offset >= 86400) {
            $fancyOff = floor($offset / 86400) . ' Days';
        } else if ($offset >= 3600) {
            $fancyOff = floor($offset / 3600) . ' Hours';
        } else if ($offset >= 60) {
            $fancyOff = floor($offset / 60) . ' Minutes';
        } else {
            $fancyOff = $offset . ' Seconds';
        }

        return $fancyOff;
    }

    public static function getLongDateTime($dateTime)
    {
        return date('F jS, Y \a\t h:i a', strtotime($dateTime));
    }
}