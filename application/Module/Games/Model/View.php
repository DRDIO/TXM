<?php

class Games_Model_View extends Main_Model_Abstract
{
    public static function getInfo($gameId)
    {
        $db     = self::getDb();
        $select = $db->select()
            ->from(array('m' => 'games'), array(
                'm.id',
                'm.id_user',
                'm.title',
                'u.link_name',
                'u.nick_name',
                'web_url' => 'u.user_website',
                'web_title' => 'u.user_website_title',
                'm.title',
                'm.synopsis',
                'm.commentary',
                'rating' => 'm.id_rating',
                'type' => 'm.id_type',
                'views' => 'm.view_offset',
                'votes' => 'm.vote_offset',
                'score' => 'm.score_offset',
                'm.size',
                'm.width',
                'm.height',
                'm.date'))
            ->joinInner(array('u' => 'txm_users'),
                $db->quoteIdentifier('m.id_user') . ' = ' .
                $db->quoteIdentifier('u.id'), array())
            ->where('m.id = ?', $gameId)
            ->where('m.deleted = 0');

        $data = $db->fetchRow($select);
        return $data;
    }

    public static function updateViewCount($gameId)
    {
        $db       = self::getDb();
        $affected = $db->update('games', array(
            'view_offset' => new Zend_Db_Expr('view_offset + 1')
        ), $db->quoteIdentifier('id') . ' = ' . $db->quote($gameId));

        return $affected;
    }

    public static function getReviews($gameId)
    {
        $db     = self::getDb();
        $select = $db->select()
            ->from(array('r' => 'movies_comments'), array(
                'r.id',
                'r.id_user',
                'u.link_name',
                'u.nick_name',
                'r.comment',
                'r.reply',
                'r.status',
                'r.date_comment',
                'r.date_reply'))
            ->joinInner(array('u' => 'txm_users'),
                    $db->quoteIdentifier('r.id_user') . ' = ' .
                    $db->quoteIdentifier('u.id'), array())
            ->where('r.id_movie = ?', $gameId)
            ->where('r.status = 0')
            ->order('r.date_comment DESC')
            ->limitPage(1, 5);

        $statement = $db->query($select);
        $data      = array();
        while ($row = $statement->fetch()) {
            $row['date_comment'] = Helper_Time::getLongDateTime($row['date_comment']);
            $row['comment']      = Helper_String::sanitize($row['comment']);
            $row['reply']        = Helper_String::sanitize($row['comment']);
            
            $data[] = $row;
        }
        return $data;
    }
}