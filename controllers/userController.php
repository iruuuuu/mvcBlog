<?php

// Logout
if(isset($_GET['logout'])){
    $_SESSION['user'] = false;
    session_destroy();
    header('Location: index.php');
    exit;
}

// Login
if(isset($_POST['username']) && isset($_POST['password'])){
    $q = 'SELECT * FROM user WHERE username="'.$_POST['username'].'" AND password="'.md5($_POST['password']).'"';
    $result = $db->query($q);

    if($row = $result->fetch_assoc()){
        $_SESSION['user'] = new User($row['id'], $row['username']);
        header('Location: index.php?c=post&action=create');
        exit;
    }
}

// Register
if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password2'])){
    if(UserRepository::register($_POST['username'], $_POST['password'], $_POST['password2'])){
        require_once('views/blogView.phtml');
    }else{
        require_once('views/createPostView.phtml');
    }
    exit;
}



// Mostrar vista de login
require_once('views/loginView.phtml');
?>
