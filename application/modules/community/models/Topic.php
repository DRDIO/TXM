<?php

class Community_Model_Topic extends Main_Model_Abstract
{
    public static function getTopicInfo($topicId)
    {
        $db = self::getDb();

        $select = $db->select()
            ->from(array('ft' => 'forums_topics'), array(
                'topicId'     => 'ft.id',
                'forumId'     => 'ft.id_forum',
                'forumName'   => 'f.name',
                'topicName'   => 'ft.title',
                'ft.views',
                'ft.replies',
                'threadCount' => 'COUNT(*)'))
            ->joinLeft(array('f' => 'forums'), 'f.id = ft.id_forum', array())
            ->joinLeft(array('ftp' => 'forums_topics_posts'), 'ft.id = ftp.id_topic', array())
            ->group('ftp.id_topic')
            ->where('ft.id = ?', $topicId)
            ->where('f.status = 0')
            ->where('ft.id_topic_moved = 0')
            ->where('ft.deleted = 0');

        $row = $db->fetchRow($select);
        return $row;
    }

    public static function getThreadsSelect($topicId, $sortBy, $sortDir)
    {
        $db = self::getDb();

        $select = $db->select()
            ->from(array('ftp' => 'forums_topics_posts'), array(
                'ftp.id',
                'ftp.id_topic',
                'ftp.id_user',
                'ftp.post',
                'ftp.date',
                'u.link_name',
                'u.nick_name'))
            ->joinLeft(array('u' => 'txm_users'), 'u.id = ftp.id_user', array())
            ->where('ftp.id_topic = ?', $topicId)
            ->where('ftp.deleted = 0')
            ->order($sortBy . ' ' . $sortDir);

        return $select;
    }
}
