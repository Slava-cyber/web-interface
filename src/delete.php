<?php
    session_start(); 
    require_once $_SERVER['DOCUMENT_ROOT'].'/src/check/check_admin.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';

    $url_referer = $_SERVER['HTTP_REFERER'];
    
    $id = (int)$_GET['id'];

    $url_get = $_SERVER['QUERY_STRING'];

    $user = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$id'");
    if (mysqli_num_rows($user) > 0) {
        mysqli_query($connect, "DELETE FROM `users` WHERE `id` = '$id'");
    }

    header('Location: '.$url_referer);

