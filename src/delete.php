<?php
    session_start();
    
    //session_start();
   /* if ($_SESSION['user']) {
        if (!$_SESSION['user']['admin_status']) {
            header('Location: /user_profile.php');
        }
    } else {*/
        //header('Location: ../index.php');
    //}
    
    require_once 'check/check_admin.php';
    require_once '../config/connect.php';

    $url_referer = $_SERVER['HTTP_REFERER'];
    
    $id = (int)$_GET['id'];

    $url_get = $_SERVER['QUERY_STRING'];

    $user = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$id'");
    if (mysqli_num_rows($user) > 0) {
        mysqli_query($connect, "DELETE FROM `users` WHERE `id` = '$id'");
    }

    header('Location: '.$url_referer);
?>
