<?php

require_once 'Zend/Log/Formatter/Simple.php';

/**
 *
 * @author Kevin Nuut
 *
 */
class Helper_Log_Formatter_Json extends Zend_Log_Formatter_Simple
{
    const DEFAULT_FORMAT = '{"time":"%timestamp%","priorityName":"%priorityName%","priority":"%priority%","message":"%message%"}';

    public function __construct($format = null)
    {
        if (is_array($format) === false || sizeof($format) === 0) {
            $json = self::DEFAULT_FORMAT . PHP_EOL;
        } else {
            $json = '';
            foreach ($format as $name => $value) {
                $name  = preg_replace('/(["\\\])/', '\\\\\1', $name);
                $value = preg_replace('/(["\\\])/', '\\\\\1', $value);

                $json .= ($json !== '' ? ',' : '') . '"' . $name . '":"' . $value . '"';
            }

            if ($json !== '') {
                $json = '{' . $json . '}' . PHP_EOL;
            }
        }

        $this->_format = $json;
    }

    public function format($event)
    {
        $output = $this->_format;
        foreach ($event as $name => $value) {
            if ((is_object($value) && !method_exists($value,'__toString')) || is_array($value)) {
                $value = gettype($value);
            }

            // Strip newlines and spaces
            $value = preg_replace(array('/(\s+)/', '/(["\\\])/'), array(' ', '\\\\\1'), $value);

            $output = str_replace("%$name%", $value, $output);
        }
        return $output;
    }
}