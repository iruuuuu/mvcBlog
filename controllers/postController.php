<?php
ob_start();

if (isset($_GET['action']) && $_GET['action'] === 'create') {
    if (!isset($_SESSION['user']) || !is_object($_SESSION['user'])) {
        header('Location: index.php?c=user');
        ob_end_flush();
        exit;
    }
    require_once 'views/createPostView.phtml';
    ob_end_flush();
    exit;
}

if (isset($_GET['delete'])) {
    if (!isset($_SESSION['user']) || !is_object($_SESSION['user'])) {
        header('Location: index.php');
        ob_end_flush();
        exit;
    }
    
    $q = 'DELETE FROM post WHERE id=' . $_GET['delete'] . ' AND user_id=' . $_SESSION['user']->getId();
    $result = $db->query($q);
    header('Location: index.php');
    ob_end_flush();
    exit;
}

if (isset($_POST["title"]) && isset($_POST["text"])) {
    if (!isset($_SESSION['user']) || !is_object($_SESSION['user'])) {
        header('Location: index.php');
        ob_end_flush();
        exit;
    }
    
    $title = $_POST['title'];
    $text = $_POST['text'];
    $author = $_SESSION['user']->getUsername();
    $user_id = $_SESSION['user']->getId();
    
    PostRepository::addPost($title, $text, $author, $user_id);
    header('Location: index.php');
    ob_end_flush();
    exit;
}

$posts = PostRepository::getPosts();
require_once 'views/blogView.phtml';
ob_end_flush();
?>
