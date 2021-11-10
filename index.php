<?php
use App\Autoloader;
use App\Classes\Posts;

require_once './Autoloader.php';
Autoloader::register();


$post = new Posts();
$post = $post->findAll();

var_dump($post);
