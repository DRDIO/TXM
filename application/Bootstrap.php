<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initPage()
    {
        // Bootstrap View and Autloader, which are called in Page
        $this->bootstrap('view');
        $this->bootstrap('autoloader');
        
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
        $view->siteMedia    = $protocol . '://media.txmafia.' . $tld . '/';
        $view->siteAssets   = $protocol . '://assets.txmafia.' . $tld . '/';

        $view->siteRedirect = $_SERVER['REQUEST_URI'];
        $view->siteIp       = $_SERVER['REMOTE_ADDR'];

        // Setup Header
        $view->headTitle('TXM.com')->setSeparator(' | ');

        // Setup CSS
        $view->headLink(array('rel' => 'favicon', 'href' => '/favicon.ico'))
            // ->appendStylesheet($view->siteAssets . 'css/source/jquery-ui-1.8.2.custom.css')
            ->appendStylesheet($view->siteAssets . 'css/default.min.css');

        // Setup JS
        $view->headScript()
            ->appendFile($view->siteAssets . 'js/source/jquery-1.4.2.min.js')
            ->appendFile($view->siteAssets . 'js/source/jquery-ui-1.8.2.custom.min.js')
            ->appendFile($view->siteAssets . 'js/default.js');

        // Add it to the ViewRenderer
        $viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer($view, array(
            'viewBasePathSpec'   => ':moduleDir/View'
        ));

        Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);

        Zend_Paginator::setDefaultScrollingStyle('Elastic');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('../../../Layout/pagination.phtml');
        Zend_Paginator::setDefaultItemCountPerPage(15);

        Helper_Log::init(array('priority' => 'debug', 'fancy' => true));
        
        // Set the registry and view for later use
        Zend_Registry::set('siteUser', $siteUser);
        $view->siteUser     = $siteUser;        
    }

    /**
     *
     * @return Zend_View
     */
    protected function _initView()
    {
        $options = $this->getOption('resources');        
        $view    = new Zend_View();

        if (isset($options['view'])) {
            if (isset($options['view']['scriptPath'])) {
                $view->setScriptPath($options['view']['scriptPath']);
            }

            if (isset($options['view']['doctype'])) {
                $view->doctype($options['view']['doctype']);
            }
        }        

        $view->setLfiProtection(false);
        
        // Return it, so that it can be stored by the bootstrap
        return $view;
    }

    protected function _initAutoloader()
    {        
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('Helper_');
        
        return $autoloader;
    }
}