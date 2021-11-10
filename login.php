<?php


// Inscription
if (isset($_SESSION['name'])) {
    header('Location: admin_post_index.php');
    exit();
}

if (isset($_POST['login'])) {
    // var_dump($_POST);
    include_once './dbconnect.php';

    $name = $_POST['name'];
    $password = $_POST['password'];

    $errors = [];

    // preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*W).*$#", $password ))
    // if (strlen($password) < 6) {
    //     $errors['password'] = 'Password must be at least 6 characters';
    //     goto show_view;
    // }

    $sql = "SELECT * FROM admin WHERE name = :name";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['name' => $name]);
    $user = $stmt->fetch();
    var_dump($user);
    if ($user) {
        if (($password == $user['password'])) {
            session_start();
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            header('Location: admin_post_index.php');
        } else {
            echo '<script>alert("Wrong name or password")</script>';
        }
    } else {
        echo '<script>alert("Wrong name or password")</script>';
    }
}





show_view:
// affichage
$title = "Connexion";
$template = "login";
include './layout.phtml';
