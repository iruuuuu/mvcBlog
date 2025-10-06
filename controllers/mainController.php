<?php
require_once('models/Post.php');
require_once('models/User.php');
require_once('models/PostRepository.php');

session_start();

$db = Connection::connect();

if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = false;
}

if (isset($_GET['c'])) {
    require_once('controllers/' . $_GET['c'] . 'Controller.php');
} else {
    if (!($_SESSION['user'])) {
        require_once('controllers/userController.php');
    } else {
        require_once('controllers/postController.php');
    }
}
?>
