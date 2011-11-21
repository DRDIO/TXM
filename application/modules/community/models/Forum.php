<?php

class Community_Model_Forum extends Main_Model_Abstract
{
    public static function getForumInfo($forumId)
    {
        $db = self::getDb();

        $select = $db->select()
            ->from(array('f'  => 'forums'), array(
                'forumId'     => 'ft.id_forum',
                'forumName'   => 'f.name',
                'topicCount'  => 'COUNT(*)',
                'maxViews'    => 'MAX(ft.views)',
                'maxReplies'  => 'MAX(ft.replies)'))
            ->joinLeft(array('ft' => 'forums_topics'), 'f.id = ft.id_forum', array())
            ->group('ft.id_forum')
            ->where('f.id = ?', $forumId)
            ->where('f.status = 0')
            ->where('ft.id_topic_moved = 0')
            ->where('ft.deleted = 0');

        $row = $db->fetchRow($select);
        return $row;
    }

    public static function getTopicsSelect($forumId, $sortBy, $sortDir, $maxViews, $maxReplies)
    {
        $db = self::getDb();

        $select = $db->select()
            ->from(array('ft' => 'forums_topics'), array(
                'ft.id',
                'ft.id_post',
                'ft.id_user',
                'ft.title',
                'ft.date',
                'ft.views',
                'ft.replies',
                'author_link_name' => 'ftu.link_name',
                'author_nick_name' => 'ftu.nick_name',
                'reply_user_id'    => 'ftpu.id',
                'reply_link_name'  => 'ftpu.link_name',
                'reply_nick_name'  => 'ftpu.nick_name',
                'rating'           => '(1)',
                'popular'          => '(ft.views/' . $maxViews . ')+(ft.replies/' . $maxReplies . ')'))
            ->joinLeft(array('ftp' => 'forums_topics_posts'), 'ftp.id = ft.id_user_last', array())
            ->joinLeft(array('ftu' => 'txm_users'), 'ftu.id = ft.id_user', array())
            ->joinLeft(array('ftpu' => 'txm_users'), 'ftpu.id = ftp.id_user', array())
            ->where('ft.id_forum = ?', $forumId)
            ->where('ft.id_topic_moved = 0')
            ->where('ft.deleted = 0')
            ->order($sortBy . ' ' . $sortDir);

        return $select;
    }
}