<?php
use App\Autoloader;
use App\classes\PostManager;

include_once './App.php';


$post = new PostManager();
$posts = $post->indexPosts();

// affichage
$title = "Accueil du Blog";
$template = "index";
include './views/layout.phtml';
