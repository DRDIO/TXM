<?php

require_once 'Zend/Log/Filter/Suppress.php';

/**
 *
 * @author Kevin Nuut
 *
 */
class Helper_Log_Filter_Suppress extends Zend_Log_Filter_Suppress
{
    public function isSuppressed()
    {
         return ($this->_accept === false);
    }
}