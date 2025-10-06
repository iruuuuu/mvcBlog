<?php
ob_start();

if (!isset($_SESSION['user']) || !is_object($_SESSION['user'])) {
    header('Location: index.php');
    ob_end_flush();
    exit;
}

if (isset($_GET['delete'])) {
    $q = 'DELETE FROM post WHERE id=' . $_GET['delete'];
    $result = $db->query($q);
    header('Location: index.php?c=post');
    ob_end_flush();
    exit;
}

if (isset($_POST["title"]) && isset($_POST["text"])) {
    $title = $_POST['title'];
    $text = $_POST['text'];
    $author = $_SESSION['user']->getUsername();
    $user_id = $_SESSION['user']->getId();
    
    PostRepository::addPost($title, $text, $author, $user_id);
    header('Location: index.php?c=post');
    ob_end_flush();
    exit;
}

$posts = PostRepository::getPosts();
require_once 'views/blogView.phtml';
ob_end_flush();
?>
