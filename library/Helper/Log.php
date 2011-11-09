<?php

class Helper_Log
{
    static protected $_logger;
    static protected $_writer;
    static protected $_formatter;
    static protected $_filterSwitch;
    static protected $_filterLevel;
    static protected $_priorities;

    /**
     *
     * @return unknown_type
     */
    protected function __construct() {

    }

    /**
     *
     * @param $options
     * @return unknown_type
     */
    static public function init($options = null)
    {
        if ((self::$_logger instanceof Zend_Log) === false) {
            // No matter what type of input, get a Zend_Config
            $stream   = '../log/' . $_SERVER['HTTP_HOST'] . '.' . date('Ymd') . '.log.bak';
            $format   = null;
            $priority = 'DEBUG';
            $operator = null;

            // Whether or not to attach logger to php errors and exceptions
            $logErrors     = true;
            $logExceptions = true;

            // Create Logger
            self::$_logger = new Zend_Log();

            // Get priorities
            $reflection        = new ReflectionClass(self::$_logger);
            self::$_priorities = array_flip($reflection->getConstants());

            // Setup default format for logs
            if (is_array($format) === false || sizeof($array) === 0) {
                $format = array(
                    'time' => '%time%',
                    'lvl'  => '%priorityName%',
                    'msg'  => '%message%',
                    'line' => '%line%',
                    'file' => '%file%',
                    'func' => '%function%',
                    'ip'   => '%ipaddr%');
            }

            // Build up logger with writer, formatter, and filters
            self::$_writer       = new Helper_Log_Writer_Stream($stream);
            self::$_formatter    = new Helper_Log_Formatter_Json($format);
            self::$_filterSwitch = new Helper_Log_Filter_Suppress();
            self::$_filterLevel  = new Helper_Log_Filter_Priority(self::$_priorities);

            // Attach settings to the logger
            self::$_writer->setFormatter(self::$_formatter);
            self::$_logger->addWriter(self::$_writer);
            self::$_logger->addFilter(self::$_filterSwitch);
            self::$_logger->addFilter(self::$_filterLevel);

            // Set the user priority and operator
            self::setPriority($priority, $operator);

            if ($logErrors) {
                set_error_handler('Helper_Log::errorHandler');
            }

            if ($logExceptions) {
                set_exception_handler('Helper_Log::exceptionHandler');
            }
        }
        return true;
    }

    /**
     *
     * @param $errno
     * @param $errstr
     * @param $errfile
     * @param $errline
     * @return unknown_type
     */
    static public function errorHandler($errno, $errstr, $errfile, $errline)
    {
        $message  = $errstr;
        $priority = null;
        $file     = $errfile;
        $line     = $errline;

        switch($errno) {
            case E_ERROR:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_USER_ERROR:
                Zend_Log::CRIT;
                break;
            case E_RECOVERABLE_ERROR:
                Zend_Log::ERR;
                break;
            case E_PARSE:
            case E_WARNING:
            case E_CORE_WARNING:
            case E_COMPILE_WARNING:
            case E_USER_WARNING:
                Zend_Log::WARN;
                break;
            case E_NOTICE:
            case E_USER_NOTICE:
            case E_STRICT:
            case E_DEPRECATED:
            case E_USER_DEPRECATED:
                Zend_Log::NOTICE;
                break;
        }

        $backtrace = debug_backtrace();
        if (sizeof($backtrace) > 1) {
            $function  = (isset($backtrace[1]['class'])    ? $backtrace[1]['class']    : '');
            $function .= (isset($backtrace[1]['type'])     ? $backtrace[1]['type']     : '');
            $function .= (isset($backtrace[1]['function']) ? $backtrace[1]['function'] : '?');
        }

        self::_log($message, $priority, $file, $line, $function);
    }

    /**
     *
     * @param $e
     * @return unknown_type
     */
    static public function exceptionHandler(Exception $e)
    {
        $message  = $e->getMessage();
        $priority = Zend_Log::ERR;
        $file     = $e->getFile();
        $line     = $e->getLine();
        $function = get_class($e);

        self::_log($message, $priority, $file, $line, $function);
        return true;
    }

    /**
     *
     * @param $message
     * @param $priority
     * @return unknown_type
     */
    static public function logHandler($message = '', $priority = null)
    {
        if ($message instanceof Exception) {
            $e        = $message;
            $message  = $e->getMessage();
            $file     = $e->getFile();
            $line     = $e->getLine();
            $function = get_class($e);
            var_dump($function);
        } else {
            $function = '';
            $backtrace = debug_backtrace();
            if (sizeof($backtrace) > 1) {
                $file = (isset($backtrace[1]['file']) ? $backtrace[1]['file'] : '?');
                $line = (isset($backtrace[1]['line']) ? $backtrace[1]['line'] : '?');
                if (sizeof($backtrace) > 2) {
                    $function  = (isset($backtrace[2]['class'])    ? $backtrace[2]['class']    : '');
                    $function .= (isset($backtrace[2]['type'])     ? $backtrace[2]['type']     : '');
                    $function .= (isset($backtrace[2]['function']) ? $backtrace[2]['function'] : '?');
                }
            }
        }

        self::_log($message, $priority, $file, $line, $function);
    }

