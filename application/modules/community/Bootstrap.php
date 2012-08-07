<?php

class Community_Bootstrap extends Zend_Application_Module_Bootstrap
{
    public function _initPage()
    {
        $this->bootstrap('frontController');
        $ctrl = $this->getResource('frontController');

        $router = $ctrl->getRouter();

        $route = new Zend_Controller_Router_Route(
            'community/forum/:id/:page/:sort/:dir',
            array(
                'module'     => 'community',
                'controller' => 'forum',
                'action'     => 'index',
                'page'   => 1,
                'sort'   => '',
                'dir'    => 'a'),
            array(
                'id'         => '\d+',
                'page'       => '\d+',
                'sort'       => '\w{1}',
                'dir'        => '[ad]{1}'));
        
        $router->addRoute('forum', $route);

        $route = new Zend_Controller_Router_Route(
            'community/topic/:id/:title/:page/:sort/:dir',
            array(
                'module'     => 'community',
                'controller' => 'topic',
                'action'     => 'index',
                'title'  => '',
                'page'   => 1,
                'sort'   => '',
                'dir'    => 'a'),
            array(
                'id'         => '\d+',                
                'page'       => '\d+',
                'sort'       => '\w{1}',
                'dir'        => '[ad]{1}'));

        $router->addRoute('topic', $route);

        $route = new Zend_Controller_Router_Route(
            'bbs/:id/:title/:page/:sort/:dir',
            array(
                'module'     => 'community',
                'controller' => 'topic',
                'action'     => 'index',
                'title'  => '',
                'page'   => 1,
                'sort'   => '',
                'dir'    => 'a'),
            array(
                'id'         => '\d+',
                'page'       => '\d+',
                'sort'       => '\w{1}',
                'dir'        => '[ad]{1}'));

        $router->addRoute('oldtopic', $route);
    }
}