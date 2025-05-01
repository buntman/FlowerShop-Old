<?php

namespace App\Config;

session_start();

$timeout = 900;

if (isset($_SESSION[ 'lastaccess' ])) {
    $duration = time() - intval($_SESSION[ 'lastaccess' ]);

    if ($duration > $timeout) {
        session_unset();

        session_destroy();

        header("Location: /employee/login");
        exit();
    }
}

$_SESSION['lastaccess'] = time();
