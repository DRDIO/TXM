<?php

class Main_SignInController extends Controller_Abstract
{
    public function indexAction()
    {
        $form = Main_Form_Login::create();
        
        $this->view->form = $form;
    }
}
