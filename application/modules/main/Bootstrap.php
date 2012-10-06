<?php

class Main_Bootstrap extends Zend_Application_Module_Bootstrap
{
    protected function _initCache()
    {
        /*
        * You should avoid putting too many lines before the cache section.
        * For example, for optimal performances, "require_once" or
        * "Zend_Loader::loadClass" should be after the cache section.
        */

        $frontendOptions = array(
           'lifetime'     => 7200,
           'debug_header' => true, // for debugging
           'regexps'      => array(
               // cache the whole IndexController
               '^/$' => array('cache' => true)
           )
        );

        $backendOptions = array(
            'cache_dir' => '/tmp/'
        );

        // getting a Zend_Cache_Frontend_Page object
        $cache = Zend_Cache::factory('Page',
                                     'File',
                                     $frontendOptions,
                                     $backendOptions);

        $cache->start();
    }
}