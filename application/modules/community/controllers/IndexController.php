<?php

class Community_IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Get Forum Data
        $forums = Community_Model_Index::getForums();

        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Load View
        $this->view->forums = $forums;

        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Set Page Title, Javascript, and CSS
        $this->view->headTitle('Community');
        $this->view->headLink()->appendStylesheet('/css/community/index.css');
        $this->view->headScript()->appendFile('/js/forums/index.js');
    }
}