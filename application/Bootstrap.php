<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initModuleAutoloaders() 
    { 
        $this->bootstrap('FrontController'); 

        $front = $this->getResource('FrontController'); 

        foreach ($front->getControllerDirectory() as $module => $directory) { 
            $module = ucfirst($module); 
            $loader = new Zend_Application_Module_Autoloader(array( 
                'namespace' => $module, 
                'basePath'  => dirname($directory), 
            ));

            $loader->addResourceType('model', 'Model', 'Model');
        }
    }

    protected function _initView()
    {
        // Bootstrap View and Autloader, which are called in Page
        $view = new Helper_View();

        $options      = $this->getOptions();
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');

        $viewRenderer
            ->setView($view)
            ->setViewBasePathSpec($options['resources']['layout']['viewBasePathSpec'])
            ->setViewScriptPathSpec(':controller/:action.:suffix');

        return $view;
    }

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
        $view->headLink(array('rel' => 'favicon', 'href' => '/favicon.ico'))
            // ->appendStylesheet($view->siteAssets . 'css/source/jquery-ui-1.8.2.custom.css')
            ->appendStylesheet($view->siteAssets . 'css/default.min.css');

        // Setup JS
        $view->headScript()
            ->appendFile($view->siteAssets . 'js/source/jquery-1.4.2.min.js')
            ->appendFile($view->siteAssets . 'js/source/jquery-ui-1.8.2.custom.min.js')
            ->appendFile($view->siteAssets . 'js/default.js');

        Zend_Paginator::setDefaultScrollingStyle('Elastic');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('../../../Layout/pagination.phtml');
        Zend_Paginator::setDefaultItemCountPerPage(15);

        Helper_Log::init(array('priority' => 'debug', 'fancy' => true));

        // Set the registry and view for later use
        Zend_Registry::set('siteUser', $siteUser);
        $view->siteUser     = $siteUser;
    }
}
