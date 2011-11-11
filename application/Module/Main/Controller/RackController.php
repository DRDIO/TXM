<?php

class Main_RackController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $username = 'kevinnuut';
        $key      = '55f0dd33854ec4599d37ae6134c648f5';

        $auth = new Rackspace_Authentication($username, $key);
        $auth->authenticate();

        $connect   = new Rackspace_Connection($auth);
        $container = $connect->get_container('txm_media');
        
        $objects = $container->get_objects();
        
        $output = array();
        foreach ($objects as $object) {
            $output[] = $object->name;
        }
        $this->_helper->json('hello');
    }
}