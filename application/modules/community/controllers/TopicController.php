<?php

class Community_TopicController extends Zend_Controller_Action
{
    public function indexAction()
    {
        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Get Forum ID and Current Page
        $topicId = $this->_getParam('id');
        $page    = $this->_getParam('page');
        $sortKey = $this->_getParam('sort');
        $dirKey  = $this->_getParam('dir');
        
        $topicInfo = Community_Model_Topic::getTopicInfo($topicId);

        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Get Data With Sorting Options
        $sortList = array(
            'd' => array('ftp.date', 'Reply Since', 'a'),
            'a' => array('u.nick_name', 'Author', 'a'));

        $sorter  = Helper_Sort::factory($this->view, $sortList, $sortKey, $dirKey);
        $sortBy  = $sorter->getSortBy();
        $sortDir = $sorter->getSortDir();
        
        $threadsSelect = Community_Model_Topic::getThreadsSelect($topicId, $sortBy, $sortDir);

        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Pagination From Db_Select
        $pagAdapter = new Zend_Paginator_Adapter_DbSelect($threadsSelect);
        $pagAdapter->setRowCount($topicInfo['threadCount']);

        $paginator = new Zend_Paginator($pagAdapter);
        $paginator->setCurrentPageNumber($page);
        $paginator->setPageRange(7);
        $paginator->setView($this->view);
        
        // Get actual page number for general info
        $topicInfo['page'] = $paginator->getCurrentPageNumber();

        // Get actual data to perform row updates
        $threads = (array) $paginator->getCurrentItems();

        foreach ($threads as $id => $thread) {
            $threads[$id]['post'] = strip_tags($thread['post']);
            $threads[$id]['date'] = Helper_Time::getLongDateTime($thread['date']);
        }

        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Load View
        $this->view->topicInfo = $topicInfo;
        $this->view->threads   = $threads;
        $this->view->paginator = $paginator;
        $this->view->sorter    = $sorter;

        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        // Set Page Title, Javascript, and CSS
        $this->view->headTitle('Community')->headTitle($topicInfo['forumName'])->headTitle($topicInfo['topicName']);
    }
}