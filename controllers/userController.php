<?php

// Logout
if(isset($_GET['logout'])){
    $_SESSION['user'] = false;
    session_destroy();
    header('Location: index.php');
    exit;
}

// Login
if (isset($_POST['username']) && isset($_POST['password'])) {
    $loginSuccess = UserRepository::login($_POST['username'], $_POST['password']);
    if ($loginSuccess) {
        header('Location: index.php?c=post&action=create');
        exit;
    } else {
        // Opcional: Pasar un mensaje de error a la vista
        $error = "Nombre de usuario o contraseña incorrectos.";
    }
}

// Register
if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password2'])){
    if(UserRepository::register($_POST['username'], $_POST['password'], $_POST['password2'])){
        // After successful registration, log the user in automatically
        UserRepository::login($_POST['username'], $_POST['password']);
        // Redirect to create post page
        header('Location: index.php?c=post&action=create');
        exit;
    }else{
        $error = "Error en el registro. El usuario puede ya existir o las contraseñas no coinciden.";
    }
}

// Show register view
if(isset($_GET['register'])){
    require_once('views/registerView.phtml');
    exit;
}

// Mostrar vista de login
require_once('views/loginView.phtml');
?>
