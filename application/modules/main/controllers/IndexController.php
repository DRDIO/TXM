<?php

class Main_IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Generate Top Bar Movies
        $mediaShowcase = Main_Model_Index::getRandomShowcase();
        $mediaMovies   = Main_Model_Index::getRandomMedia('movies', 5);
        $mediaGames    = Main_Model_Index::getRandomMedia('games', 5);

        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Generate Daily News Posts
        $dailyNews = Main_Model_Index::getDailyNews(5, true);

        foreach ($dailyNews as $id => $row) {
            $dailyNews[$id]['title_link'] = Helper_String::toLink($row['title']);
            $dailyNews[$id]['title']      = htmlentities($row['title']);
            $dailyNews[$id]['date']       = Helper_Time::getLongDateTime($row['date']);
        }

        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Get News Posts for Sidebar
        $sidebarNews = Main_Model_Index::getSidebarNews(15, true);

        foreach($sidebarNews as $id => $row) {
            $sidebarNews[$id]['title_link'] = $row['title'];
            $sidebarNews[$id]['title']      = htmlentities($row['title']);
        }

        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Load View
        $this->view->mediaShowcase = $mediaShowcase;
        $this->view->mediaMovies   = $mediaMovies;
        $this->view->mediaGames    = $mediaGames;

        $this->view->dailyNews    = $dailyNews;
        $this->view->sidebarNews  = $sidebarNews;

        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Set Page Title, Javascript, and CSS
        $this->view->headTitle('Indie Flash Movies & Games');
        $this->view->headLink()->appendStylesheet($this->view->siteAssets . 'css/index/index.css');
        $this->view->headScript()->appendFile($this->view->siteAssets . 'js/index/index.js');
    }
}
