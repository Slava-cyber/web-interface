<?php
    session_start();

    require_once 'check/check_admin_level_deep.php';
    /*if ($_SESSION['user']) {
        if (!$_SESSION['user']['admin_status']) {
            header('Location: ../user_profile.php');
        }
    } else {
        header('Location: ../index.php');
    }*/

    $on_page = $_POST['on_page'];

    if (!isset($on_page)) {
        $response = [
            "status" => false,
            "message" => 'Введите значение'
        ];

        echo json_encode($response);
    } else if ($on_page < 1 || $on_page > 10) {
        $response = [
            "status" => false,
            "message" => 'Введите значение в диапозоне от 1-10',
        ];

        echo json_encode($response);
    } else {
        $response = [
            "status" => true
        ];

        echo json_encode($response);
    }
?>