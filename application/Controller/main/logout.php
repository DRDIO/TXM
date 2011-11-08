<?php

if ($auth->hasIdentity()) {
    $auth->clearIdentity();
}

header('Location: /');