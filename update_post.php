<?php
session_start();

if(!isset($_SESSION['email'])){
    header('Location: login.php');
    exit();
}

require_once './dbconnect.php';

$id = $_GET['id'];

$sql = "SELECT title, 
content, categories.name, authors.firstname, authors.lastname, author_id, category_id
FROM `posts`
INNER JOIN categories ON categories.id = posts.category_id 
INNER JOIN authors ON authors.id = posts.author_id
WHERE posts.id = $id";

$query1 = $pdo->query($sql);
$post = $query1->fetch();


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
        $sql = "UPDATE `posts` SET `title` = '$title', `content` = '$content', `category_id` = '$category_id', `author_id` = '$author_id'  WHERE `posts`.`id` = $id";
        // Exécuter la requête sur la base de données
        
        $query3 = $pdo->prepare($sql);
        $query3->execute([$title, $content, $author_id, $category_id, $id ]);
    
    
        header('location: admin_post_index.php');
    }
} 



// affichage
$title = "Modification d'un article";
$template = "update_post";
include './layout.phtml';