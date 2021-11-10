<?php

use App\Autoloader;
use App\Classes\PostManager;
use App\Classes\CommentManager;

require_once './Autoloader.php';
Autoloader::register();

$id = $_GET['id'];
// reqête un article selon son id
$post = new PostManager();
$onePost = $post->get($id);


// Ajoit un commentaire
$newComment = new CommentManager();
$newComment->add($_POST);



// reqête des commentaires liés à l'article (id)
$comments = new CommentManager();
$allComments = $comments->get($id);



// affichage
$title = $onePost["title"];
$template = "show_post";
include './layout.phtml';
