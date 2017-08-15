<?php

$filename = __DIR__.'/conf-local.php';
if (file_exists($filename)) {
    require_once $filename;
} else {
    $GLOBALS['PDOconnect']=[
        'host'=>'localhost',
        'username'=>'root',
        'password'=>'root',
        'dbname'=>'keyword-planner',
    ];
}

