<?php

// Define Application Path and Environment (Usually defined in conf.d)
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__)));
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Set include path to library and load Zend Application
set_include_path(implode(PATH_SEPARATOR, array(APPLICATION_PATH . '/../../common.script/library', get_include_path())));
require_once 'Zend/Application.php';

 // Create application from config then bootstrap everything and run
$application = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/../config/application.ini');
$application->bootstrap()->run();