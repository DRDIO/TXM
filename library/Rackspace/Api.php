<?php

class Rackspace_Api
{
    protected static $_authentication;
    protected static $_connection;
    
    /**
     *
     * @param type $user
     * @param type $key
     * @param type $containerName
     * 
     * @return Rackspace_Container
     */
    public static function getInstance($user = null, $key = null, $containerName = null)
    {
        if (!isset(self::$_connection)) {
            
            if (!isset(self::$_authentication)) {
                self::$_authentication = new Rackspace_Authentication($user, $key);
            }
            
            if (!self::$_authentication->authenticated()) {
                self::$_authentication->authenticate();
            }
            
            self::$_connection = new Rackspace_Connection(self::$_authentication);
            
        }
        
        if ($containerName) {
            return self::$_connection->get_container($containerName);
        }
        
        return self::$_connection;
    }
}