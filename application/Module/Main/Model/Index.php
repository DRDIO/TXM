<?php

class Main_Model_Index extends Main_Model_Abstract
{
    public static function getRandomMovies()
    {
        $db = self::getDb();
        
        $select = $db->select()
            ->from('movies', array(
                'id',
                'title',
                'synopsis'))
            ->where('approved = 1')
            ->where('deleted = 0')
            ->order('RAND()')
            ->limit(36);

        return $db->fetchAssoc($select);
    }

    public static function getDailyNews()
    {
        $db = self::getDb();

        $select = $db->select()
            ->from(array('t' => 'forums_topics'), array(
                't.id',
                't.id_user',
                't.title',
                't.date',
                't.views',
                't.replies',
                'p.post',
                'u.link_name',
                'u.nick_name'))
            ->joinInner(array('p' => 'forums_topics_posts'),
                't.id_post = p.id', array())
            ->joinInner(array('u' => 'txm_users'),
                't.id_user = u.id', array())
            ->where('t.id_forum = ?', 2)
            ->where('t.deleted = 0')
            ->order('t.date DESC')
            ->limitPage(1, 5);

        return $db->fetchAssoc($select);
    }

    public static function getSidebarNews()
    {
        $db = self::getDb();

        $select = $db->select()
            ->from(array('f' => 'forums'), array(
                't.id',
                't.id_user',
                't.title'))
            ->joinInner(array('t' => 'forums_topics'),
                'f.id = t.id_forum', array())
            ->where('f.id = ?', 2)
            ->where('t.deleted = 0')
            ->order('t.date DESC')
            ->limitPage(5, 10);

        return $db->fetchAssoc($select);
    }
}