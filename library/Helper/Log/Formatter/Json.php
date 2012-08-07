<?php

require_once 'Zend/Log/Formatter/Simple.php';

/**
 *
 * @author Kevin Nuut
 *
 */
class Helper_Log_Formatter_Json extends Zend_Log_Formatter_Abstract
{
    protected $_format;
    
    const DEFAULT_FORMAT = '{"t":"timestamp","p":"priorityName","m":"message"}';

    public function __construct($format = null)
    {
        if (!$format || !is_string($format)) {
            $format = self::DEFAULT_FORMAT;
        }
        
        $this->_format = json_decode($format);        
    }

    public static function factory($options)
    {
        $format = null;
        if (null !== $options) {
            if ($options instanceof Zend_Config) {
                $options = $options->toArray();
            }

            if (array_key_exists('format', $options)) {
                $format = $options['format'];
            }
        }

        return new self($format);
    }
    
    public function format($event)
    {
        $output = array();
        
        foreach ((array) $this->_format as $key => $identifier) {
            if (isset($event[$identifier])) {
                $output[$key] = $event[$identifier];
            }
        }
        
        return json_encode($output) . PHP_EOL;        
    }
}