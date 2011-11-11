<?php

class Rackspace_Api
{
    protected static $_authentication;
    protected static $_connection;
    
    public static function getInstance($user = null, $key = null, $containerName = null)
    {
        if (!isset(self::$_connection)) {
            if (!isset(self::$_authentication)) {
                self::$_authentication = new Rackspace_Authentication($user, $key);
            }
            
            self::$_connection = new Rackspace_Connection(self::$_authentication);
        }
        
        if ($containerName) {
            return self::$_connection->get_container($containerName);
        }
        
        return self::$_connection;
    }
}