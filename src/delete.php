<?php
    session_start();
    
    require_once 'check/check_admin_level_deep.php';
    require_once '../config/connect.php';

    $id = $_GET['id'];

    $url_get = $_SERVER['QUERY_STRING'];

    $user = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$id'");
    if (mysqli_num_rows($user) > 0) {
        mysqli_query($connect, "DELETE FROM `users` WHERE `id` = '$id'");
    }

    header('Location: ../profile.php?'.$url_get);
?>
