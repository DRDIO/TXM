<?php

class Helper_Sort
{
    protected $_sortList;
    protected $_view;

    public static function factory($view, $sortList, $sortKey = null, $dirKey = null, $sortDefault = null)
    {        
        return new self($view, $sortList, $sortKey, $dirKey, $sortDefault);
    }

    public function __construct($view, $sortList, $sortKey = null, $dirKey = null, $sortDefault = null)
    {
        // Get default Sort Key, setup next state, and get current state for SQL
        if (isset($sortList[$sortKey])) {
            $sortList[$sortKey][2] = ($dirKey == 'd' ? 'a' : 'd');
        } else {
            $sortKey = (isset($sortList[$sortDefault]) ? $sortDefault : key($sortList));
            $sortList[$sortKey][2] = ($sortList[$sortKey][2] == 'd' ? 'a' : 'd');
        }

        $sortList[$sortKey][4] = true;

        // Build the URL for each sort link
        foreach ($sortList as $key => $sort) {
            $sortList[$key][3] = $view->url(array(
                'sort' => $key,
                'dir'  => $sort[2]));
        }

        $this->_view     = $view;
        $this->_sortList = $sortList;
        $this->_sortKey  = $sortKey;
    }

    public function __toString()
    { 
        try {
            return $this->_view->partial('partial-sort.phtml', 'main', array(
                'sortList' => $this->_sortList));
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }

    public function getSortBy()
    {
        return $this->_sortList[$this->_sortKey][0];
    }

    public function getSortDir()
    {
        return ($this->_sortList[$this->_sortKey][2] == 'a' ? 'DESC' : 'ASC');
    }
}