<?php

require_once 'Zend/Log/Filter/Priority.php';

/**
 *
 * @author Kevin Nuut
 *
 */
class Helper_Log_Filter_Priority extends Zend_Log_Filter_Priority
{
    const DEFAULT_PRIORITY = 4;        //
    const DEFAULT_OPERATOR = '<=';     // Basically, any error more important or equal to WARN

    protected $_priorities = array();
    protected $_operators  = array('<=', '<', 'lt', 'le', '>', 'gt', '>=', 'ge', '==', '=', 'eq', '!=', '<>', 'ne');

    /**
     *
     * @param $priorities
     * @param $priority
     * @param $operator
     * @return unknown_type
     */
    public function __construct(Array $priorities, $priority = null, $operator = null)
    {
        $this->_priorities = $priorities;
        $this->setPriority($priority, $operator);
    }

    /**
     *
     * @param $priority
     * @param $operator
     * @return unknown_type
     */
    public function setPriority($priority = null, $operator = null)
    {
        if (in_array(strtoupper($priority), $this->_priorities)) {
            $tempKeys = array_flip($this->_priorities);
            // Get the integer based on string name
            $priority = $tempKeys[strtoupper($priority)];
        } else if (is_integer($priority) === false && array_key_exists($priority, $this->_priorities) === false) {
            // Use the default if none match
            $priority = self::DEFAULT_PRIORITY;
        }

        // User default operator if none exists
        if (in_array($operator, $this->_operators) === false) {
            $operator = self::DEFAULT_OPERATOR;
        }

        $this->_priority = $priority;
        $this->_operator = $operator;

        return $this->getPriority();
    }

    /**
     *
     * @return unknown_type
     */
    public function getPriority()
    {
        $result = new stdClass();
        $result->priority = $this->_priority;
        $result->operator = $this->_operator;
        return $result;
    }

    public function getDefaultPriority()
    {
        return self::DEFAULT_PRIORITY;
    }
}