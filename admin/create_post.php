<?php

session_start();

if(!isset($_SESSION['email'])){
    header('Location: login.php');
    exit();
}

require_once './dbconnect.php';

$title = '';
$content = '';
$category_id = '';
$author_id = '';

if(!empty($_POST)) {
    $title = $_POST["title"];
    $content = $_POST["content"];
    $category_id = $_POST["category"];
    $author_id = $_POST["author"];

    $errors = [];
    if (empty($title)) {
        $errors['title'] =  'Vous n\'avez pas fourni de titre'; 
    }

    if (empty($content)) {
        $errors['content'] = 'Le contenu est obligatoire';
    } elseif (strlen($content) < 100 || strlen($content) > 10000) {
        $errors['content'] = 'Le contenu doit faire au moins 100 caractères et au plus 10000 caractères.';
    }

    // on vérifie que la catégorie existe
    if(!intval($category_id)) {
        $errors['category'] = 'La catégorie n\'existe pas';
    }

    // on vérifie que l'auteur existe
    if(!intval($author_id)) {
        $errors['author'] = 'L\'auteur n\'existe pas';
    }

    if (empty($errors)) {
        //requéte SQL 
        $sql = "INSERT INTO `posts` (`title`, `content`, `author_id`, `category_id`) 
                    VALUES (?, ?, ?, ?)";
        // Exécuter la requête sur la base de données
        
        $query3 = $pdo->prepare($sql);
        $query3->execute([$title, $content, $author_id, $category_id ]);
    
    
        header('location: admin_post_index.php');
    }
} 

// récupération des catégories pour le select
$sql =
'SELECT
    id, name FROM categories;
';

$query = $pdo->prepare($sql);
$query->execute();
$categories = $query->fetchAll();

//récupération des auteurs pour le select
$sql1 =
'SELECT
    id, firstname, lastname FROM authors;
';

$query = $pdo->prepare($sql1);
$query->execute();
$authors = $query->fetchAll();


// affichage
$title = "Création d'un article";
$template = "create_post";
include './layout.phtml';

