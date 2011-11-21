<?php

class Helper_View extends Zend_View
{
    public function addBasePath($path, $classPrefix = 'Zend_View')
    {
        $path        = rtrim($path, '/');
        $path        = rtrim($path, '\\');
        $path       .= DIRECTORY_SEPARATOR;
        $classPrefix = rtrim($classPrefix, '_') . '_';
        $this->addScriptPath($path);
        $this->addHelperPath($path . '../Helper', $classPrefix . 'Helper');
        $this->addFilterPath($path . '../Filter', $classPrefix . 'Filter');
        return $this;
    }

    public function setBasePath($path, $classPrefix = 'Zend_View')
    {
        $path        = rtrim($path, '/');
        $path        = rtrim($path, '\\');
        $path       .= DIRECTORY_SEPARATOR;
        $classPrefix = rtrim($classPrefix, '_') . '_';
        $this->setScriptPath($path);
        $this->setHelperPath($path . '../Helper', $classPrefix . 'Helper');
        $this->setFilterPath($path . '../Filter', $classPrefix . 'Filter');
        return $this;
    }

}
