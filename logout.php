<?php

require_once("autoload.php");
require_once("config/config.php");

use Models\User;
use Utils\Functions;

$user = new User;

if ( $user->checkLogin() ) {
    $user->logout();
    if ( $user->getResult() ) {
        Functions::location('http://' . URL_BASE . '/pages/login');
    }
}