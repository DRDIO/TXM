<?php

/**
 *
 * @author Kevin Nuut
 *
 */
class Helper_Log_Writer_Stream extends Zend_Log_Writer_Stream
{
    const DEFAULT_STREAM = 'php://output';

    public function __construct($streamOrUrl, $mode = 'a') {
        try {
            parent::__construct($streamOrUrl, $mode);
        } catch (Zend_Log_Exception $e) {
            parent::__construct(self::DEFAULT_STREAM);
        }
    }

    public function getStream()
    {
        return $this->_stream;
    }
}