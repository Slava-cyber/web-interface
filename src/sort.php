<?php

    session_start();
    require_once $_SERVER['DOCUMENT_ROOT'].'/src/check/check_admin.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';

    $sort_type = $_POST['sort_type'];
    $sort_dir = $_POST['sort_dir'];

    $error = [];

    // validation
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
