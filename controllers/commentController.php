<?php

if (isset($_POST["comment_text"]) && isset($_POST["post_id"])) {
    if (!isset($_SESSION['user']) || !is_object($_SESSION['user'])) {
        header('Location: index.php');
        exit;
    }
    
    $texto = $_POST['comment_text'];
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user']->getId();
    
    CommentRepository::addComment($texto, $post_id, $user_id);
    header('Location: index.php');
    exit;
}

if (isset($_GET['delete_comment'])) {
    if (!isset($_SESSION['user']) || !is_object($_SESSION['user'])) {
        header('Location: index.php');
        exit;
    }
    
    $comment_id = $_GET['delete_comment'];
    $user_id = $_SESSION['user']->getId();
    
    CommentRepository::deleteComment($comment_id, $user_id);
    header('Location: index.php');
    exit;
}
?>
