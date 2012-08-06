<?php

class Controller_Abstract extends Zend_Controller_Action
{
    public $request;

    public function init()
    {
        $this->request = $this->getRequest();
    }
}
