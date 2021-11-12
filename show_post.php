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


// reqête des commentaires liés à l'article (id)
$comment = new CommentManager();
$allComments = $comment->get($id);

// Récupération commentaire et test
$nickname = '';
$content = '';

if (!empty($_POST)) {
    $nickname = $_POST["nickname"];
    $post_id = $_POST["post_id"];
    $content = $_POST["content"];

    $errors = [];

    if (empty($nickname)) {
        $errors['nickname'] = 'Le pseudo est obligatoire';
    }
    if (empty($content)) {
        $errors['content'] = 'Le message est obligatoire';
    } elseif (strlen($content) < 3) {
        $errors['content'] = 'Le message doit faire au moins 3 caractères';
    }

    if (empty($errors)) {
        // Ajout un commentaire si pas d'erreur
       
        $comment->add($_POST);
        $allComments = $comment->get($id);
    }
}




// affichage
$title = $onePost["title"];
$template = "show_post";
include './views/layout.phtml';
