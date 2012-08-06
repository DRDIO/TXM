<?php

class Form_Abstract extends Zend_Form
{
    protected static $_form;

    public static function getInstance()
    {
        if (!self::$_form) {
            $c = __CLASS__;
            self::$_form = new $c;
        }

        self::$_form
            ->addPrefixPath('Form_Decorator', 'Form/Decorator/', 'decorator')
            ->addPrefixPath('Form_Element', 'Form/Element/', 'element')
            ->addElementPrefixPath('Form_Decorator', 'Form/Decorator/', 'decorator');

        return self::$_form;
    }

    public function addHeader($title, $subtitle = null, $id = null)
    {
        $id = $id ? $id : uniqid();

        return $this->addElement('header', $id, array(
            'label'       => $title,
            'description' => $subtitle
        ));
    }

    public function addDivider($id = null)
    {
        $id = $id ? $id : uniqid();

        return $this->addElement('divider', $id);
    }

    public function decorate()
    {
        return $this
            ->setDecorators(array(
                'FormElements',
                array('Form', array('class' => 'form')),
            ))

            ->setDisplayGroupDecorators(array('FormElements', 'Composite'))

            ->setElementDecorators(array('Composite'));
    }

    public function addFooter($button = 'Submit')
    {
        return $this
            ->addDivider()

            ->addElement('submit', 'complete', array(
                'label'     => null,
                'value'     => $button
            ))

            ->addElement('reset', 'cancel', array(
                'label'     => null,
                'value'     => 'Cancel'
            ))

            ->addDisplayGroup(array('complete', 'cancel'), 'submit', array(
            ))

            ->decorate();
    }
}
