<?php
use App\Autoloader;
use App\classes\PostManager;

require_once './Autoloader.php';
Autoloader::register();


$post = new PostManager();
$posts = $post->indexPosts();

// affichage
$title = "Accueil du Blog";
$template = "index";
include './views/layout.phtml';