    /**
     * Log a message (user cannot access directly, must go through helpers below).
     *
     * @return
     */
    static protected function _log($message = '', $priority = null, $file = '?', $line = '?', $function = '?', $ipaddr = null, $time = null)
    {
        self::init();

        if ($priority === null) {
            $priority = self::$_filterLevel->getDefaultPriority();
        }
        if ($time === null) {
            $time = date('H:i:s');
        }
        if ($ipaddr === null) {
            $ipaddr = (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '?');
        }

        // Add events
        self::$_logger->setEventItem('file', $file);
        self::$_logger->setEventItem('line', $line);
        self::$_logger->setEventItem('function', $function);
        self::$_logger->setEventItem('ipaddr', $ipaddr);
        self::$_logger->setEventItem('time', $time);

        // Log event
        self::$_logger->log($message, $priority);

        if ($priority <= Zend_Log::ERR) {
            die();
        }

        return $message;
    }

    /**
     * Turn logging on
     *
     * @param $suppress
     * @return unknown_type
     */
    static public function enable()
    {
        self::init();
        self::$_filterSwitch->suppress(false);
        return true;
    }

    /**
     * Turn logging off
     *
     * @param $suppress
     * @return unknown_type
     */
    static public function disable()
    {
        self::init();
        self::$_filterSwitch->suppress(true);
        return true;
    }

    /**
     * Return if logging is enabled or disabled
     *
     * @return bool True for Enabled else False.
     */
    static public function isEnabled()
    {
        self::init();
        return (self::$_filterSwitch->isSuppressed() === false);
    }

    /**
     * Resest priority to a different level on the fly.
     *
     * @param mixed  $priority Priority level to filter.
     * @param string $operator Relation of priority to event.
     *
     * @return stdClass Priority and Operator parameters.
     */
    static public function setPriority($priority = null, $operator = null)
    {
        self::init();
        self::$_filterLevel->setPriority($priority, $operator);

        // Let them know the final results
        return self::$_filterLevel->getPriority();
    }

    /**
     * Get the current priority and operator.
     *
     * @return stdClass Priority and Operator parameters.
     */
    static public function getPriority()
    {
        self::init();
        // Let them know the final results
        return self::$_filterLevel->getPriority();
    }

    static public function getStream()
    {
        self::init();
        return self::$_writer->getStream();
    }

    /**
     * Emergency: system is unusable
     *
     * @param mixed $message Error message as a string or an exception.
     *
     * @return string Return message.
     */
    static public function emerg($message = '')
    {
        return self::logHandler($message, Zend_Log::EMERG);
    }

    /**
     * Alert: action must be taken immediately
     *
     * @param mixed $message Error message as a string or an exception.
     *
     * @return string Return message.
     */
    static public function alert($message = '')
    {
        return self::logHandler($message, Zend_Log::ALERT);
    }

    /**
     * Critical: critical conditions
     *
     * @param mixed $message Error message as a string or an exception.
     *
     * @return string Return message.
     */
    static public function crit($message = '')
    {
        return self::logHandler($message, Zend_Log::CRIT);
    }

    /**
     * Error: error conditions
     *
     * @param mixed $message Error message as a string or an exception.
     *
     * @return string Return message.
     */
    static public function err($message = '')
    {
        return self::logHandler($message, Zend_Log::ERR);
    }

    /**
     * Warning: warning conditions
     *
     * @param mixed $message Error message as a string or an exception.
     *
     * @return string Return message.
     */
    static public function warn($message = '')
    {
        return self::logHandler($message, Zend_Log::WARN);
    }

    /**
     * Notice: normal but significant condition
     *
     * @param mixed $message Error message as a string or an exception.
     *
     * @return string Return message.
     */
    static public function notice($message = '')
    {
        return self::logHandler($message, Zend_Log::NOTICE);
    }

    /**
     * Informational: informational messages
     *
     * @param mixed $message Error message as a string or an exception.
     *
     * @return string Return message.
     */
    static public function info($message = '')
    {
        return self::logHandler($message, Zend_Log::INFO);
    }

    /**
     * Debug: debug messages
     *
     * @param mixed $message Error message as a string or an exception.
     *
     * @return string Return message.
     */
    static public function debug($message = '')
    {
        return self::logHandler($message, Zend_Log::DEBUG);
    }

}