<?php

class Main_ErrorController extends Zend_Controller_Action
{
    public function errorAction()
    {
        $errors = $this->_getParam('error_handler');
                
        switch ($errors->type) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ROUTE:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:

                // 404 error -- controller or action not found
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->errorMessage = 'this page was not found or does not exist';
                break;
            default:
                // application error
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->errorMessage = 'this page cannot be processed at this time';
                break;
        }

        $exception = $this->getResponse()->getException();
        Helper_Log::warn($exception[0]->getMessage());

        $this->view->headTitle('Error');
    }
}