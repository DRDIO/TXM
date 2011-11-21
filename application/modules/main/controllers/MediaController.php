<?php

class Main_MediaController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        try {
            $username  = 'kevinnuut';
            $key       = '55f0dd33854ec4599d37ae6134c648f5';
            
            $section   = $this->_getParam('section');
            
            Helper_Log::debug($section);
            
            $cdnList = array(
                'game'     => 'http://c815845.r45.cf2.rackcdn.com/',
                'gameimg'  => 'http://c815846.r46.cf2.rackcdn.com/',
                'movie'    => 'http://c815847.r47.cf2.rackcdn.com/',
                'movieimg' => 'http://c815848.r48.cf2.rackcdn.com/',
                'profile'  => 'http://c815851.r51.cf2.rackcdn.com/'
            );
            
            if (!isset($cdnList[$section])) {
                throw new Exception('media section does not exist');
            }
            
            $fileName = $cdnList[$section] . $this->_getParam('file');            
            
            if (file_exists($fileName)) {
                $headers = get_headers($fileName);

                foreach ($headers as $header) {
                    if (strpos($header, 'Content') === 0) {
                        header($header);
                    }
                }
                
                echo file_get_contents($fileName);
            } else {
                header('content-type: image/gif');
                echo file_get_contents(APPLICATION_PATH . '/../public/img/spacer.gif');
            }
        } catch (Exception $e) {
            Helper_Log::err($e->getMessage());
        }
    }
}
