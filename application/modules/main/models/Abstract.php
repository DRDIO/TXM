<?php

class Main_Model_Abstract
{
    public static function getDb()
    {
        return Zend_Db_Table::getDefaultAdapter();
    }
}