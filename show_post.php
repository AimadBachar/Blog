<?php

use App\Autoloader;
use App\Classes\PostManager;

require_once './Autoloader.php';
Autoloader::register();

$id = $_GET['id'];
// reqête un article selon son id
$post = new PostManager();
$onePost = $post->get($id);


$nickname = '';
$content = '';


if(!empty($_POST)) {
    $nickname = $_POST["nickname"];
    $post_id = $_POST["post_id"];
    $content = $_POST["content"];

    $errors = [];

    if (empty($nickname)) {
        $errors['nickname'] = 'Le pseudo est obligatoire';
    }
    if (empty($nickname)) {
        $errors['content'] = 'Le message est obligatoire';
    } elseif (strlen($content) < 3 ) {
        $errors['content'] = 'Le message doit faire au moins 3 caractères';
    }

    if (empty($errors)) {
        //requéte SQL + mot de passe crypté
        $sql = "INSERT INTO `comments` (`nickname`, `content`, `post_id`) 
                    VALUES ('$nickname', '$content', '$post_id')";
        // Exécuter la requête sur la base de données
        
        $query3 = $pdo->exec($sql);
    }

}


// reqête des commentaires liés à l'article (id)
$sqlComment = "SELECT 
    comments.post_id,
    DATE_FORMAT(comments.created_at, '%W %e %M %Y') AS created_at, comments.id, comments.nickname, comments.content
    FROM `posts`
    INNER JOIN comments ON comments.post_id = posts.id
    WHERE posts.id = $id
    ORDER BY created_at DESC";

// $query2 = $pdo->query($sqlComment);
// $comments = $query2->fetchAll();


// affichage
$title = $onePost["title"];
$template = "show_post";
include './layout.phtml';

// if(!empty($_POST)) {
//     $nickname = $_POST["nickname"];
//     $post_id = $_POST["post_id"];
//     $content = $_POST["content"];
//     //requéte SQL + mot de passe crypté
//     $sql = "INSERT INTO `comments` (`nickname`, `content`, `post_id`) 
//                 VALUES ('$nickname', '$content', '$post_id')";
//     // Exécuter la requête sur la base de données
    
//     $query3 = $pdo->exec($sql);
// }