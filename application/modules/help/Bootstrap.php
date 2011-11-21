<?php

class Help_Bootstrap extends Zend_Application_Module_Bootstrap
{
    public function _initPage()
    {
        $this->bootstrap('frontController');
        $ctrl = $this->getResource('frontController');

        $router = $ctrl->getRouter();

        $route = new Zend_Controller_Router_Route(
            'help/:action',
            array(
                'module'     => 'help',
                'controller' => 'index',
                'action'     => 'terms'));
        
        $router->addRoute('help', $route);
    }
}