<?php

class Admin_Model_Index extends Main_Model_Abstract
{
    public static function getRandom()
    {
        return uniqid();
    }
}