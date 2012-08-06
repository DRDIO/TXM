<?php

class Main_Model_Index extends Main_Model_Abstract
{
    public static function getRandomMedia($type = 'movies', $limit = 5)
    {
        $db = self::getDb();

        $type = ($type == 'games') ? $type : 'movies';

        $select = $db->select()
            ->from($type, array(
                'id',
                'title',
                'synopsis'))
            ->where('approved = 1')
            ->where('deleted = 0')
            ->order('RAND()')
            ->limit($limit);

        $result = $db->fetchAssoc($select);

        foreach ($result as $id => $row) {
            $result[$id]['type'] = $type;

            if (!$row['synopsis']) {
                $result[$id]['synopsis'] = '...';
            }
        }

        return $result;
    }

    public static function getRandomShowcase()
    {
        $result = self::getRandomMedia('movies', 8) + self::getRandomMedia('games', 8);

        shuffle($result);

        return $result;
    }

    public static function getDailyNews($limit = 5, $random = false)
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
            ->limit($limit);

        if ($random) {
            $select->order('RAND()');
        } else {
            $select->order('t.date DESC');
        }

        return $db->fetchAssoc($select);
    }

    public static function getSidebarNews($limit = 10, $random = false)
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
            ->limit($limit);

        if ($random) {
            $select->order('RAND()');
        } else {
            $select->order('t.date DESC');
        }

        return $db->fetchAssoc($select);
    }
}
