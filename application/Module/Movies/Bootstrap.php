<?php

class Movies_Bootstrap extends Zend_Application_Module_Bootstrap
{
    public function _initPage()
    {
        $this->bootstrap('frontController');
        $ctrl = $this->getResource('frontController');

        $router = $ctrl->getRouter();

        $route = new Zend_Controller_Router_Route(
            'movies/:id/*',
            array(
                'module'     => 'movies',
                'controller' => 'view',
                'action'     => 'index'),
            array(
                'id'   => '\d+'));
        
        $router->addRoute('movies', $route);

        $route = new Zend_Controller_Router_Route(
            'movies/:old/:id/*',
            array(
                'module'     => 'movies',
                'controller' => 'view',
                'action'     => 'index'),
            array(
                'id'  => '\d+',
                'old' => '(view|play)'));

        $router->addRoute('oldmovies', $route);
    }
}