<?php

session_start();

require_once './Autoloader.php';
App\Autoloader::register();

function dd($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    exit();
}