<?php

class Community_ForumController extends Zend_Controller_Action
{
    public function indexAction()
    {
        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Get Forum ID and Current Page
        $forumId = $this->_getParam('id');
        $page    = $this->_getParam('page');
        $sortKey = $this->_getParam('sort');
        $dirKey  = $this->_getParam('dir');
        
        $forumInfo = Community_Model_Forum::getForumInfo($forumId);

        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Get Data With Sorting Options
        $sortList = array(
            't' => array('ft.title', 'Title', 'a'),
            'a' => array('ftu.nick_name', 'Author', 'a'),
            'l' => array('ftpu.nick_name', 'Latest Reply', 'a'),
            's' => array('ft.date', 'Since', 'd'),
            'r' => array('rating', 'Rating', 'd'),
            'p' => array('popular', 'Popular', 'd'));

        $sorter  = Helper_Sort::factory($this->view, $sortList, $sortKey, $dirKey, 's');
        $sortBy  = $sorter->getSortBy();
        $sortDir = $sorter->getSortDir();
        
        $topicsSelect = Community_Model_Forum::getTopicsSelect($forumId, $sortBy, $sortDir, $forumInfo['maxViews'], $forumInfo['maxReplies']);

        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Pagination From Db_Select
        $pagAdapter = new Zend_Paginator_Adapter_DbSelect($topicsSelect);
        $pagAdapter->setRowCount($forumInfo['topicCount']);

        $paginator = new Zend_Paginator($pagAdapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setPageRange(7);
        $paginator->setView($this->view);
        
        // Get actual page number for general info
        $forumInfo['page'] = $paginator->getCurrentPageNumber();

        // Get actual data to perform row updates
        $topics = (array) $paginator->getCurrentItems();

        foreach ($topics as $id => $topic) {
            $offset = Helper_Time::getFancyOffset($topic['date']);

            $topics[$id]['date']    = Helper_Time::getLongDateTime($topic['date']);
            $topics[$id]['offset']  = '+ ' . $offset;
            $topics[$id]['popular'] = number_format(50 * $topic['popular'], 1);
        }

        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Load View
        $this->view->forumInfo = $forumInfo;
        $this->view->topics    = $topics;
        $this->view->paginator = $paginator;
        $this->view->sorter    = $sorter;

        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Set Page Title, Javascript, and CSS
        $this->view->headTitle($forumInfo['forumName'] . ' Forum');
        $this->view->headLink()->appendStylesheet('/css/community/forum.css');
        $this->view->headScript()->appendFile('/js/community/forum.js');
    }
}