<?php
    session_start();
    require_once '../../config/connect.php';

    $login = $_GET['login'];
    $url = $_SERVER['HTTP_REFERER'];

    $check_login = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login'");
    if (!(mysqli_num_rows($check_login) > 0)) {
        header('Location: ../../profile.php');
    }

    mysqli_query($connect, "INSERT INTO `admin` (`login`) VALUES ('$login')");

    header('Location: '.$url);
?>