<?php

spl_autoload_register(function($className) {
    $path = __DIR__.'/lib/'.str_replace('\\', '/', $className).'.php';
    if (file_exists($path)) {
        require $path;
    }
    // we don't support this class!
});

$configuration = array(
    'db_dsn'  => 'mysql:host=127.127.126.50;dbname=oo_battle',
    'db_user' => 'wolf',
    'db_pass' => 'pass1234',
);
