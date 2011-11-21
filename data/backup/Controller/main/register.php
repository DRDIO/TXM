<?php

$errors   = array();
$postlist = array(
    'register'  => (bool) $router->getVar('register', false),
    'link_name' => $router->getVar('link_name', ''),
    'email'     => $router->getVar('email', ''),
    'pass'      => $router->getVar('pass', ''),
    'date_y'    => $router->getVar('date_y', ''),
    'date_m'    => $router->getVar('date_m', ''),
    'date_d'    => $router->getVar('date_d', ''),
    'robot'     => !(bool) $router->getVar('name', false),
    'terms'     => (bool) $router->getVar('terms', false));

$errors = array();

if ($R->user['logged']) {
    // User is already logged in so prompt logout
    $template->setSwitch('promptLogout');
} else if($postlist['register']) {
    if ($postlist['robot']) {
        // User answered hidden field
        $errors[] = 'We have our suspicions that you are a robot.';
    } else {
        // Validate Link Name
        if (preg_match('/^[a-z0-9-]{1,25}$/i', $postlist['link_name']) !== 1) {
            $errors[] = 'Your link name may only contain letters, numbers, and \'-\'.';
        } else {
            // Check if user already exists
            $select = $dbAdapter->select()
                ->from('txm_users', 'id')
                ->where($dbAdapter->quoteIdentifier('link_name') . ' = ?');

            $userId = $dbAdapter->fetchOne($select, array($postlist['link_name']));

            if ($userId) {
                $errors[] = 'The link name you provided is already being used.';
            } else {
                // Check that the name is not reserved
                $select = $dbAdapter->select()
                    ->from('reservednames', 'id')
                    ->where($dbAdapter->quoteIdentifier('link_name') . ' = ?');

                $userId = $dbAdapter->fetchOne($select, array($postlist['link_name']));

                if ($userId) {
                    $errors[] = 'The link name you provided is reserved.';
                }
            }
        }

        // Validate Email
        if(preg_match('/^[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*@([a-z0-9]([a-z0-9-]*[a-z0-9])?\.)+[a-z0-9]([a-z0-9-]*[a-z0-9])?$/i', $postlist['email']) !== 1) {
            $errors[] = 'Please provide a valid email address.';
        } else {
            // Check that the domain is valid (doesn't work in windows)
            $domain = substr($postlist['email'], strpos($postlist['email'], '@') + 1);
            if(!checkdnsrr($domain . '.', 'MX') && !checkdnsrr($domain . '.', 'A')) {
                $errors[] = 'The email domain you provided is not recognized.';
            } else {
                // Check existing emails
                $select = $dbAdapter->select()
                    ->from('reservednames', array('id', 'deleted'))
                    ->where($dbAdapter->quoteIdentifier('email') . ' = ?');

                $user = $dbAdapter->fetchRow($select, array($postlist['email']));

                if ($user) {
                    if ((int) $user['deleted'] === 0) {
                        $errors[] = 'The email you provided has been banned.';
                    } else {
                        $errors[] = 'The email you provided is already in use. If you\'ve <a href="/resetpassword/">Forgotten Your Password</a>, you may retrieve it.';
                    }
                }
            }
        }

        // Validate Password
        if(strlen($postlist['pass']) < 6 || strlen($postlist['pass']) > 16) {
            $errors[] = 'Your password must be 6 to 16 characters.';
        }

        // Validate Birth Date
        if(checkdate((int) $postlist['date_m'], (int) $postlist['date_d'], (int) $postlist['date_y']) == false) {
            $errors[] = 'Please provide a valid birth date.';
        } else if((int) date('Ymd') - 130000 < (int) ($postlist['date_y'] . $postlist['date_m'] . $postlist['date_d'])) {
            $errors[] = 'You must be at least 13 years old.';
        }

        // Validate Terms
        if($postlist['terms'] == false) {
            $errors[] = 'You must agree to the Terms of Use and Privacy Policy.';
        }

        if(sizeof($errors) == false) {
            $actkey = md5(uniqid($R->ipaddr));

            $linkedName = strtolower($postlist['link_name']);
            $nickName   = ucwords(strtolower(str_replace('-', ' ', $postlist['link_name'])));

            $rowsAffected = $dbAdapter->insert('txm_users', array(
                'link_name'     => $linkName,
                'nick_name'	    => $nickName,
                'email'			=> $postlist['email'],
                'password'		=> md5($postlist['pass']),
                'date_register' => '(NOW())',
                'ip_address'    => $R->ipaddr,
                'status'		=> $R->levels['member'],
                'deleted'		=> 0,
                'user_actkey'	=> $actkey));

            if ($rowsAffected) {
                $id = $dbAdapter->lastInsertId();

                // Update storage to include id, linkName, and nickName
                $storage = $auth->getStorage();
                $storage->write(array(
                	'id'       => $id,
                    'linkName' => $linkName,
                    'nickName' => $nickName));

                $template->setSwitch('success');
            }
        } else {
            // Display errors
            $count = 0;
            foreach($errors as $error) {
                $template->addBlock('error', array(
                    'color' => ($count % 2 ? '' : 'err-alt'),
                    'text'  => $error));
                $count++;
            }
        }
    }
}

// If no errors or not registering, redisplay fields
if (sizeof($errors) || $postlist['register'] == false) {
    $date = Txm_Date::build($postlist['date_y'], $postlist['date_m'], $postlist['date_d'], date('Y') - 120, 120);

    $template->addBlock('register', array(
        'link_name' => $postlist['link_name'],
        'email'     => $postlist['email'],
        'date_y'    => $date['y'],
        'date_m'    => $date['m'],
        'date_d'    => $date['d'],
        'terms'     => ($postlist['terms'] ? 'checked="checked"' : '')));
}