<?php

class Community_Model_Index extends Main_Model_Abstract
{
    public static function getForums()
    {
        $db = self::getDb();

        $select = $db->select()
            ->from('forums', array(
                'id',
                'name',
                'description'))
            ->where('status = 0')
            ->order('order');

        return $db->fetchAssoc($select);
    }
}