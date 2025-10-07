<?php
require_once('models/Post.php');
require_once('models/User.php');
require_once('models/PostRepository.php');
require_once('models/UserRepositori.php');

session_start();

$db = Connection::connect();

if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = false;
}

if (isset($_GET['c'])) {
    require_once('controllers/' . $_GET['c'] . 'Controller.php');
} else {
    // Por defecto, mostrar el blog (público)
    require_once('controllers/postController.php');
}
?>
