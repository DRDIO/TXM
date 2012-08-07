<?php

class Helper_Log
{
    protected static $_instance;
    
    private function __construct()
    {
        
    }
    
    public static function init(Zend_Log $instance)
    {
        self::$_instance = $instance;
    }
    
    public static function err($message)
    {
        return self::getInstance()->err($message);
    }
    
    public static function warn($message)
    {
        return self::getInstance()->warn($message);
    }
    
    public static function notice($message)
    {
        return self::getInstance()->notice($message);
    }
    
    public static function info($message)
    {
        return self::getInstance()->info($message);
    }
    
    public static function debug($message)
    {
        return self::getInstance()->debug($message);
    }
    
    public static function getInstance()
    {
        if (!self::$_instance) {
            $writer = new Zend_Log_Writer_Stream('php://output');
            self::$_instance = new Zend_Log($writer);
        }
        
        return self::$_instance;
    }
}