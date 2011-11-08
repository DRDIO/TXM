<?php

class Movies_ViewController extends Zend_Controller_Action
{
    public function indexAction()
    {
        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Get Movie ID and Info
        $movieId   = $this->_getParam('id');
        $movieInfo = Movies_Model_View::getInfo($movieId);

        if (!$movieInfo) {
            throw Exception('Invalid Movie ID');
        }

            // Increment View Count
        Movies_Model_View::updateViewCount($movieId);

        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Grab Five Most Recent Reviews
        $reviews = Movies_Model_View::getReviews($movieId);
        $movieInfo['reviews'] = sizeof($reviews);

        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Build Additional Fields
        $movieInfo['title_link'] = Helper_String::toLink($movieInfo['title']);
        $movieInfo['title']      = htmlentities($movieInfo['title'], ENT_QUOTES, 'ISO-8859-1', false);
        $movieInfo['nick_name']  = htmlentities($movieInfo['nick_name']);
        $movieInfo['size']       = sprintf('%.1f', $movieInfo['size'] / 1000000);
        $movieInfo['date']       = Helper_Time::getLongDateTime($movieInfo['date']);
        $movieInfo['commentary'] = preg_replace(array("/\[url=(.*?)\](.*?)\[\/url\]/i", "/([^a-z0-9])((?:https?:\/\/)?(?:[a-z0-9-_]{1-63}\.)*(?:[a-z0-9][a-z0-9-]{1,61}[a-z0-9]\.)(?:[a-z]{2,6}|[a-z]{2}\.[a-z]{2})(?:.*?))($|&lt;|&gt;|&quot;| )/i"), array("$1 ($2)", "$1<a href=\"$2\" target=\"_blank\">[Link]</a>$3"), htmlentities($movieInfo["commentary"], ENT_QUOTES, 'ISO-8859-1', false));
        $movieInfo['score_icon'] = sprintf('%.3f', $movieInfo['score']);

        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Load View
        $this->view->movieInfo = $movieInfo;
        $this->view->reviews   = $reviews;

        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Set Page Title, Javascript, and CSS
        $this->view->headTitle('Movies')->headTitle($movieInfo['title']);
        $this->view->headLink()->appendStylesheet('/css/movies/index.css');
        $this->view->headScript()->appendFile('/js/movies/index.js');
    }
}