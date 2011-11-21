<?php   

class Main_MediaController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        try {
            $section   = $this->_getParam('section');
            
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
            $handle   = fopen($fileName, 'rb');
            
            if ($handle) {
                $headers = get_headers($fileName);
                
                foreach ($headers as $header) {
                    header($header);
                }
            
                echo stream_get_contents($handle);
                
                fclose($handle);
                
            } else {
                header('content-type: image/gif');
                echo file_get_contents(APPLICATION_DATA . '/../public/img/spacer.gif');
            }            
            
            /*
            $username  = 'kevinnuut';
            $key       = '55f0dd33854ec4599d37ae6134c648f5';
            
            
            $container = Rackspace_Api::getInstance($username, $key, $section);
            
            $filename = $this->_getParam('file');
            $file     = $container->get_object($filename);

            if ($file) {
                $this->getResponse()->setHeader('content-type', $file->content_type);

                $output = fopen('php://output', 'w');
                $file->stream($output); # stream object content to PHP's output buffer
                fclose($output);
            }
            */
            
        } catch (Exception $e) {
            Helper_Log::err($e->getMessage());
        }
    }
}
