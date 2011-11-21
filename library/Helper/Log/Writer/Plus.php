<?php

require_once 'Zend/Log/Writer/Stream.php';

class Helper_Log_Writer_Plus extends Zend_Log_Writer_Stream
{
    protected function _write($event)
    {
        $backtrace = debug_backtrace();
        
        foreach ($backtrace as $id => $trace) {
            if (!isset($trace['class'])) {
                break;
            }

            $class = $trace['class'];
            
            if (!is_subclass_of($class, 'Helper_Log') &&
                !is_subclass_of($class, 'Zend_Log') &&
                !is_subclass_of($class, 'Zend_Log_Writer_Abstract') &&
                $class !== 'Helper_Log' &&
                $class !== 'Zend_Log' &&
                $class !== 'Zend_Log_Writer_Abstract') {
                break;
            }
        }

        $function  = isset($trace['class'])    ? $trace['class']    : '';
        $function .= isset($trace['type'])     ? $trace['type']     : '';
        $function .= isset($trace['function']) ? $trace['function'] : '';

        $event['timestamp'] = date('H:i:s');
        $event['uid']       = Zend_Registry::isRegistered('uid') ? Zend_Registry::get('uid') : null;
        $event['file']      = basename(isset($trace['file']) ? $trace['file'] : '');
        $event['line']      = isset($trace['line']) ? $trace['line'] : '';
        $event['function']  = $function;

        parent::_write($event);
    }

    /**
     * Create a new instance of Zend_Log_Writer_Stream
     *
     * @param  array|Zend_Config $config
     * @return Zend_Log_Writer_Stream
     */
    static public function factory($config)
    {
        $config = self::_parseConfig($config);
        $config = array_merge(array(
            'stream' => null,
            'mode'   => null,
        ), $config);

        $streamOrUrl = isset($config['url']) ? $config['url'] : $config['stream'];

        return new self(
            $streamOrUrl,
            $config['mode']
        );
    }
}