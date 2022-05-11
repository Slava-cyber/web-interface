<?php

    session_start();
    require_once 'check/check_admin_level_deep.php';
    require_once '../config/connect.php';

    $sort_type = $_POST['sort_type'];
    $sort_dir = $_POST['sort_dir'];

    $error = [];

    if (!isset($sort_type)) {
        $error[] = 'sort_type';
    }
    
    if (!isset($sort_dir)) {
        $error[] = 'sort_dir';
    }

    if (!empty($error)) {
        $response = [
            "status" => false,
            "message" => 'Укажите поля для сортировки'
        ];

        echo json_encode($response);
    } else {
        $response = [
            "status" => true
        ];

        echo json_encode($response);
    }
    
?>