<?php

$errors    = array();
$login     = (bool) $router->getVar('login', false);
$email     = $router->getVar('email', false);
$password  = $router->getVar('password', false);
$emailPreg = '/^[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@([a-z0-9]([a-z0-9-]*[a-z0-9])?\.)+[a-z0-9]([a-z0-9-]*[a-z0-9])?$/i';

if ($auth->hasIdentity()) {
    $errors[] = 'You are already logged in.';
} else if ($login) {
    // Validate Email
    if ($email == false) {
        $errors[] = 'Please provide an email.';
    } else if (preg_match($emailPreg, $email) == false) {
        $errors[] = 'Email has invalid characters.';
    }

    // Validate Password
    if ($password == false) {
        $errors[] = 'Please provide a password.';
    } else if (strlen($password) < 6) {
        $errors[] = 'Password is too short.';
    } else if (strlen($password) > 16) {
        $errors[] = 'Password is too long.';
    }

    // Authenticate
    if (sizeof($errors) == false) {
        $authAdapter->setIdentity($email);
        $authAdapter->setCredential($password);
        $result = $auth->authenticate($authAdapter);

        // Redirect to home page or inform user
        if ($result->isValid()) {
            $row = (array) $authAdapter->getResultRowObject();

            // Update storage to include id, linkName, and nickName
            $storage = $auth->getStorage();
            $storage->write(array(
            	'id'       => $row['id'],
                'linkName' => $row['link_name'],
                'nickName' => $row['nick_name']));

            header('Location: /');
        } else {
            $errors[] = 'Wrong Email/Password combination.';
        }
    }
}

if (sizeof($errors)) {
    // Display errors
    $count = 0;
    $template->setSwitch('error');
    foreach($errors as $error) {
        $template->addBlock('error.row', array(
            'color' => ($count % 2 ? '' : 'altGreen'),
            'text'  => $error));
        $count++;
    }
}

// If no errors or not registering, redisplay fields
if (sizeof($errors) || $login == false) {
    $template->addBlock('login', array(
        'email' => (string) $email));
}