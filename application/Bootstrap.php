<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initPage()
    {
        // Bootstrap View and Autloader, which are called in Page
        $this->bootstrap('view');
        $view = $this->getResource('view');

        // Get the second and top level domain
        $domain   = explode('.', $_SERVER['HTTP_HOST']);
        $tld      = array_pop($domain);
        $sld      = array_pop($domain);
        $domain   = $sld . '.' . $tld;
        $protocol = (strpos($_SERVER['SERVER_PROTOCOL'], 'https') === 0 ? 'https' : 'http');

        // Get the user identity or null if they are not logged in
        $auth     = Zend_Auth::getInstance();
        $siteUser = $auth->getIdentity();

        // Setup view variables
        $view->siteDomain   = $domain;
        $view->siteLevel    = $protocol . '://' . $domain . '/';
        $view->siteMedia    = $protocol . '://media.' . $domain . '/';
        $view->siteAssets   = $protocol . '://assets.' . $domain . '/';

        $view->siteRedirect = $_SERVER['REQUEST_URI'];
        $view->siteIp       = $_SERVER['REMOTE_ADDR'];

        // Setup Header
        $view->headTitle('TXM.com')->setSeparator(' | ');

        // Setup CSS
        $view->headLink(array('rel' => 'favicon', 'href' => '/favicon.ico'));

        if (APPLICATION_ENV == 'production') {
            $view->headLink()->appendStylesheet($view->siteAssets . 'css/less.min.css');
        } else {
            $view->headLink(array('rel' => 'stylesheet/less', 'type' => 'text/css', 'href' => '/less/bootstrap.less'));
        }

        // Setup JS
        $view->headScript()
            ->appendFile($view->siteAssets . 'js/source/jquery-1.4.2.min.js')
            ->appendFile($view->siteAssets . 'js/source/jquery-ui-1.8.2.custom.min.js')
            ->appendFile($view->siteAssets . 'js/default.js');

        if (APPLICATION_ENV != 'production') {
            $view->headScript()
                ->appendFile($view->siteAssets . 'js/source/less-1.3.0.min.js')
                ->appendScript("less.env='development';less.watch();localStorage.clear();");
        }

        Zend_Paginator::setDefaultScrollingStyle('Elastic');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');
        Zend_Paginator::setDefaultItemCountPerPage(15);

        // Set the registry and view for later use
        Zend_Registry::set('siteUser', $siteUser);
        $view->siteUser     = $siteUser;
    }

    protected function _initHelperLog()
    {
        $this->bootstrap('log');
        $log = $this->getResource('log');

        $log->registerErrorHandler();
        Helper_Log::init($log);
    }

    protected function _initConf()
    {
        $this->bootstrap('view');

        $view     = $this->getResource('view');
        $options  = $this->getOptions();
        $conf     = new Zend_Config($options['conf']);

        Zend_Registry::set('conf', $conf);
        $view->conf = $conf;
    }
}
