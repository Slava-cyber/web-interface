<?php
    session_start();
    require_once '../check/check_admin.php';
    require_once '../../config/connect.php';

    $id = (int)$_GET['id'];
    //$login = $_GET['login'];
    $url = $_SERVER['HTTP_REFERER'];

   /* $sql = "SELECT * FROM `users` WHERE `login` = ?";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, 's', $login);
    mysqli_stmt_execute($stmt);
    $check_login = mysqli_stmt_get_result($stmt);
*/
    $check_login = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$id'");
    if (!(mysqli_num_rows($check_login) > 0)) {
        header('Location: /profile.php');
        die();
    }

    $check_login = mysqli_fetch_assoc($check_login);
    $login = $check_login['login'];
    $sql = "DELETE FROM `admin` WHERE `login` = ?";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, 's', $login);
    mysqli_stmt_execute($stmt);
    //mysqli_query($connect, "DELETE FROM `admin` WHERE `login` = '$login'");
    if ($_SESSION['user']['login'] === $login) {
        header('Location: /src/logout.php');
        die();
    } else {
        header('Location: '.$url);
    }
?>