<?php

$filename = __DIR__.'/conf-local.php';
if (file_exists($filename)) {
    require_once $filename;
} else {
    $GLOBALS['PDOconnect']=[
        'host'=>'localhost',
        'username'=>'kp_user',
        'password'=>'2G5s8Z1u',
        'dbname'=>'keyword-planner',
    ];
}

