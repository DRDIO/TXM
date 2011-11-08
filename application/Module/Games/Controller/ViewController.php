<?php

class Games_ViewController extends Zend_Controller_Action
{
    public function indexAction()
    {
        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Get Game ID and Info
        $gameId   = $this->_getParam('id');
        $gameInfo = Games_Model_View::getInfo($gameId);

        if (!$gameInfo) {
            throw Exception('Invalid Game ID');
        }

            // Increment View Count
        Games_Model_View::updateViewCount($gameId);

        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Grab Five Most Recent Reviews
        $reviews = Games_Model_View::getReviews($gameId);
        $gameInfo['reviews'] = sizeof($reviews);

        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Build Additional Fields
        $gameInfo['title_link'] = Helper_String::toLink($gameInfo['title']);
        $gameInfo['title']      = htmlentities($gameInfo['title'], ENT_QUOTES, 'ISO-8859-1', false);
        $gameInfo['nick_name']  = htmlentities($gameInfo['nick_name']);
        $gameInfo['size']       = sprintf('%.1f', $gameInfo['size'] / 1000000);
        $gameInfo['date']       = Helper_Time::getLongDateTime($gameInfo['date']);
        $gameInfo['commentary'] = preg_replace(array("/\[url=(.*?)\](.*?)\[\/url\]/i", "/([^a-z0-9])((?:https?:\/\/)?(?:[a-z0-9-_]{1-63}\.)*(?:[a-z0-9][a-z0-9-]{1,61}[a-z0-9]\.)(?:[a-z]{2,6}|[a-z]{2}\.[a-z]{2})(?:.*?))($|&lt;|&gt;|&quot;| )/i"), array("$1 ($2)", "$1<a href=\"$2\" target=\"_blank\">[Link]</a>$3"), htmlentities($gameInfo["commentary"], ENT_QUOTES, 'ISO-8859-1', false));
        $gameInfo['score_icon'] = sprintf('%.3f', $gameInfo['score']);

        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Load View
        $this->view->gameInfo = $gameInfo;
        $this->view->reviews   = $reviews;

        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Set Page Title, Javascript, and CSS
        $this->view->headTitle('Games')->headTitle($gameInfo['title']);
        $this->view->headLink()->appendStylesheet('/css/games/index.css');
        $this->view->headScript()->appendFile('/js/games/index.js');
    }
}