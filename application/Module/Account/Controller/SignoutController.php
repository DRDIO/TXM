<?php

class Account_SigninController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $auth = Zend_Auth::getInstance();
        
        if ($auth->hasIdentity()) {
            $auth->clearIdentity();
        }
        
        $this->redirect('/');
    }
}