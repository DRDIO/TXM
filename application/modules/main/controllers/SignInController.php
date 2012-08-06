<?php

class Main_SignInController extends Controller_Abstract
{
    public function indexAction()
    {
        $form = Main_Form_User::createSignIn();

        if ($this->request->isPost()) {
            if ($form->isValid($this->request->getPost())) {

            }
        }

        $this->view->form = $form;
    }
}
