<?php
ob_start();

if(isset($_GET['logout'])){
    $_SESSION['user'] = false;
    session_write_close();
    header('Location: index.php');
    ob_end_flush();
    exit;
}

if(isset($_POST['username']) && isset($_POST['password'])){
    $q = 'SELECT * FROM user WHERE username="'.$_POST['username'].'" AND password="'.md5($_POST['password']).'"';

    $result = $db->query($q);

    if($row = $result->fetch_assoc()){
        $_SESSION['user'] = new User($row['id'], $row['username']);
        session_write_close();
        header('Location: index.php?c=post');
        ob_end_flush();
        exit;
    }
}

if(!$_SESSION['user'] || !is_object($_SESSION['user'])){
    require_once('views/blogView.phtml');
    exit;
}

header('Location: index.php?c=post');
ob_end_flush();
exit;
?>
