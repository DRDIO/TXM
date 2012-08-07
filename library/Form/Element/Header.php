<?php

class Form_Element_Header extends Zend_Form_Element
{
    public $helper = 'formHeader';

    public function init()
    {
        $this->getView()->addHelperPath('View/Helper/', 'View_Helper');
    }
}
