<?php

class Main_Form_Login extends Form_Abstract
{
    public static function create()
    {
        return self::getInstance()
            ->addElement('text', 'input');
    }
}