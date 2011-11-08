<?php

class Movies_Model_Index extends Main_Model_Abstract
{
    public static function getMoviesSelect()
    {
        $db     = self::getDb();
        $select = $db->select()
            ->from('movies', array(
                'id',
                'title',
                'id_type',
                'score_offset'))
            ->where('deleted = 0');

        return $select;
    }

    public static function getNewMovies()
    {
        $select = self::getMoviesSelect()
            ->order('date DESC')
            ->limitPage(1, 15);

        $data = $select->getAdapter()->fetchAll($select);
        return $data;
    }

    public static function getPopularMovies()
    {
        $select = self::getMoviesSelect()
            ->order('vote_offset DESC')
            ->limitPage(1, 15);

        $data = $select->getAdapter()->fetchAll($select);
        return $data;
    }

    public static function getBestMovies()
    {
        $select = self::getMoviesSelect()
            ->order('score_offset DESC')
            ->limitPage(1, 15);

        $data = $select->getAdapter()->fetchAll($select);
        return $data;
    }

    public static function getWeakMovies()
    {
        $select = self::getMoviesSelect()
            ->where('vote_offset < 5')
            ->order('date ASC')
            ->limitPage(1, 15);

        $data = $select->getAdapter()->fetchAll($select);
        return $data;
    }
}