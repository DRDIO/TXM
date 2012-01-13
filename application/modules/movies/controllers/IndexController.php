<?php

class Movies_IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Get Movie Lists
        $newMovies     = Movies_Model_Index::getNewMovies();
        $popularMovies = Movies_Model_Index::getPopularMovies();
        $bestMovies    = Movies_Model_Index::getBestMovies();
        $weakMovies    = Movies_Model_Index::getWeakMovies();

        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Load View
        $this->view->newMovies     = $newMovies;
        $this->view->popularMovies = $popularMovies;
        $this->view->bestMovies    = $bestMovies;
        $this->view->weakMovies    = $weakMovies;

        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Set Page Title, Javascript, and CSS
        $this->view->headTitle('Movies');
    }
}