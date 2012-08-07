<?php

class Games_Bootstrap extends Zend_Application_Module_Bootstrap
{
    public function _initPage()
    {
        $this->bootstrap('frontController');
        $ctrl = $this->getResource('frontController');

        $router = $ctrl->getRouter();

        $route = new Zend_Controller_Router_Route(
            'games/:id/*',
            array(
                'module'     => 'games',
                'controller' => 'view',
                'action'     => 'index'),
            array(
                'id'   => '\d+'));
        
        $router->addRoute('games', $route);

        $route = new Zend_Controller_Router_Route(
            'games/:old/:id/*',
            array(
                'module'     => 'games',
                'controller' => 'view',
                'action'     => 'index'),
            array(
                'id'  => '\d+',
                'old' => '(view|play)'));

        $router->addRoute('oldgames', $route);
    }
}