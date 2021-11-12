<?php

if (!ctype_digit($_GET['id']) or !array_key_exists('id', $_GET)) {
    header('Location: index.php');
    exit();
}

include_once './App.php';

use App\Classes\PostManager;
use App\Classes\CommentManager;


$id = $_GET['id'];
// reqête un article selon son id
$post = new PostManager();
$onePost = $post->get($id);


// reqête des commentaires liés à l'article (id)
$comment = new CommentManager();
$allComments = $comment->get($id);

// Récupération commentaire et test
if (!empty($_POST) && isset($_POST['addComment'])) {
    $commentInstance = new CommentManager();

    if ($_POST['pseudo'] == '') {
        $commentInstance->setErrorNotification("pseudoError", "Pseudo est obligatoire");
    }
    if ($_POST['content'] == '') {
        $commentInstance->setErrorNotification("commentError", "Commentaire est obligatoire");
    }

    if (!$commentInstance->checkErrorsNotification("pseudoError") && !$commentInstance->checkErrorsNotification("commentError")) {
        $values = array(
            $_POST['pseudo'],
            $_POST['content'],
            $_POST['post_id']
        );
        $commentInstance->add($values);
    }
}


$commentInstance = $commentInstance ?? new CommentManager();
$comments = $commentInstance->get($_GET['id']);

// affichage
$title = $onePost["title"];
$template = "show_post";
include './views/layout.phtml';
