<?php

class Main_IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Generate Top Bar Movies
        $randomMovies = Main_Model_Index::getRandomMovies();
        
        foreach ($randomMovies as $id => $row) {
            if (!$row['synopsis']) {
                $randomMovies[$id]['synopsis'] = '...';
            }
        }
        
        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Generate Daily News Posts
        $dailyNews = Main_Model_Index::getDailyNews();
        
        foreach ($dailyNews as $id => $row) {
            $dailyNews[$id]['title_link'] = Helper_String::toLink($row['title']);
            $dailyNews[$id]['title']      = htmlentities($row['title']);
            $dailyNews[$id]['date']       = Helper_Time::getLongDateTime($row['date']);
        }

        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Get News Posts for Sidebar
        $sidebarNews = Main_Model_Index::getSidebarNews();

        foreach($sidebarNews as $id => $row) {
            $sidebarNews[$id]['title_link'] = $row['title'];
            $sidebarNews[$id]['title']      = htmlentities($row['title']);
        }

        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Load View
        $this->view->randomMovies = $randomMovies;
        $this->view->dailyNews    = $dailyNews;
        $this->view->sidebarNews  = $sidebarNews;

        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Set Page Title, Javascript, and CSS
        $this->view->headTitle('Indie Flash Movies & Games');
        $this->view->headLink()->appendStylesheet($this->view->siteAssets . 'css/index/index.css');
        $this->view->headScript()->appendFile($this->view->siteAssets . 'js/index/index.js');
    }
}