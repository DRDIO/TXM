<?php

class Main_RackController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $username  = 'kevinnuut';
        $key       = '55f0dd33854ec4599d37ae6134c648f5';
        $container = Rackspace_Api::getInstance($username, $key, 'txm_media');
        $objects   = $container->getObjectList();

        $output = array();
        foreach ($objects as $object) {
            $output[] = $object->name;
        }

        $this->_helper->json($output);
    }
}
