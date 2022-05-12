<?php
    session_start();
    
    if (!$_SESSION['user']['admin_status'] && $_SESSION['user']) {
        header('Location: /index.php');
        die();
    }
    
    require_once $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
    
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $birth_date = $_POST['birth_date'];
    $gender = $_POST['gender'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    
    // protection against sql injection using prepared statements
    $sql = "SELECT * FROM `users` WHERE `login` = ?";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, 's', $login);
    mysqli_stmt_execute($stmt);
    $check_login = mysqli_stmt_get_result($stmt);

    // validation
    require_once $_SERVER['DOCUMENT_ROOT'].'/src/validation.php'; 

    if ($password === $password_confirm) {
        $password = md5($password);

        $sql = "INSERT INTO `users` 
        (`id`, `name`, `surname`, `birth_date`, `gender`, `login`, `password`) 
        VALUES (NULL, ?, ?, '$birth_date', ?, ?, ?)";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, 'sssss', $name, $surname, $gender, $login, $password);
        mysqli_stmt_execute($stmt);

        $response = [
            "status" => true,
            "message" => 'Регистрация прошла успешно'
        ];
        
        echo json_encode($response);
    } else {
        $response = [
            "status" => false,
            "message" => 'Пароли не совпадают'
        ];

        echo json_encode($response);
    }
