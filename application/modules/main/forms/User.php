<?php

class Main_Form_User extends Form_Abstract
{
    public static function createSignIn()
    {
        return self::getInstance()
            ->addElement('text', 'email', array(
                'description'   => '(Or User Name)',
                'label'         => 'Account Email',
                'required'      => true,

                'validators'   => array(
                    array('NotEmpty', true, array(
                        'messages' => array(
                            'isEmpty' => 'Please provide your account email or username.')
                         )
                    )
                )
            ))

            ->addElement('password', 'password', array(
                'label'     => 'Password',
                'required'  => true,

                'validators'   => array(
                    array('NotEmpty', true, array(
                        'messages' => array(
                            'isEmpty' => 'Please provide your account password.')
                         )
                    )
                )
            ))

            ->addFooter('Sign In');
    }
}
