<?php
    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/src/check/check_admin.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';

    $id = (int)$_GET['id'];
    $url = $_SERVER['HTTP_REFERER'];

    // checking the existence of a given id
    $check_login = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$id'");
    if (!(mysqli_num_rows($check_login) > 0)) {
        header('Location: /profile.php');
        die();
    }

    $check_login = mysqli_fetch_assoc($check_login);
    $login = $check_login['login'];

    // protection against sql injection using prepared statements
    $sql = "INSERT INTO `admin` (`login`) VALUES (?)";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, 's', $login);
    mysqli_stmt_execute($stmt);
    header('Location: '.$url);
