<?php

class Games_IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Get Movie Lists
        $newGames     = Games_Model_Index::getNewGames();
        $popularGames = Games_Model_Index::getPopularGames();
        $bestGames    = Games_Model_Index::getBestGames();
        $weakGames    = Games_Model_Index::getWeakGames();

        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Load View
        $this->view->newGames     = $newGames;
        $this->view->popularGames = $popularGames;
        $this->view->bestGames    = $bestGames;
        $this->view->weakGames    = $weakGames;

        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Set Page Title, Javascript, and CSS
        $this->view->headTitle('Games');
    }
}