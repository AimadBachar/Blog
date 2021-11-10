<?php
session_start();

if(!isset($_SESSION['email'])){
    header('Location: login.php');
    exit();
}

require_once './dbconnect.php';


// récupération des infos des articles
$sql =
    'SELECT 
    posts.id, title, 
    DATE_FORMAT(created_at, "%d/%m/%Y") AS created_at, categories.name, authors.firstname, authors.lastname 
    FROM `posts` 
    INNER JOIN categories ON categories.id = posts.category_id 
    INNER JOIN authors ON authors.id = posts.author_id 
    ORDER BY created_at ASC';

$query = $pdo->prepare($sql);
$query->execute();
$articles = $query->fetchAll();


// Suppression d'un article
if (!empty($_GET['id'])) {
    $id = $_GET['id'];
    $sql =
        "DELETE FROM `posts` 
    WHERE `posts`.`id` = $id";

    $query = $pdo->prepare($sql);
    var_dump($query);
    $query->execute();
    header('location: admin_post_index.php');
}


// affichage
$title = "Page d'administration des articles";
$template = "admin_post_index";
include './layout.phtml';
