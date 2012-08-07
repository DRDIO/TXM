<?php

class Form_Element_Divider extends Zend_Form_Element
{
    public $helper = 'formDivider';

    public function init()
    {
        $this->getView()->addHelperPath('View/Helper/', 'View_Helper');
    }
}
