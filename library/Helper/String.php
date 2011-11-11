<?php

class Helper_String
{
    public static function toLink($string)
    {
        return strtolower(preg_replace(array('/(-|:)/', '/([a-z])([A-Z])/', '/[^A-z0-9 ]/', '/ +/'), array(' ', '$1 $2', '', '-'), html_entity_decode($string, ENT_QUOTES)));
    }

    public static function sanitize($string)
    {
        return htmlentities($string, ENT_QUOTES, 'ISO-8859-1', false);
    }
}