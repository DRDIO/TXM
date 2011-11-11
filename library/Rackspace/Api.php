<?php

class Rackspace_Api
{
    protected static $_authentication;
    protected static $_connection;
    
    public static function init($user = null, $key = null)
    {
        if (!isset(self::$_connection)) {
            if (!isset(self::$_authentication)) {
                self::$_authentication = new Rackspace_Authentication($user, $key);
            }
            
            self::$_connection = new Rackspace_Connection(self::$_authentication);
        }
        
        return self::$_connection;
    }
}