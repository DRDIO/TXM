<?php

class Form_Abstract extends Zend_Form 
{
    protected static $_form;
    
    public static function getInstance()
    {
        if (!self::$_form) {
            $c = __CLASS__;
            self::$_form = new $c;
        }
        
        return self::$_form;
    }
}