<?php

if (isset($_GET['action']) && $_GET['action'] === 'create') {
    if (!isset($_SESSION['user']) || !is_object($_SESSION['user'])) {
        header('Location: index.php?c=user');
        exit;
    }
    require_once 'views/createPostView.phtml';
    exit;
}

if (isset($_GET['delete'])) {
    if (!isset($_SESSION['user']) || !is_object($_SESSION['user'])) {
        header('Location: index.php');
        exit;
    }
    
    $post_id = intval($_GET['delete']);
    
    if ($_SESSION['user']->isAdmin()) {
        // Admin can delete any post
        $q = 'DELETE FROM post WHERE id=' . $post_id;
    } else {
        // Regular users can only delete their own posts
        $q = 'DELETE FROM post WHERE id=' . $post_id . ' AND user_id=' . $_SESSION['user']->getId();
    }
    
    $result = $db->query($q);
    header('Location: index.php');
    exit;
}

if (isset($_POST["title"]) && isset($_POST["text"])) {
    if (!isset($_SESSION['user']) || !is_object($_SESSION['user'])) {
        header('Location: index.php');
        exit;
    }
    
    $title = $_POST['title'];
    $text = $_POST['text'];
    $author = $_SESSION['user']->getUsername();
    $user_id = $_SESSION['user']->getId();
    
    PostRepository::addPost($title, $text, $author, $user_id);
    header('Location: index.php');
    exit;
}

$posts = PostRepository::getPosts();
$postComments = array();
foreach ($posts as $post) {
    $postComments[$post->getId()] = CommentRepository::getCommentsByPostId($post->getId());
}

require_once 'views/blogView.phtml';
?>
