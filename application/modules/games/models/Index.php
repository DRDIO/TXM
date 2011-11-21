<?php

class Games_Model_Index extends Main_Model_Abstract
{
    public static function getGamesSelect()
    {
        $db     = self::getDb();
        $select = $db->select()
            ->from('games', array(
                'id',
                'title',
                'id_type',
                'score_offset'))
            ->where('deleted = 0');

        return $select;
    }

    public static function getNewGames()
    {
        $select = self::getGamesSelect()
            ->order('date DESC')
            ->limitPage(1, 15);

        $data = $select->getAdapter()->fetchAll($select);
        return $data;
    }

    public static function getPopularGames()
    {
        $select = self::getGamesSelect()
            ->order('vote_offset DESC')
            ->limitPage(1, 15);

        $data = $select->getAdapter()->fetchAll($select);
        return $data;
    }

    public static function getBestGames()
    {
        $select = self::getGamesSelect()
            ->order('score_offset DESC')
            ->limitPage(1, 15);

        $data = $select->getAdapter()->fetchAll($select);
        return $data;
    }

    public static function getWeakGames()
    {
        $select = self::getGamesSelect()
            ->where('vote_offset < 5')
            ->order('date ASC')
            ->limitPage(1, 15);

        $data = $select->getAdapter()->fetchAll($select);
        return $data;
    }
}