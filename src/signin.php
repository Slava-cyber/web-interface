<?php
    session_start();
    if ($_SESSION['user']) {
        header('Location: /profile.php');
        die();
    }

    require_once $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';

    $login = $_POST['login'];
    $password = $_POST['password'];

    // validation
    $error = [];

    if ($login === '') {
        $error[] = 'login';
    }

    if ($password === '') {
        $error[] = 'password';
    }

    if (!empty($error)) {
        $response = [
            "status" => false,
            "message" => 'Проверьте правильность полей',
            "type" => 1,
            "fields" => $error
        ];
        
        echo json_encode($response);

        die();
    }

    $password = md5($password);

    // protection against sql injection using prepared statements
    $sql =  "SELECT * FROM `users` WHERE `login` = ? AND `password` = ?";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $login, $password);
    mysqli_stmt_execute($stmt);
    $check_user = mysqli_stmt_get_result($stmt);
    
    if (mysqli_num_rows($check_user) > 0) {

        $user = mysqli_fetch_assoc($check_user);
        
        
        $sql =  "SELECT * FROM `admin` WHERE `login` = ?";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, 's', $login);
        mysqli_stmt_execute($stmt);
        $check_admin = mysqli_stmt_get_result($stmt);
        
        if (mysqli_num_rows($check_admin) > 0) {
            $admin_status = true;

            $response = [
                "status" => true,
                "admin_status" => $admin_status
            ];
        } else {
            $admin_status = false;

            $response = [
                "status" => true,
                "admin_status" => $admin_status
            ];
        }

        $_SESSION['user'] =  [
            "id" => $user['id'],
            "name" => $user['name'],
            "surname" => $user['surname'],
            "birth_date" => $user['birth_date'],
            "gender" => $user['gender'],
            "login" => $user['login'],
            "password" => $user['password'],
            "admin_status" => $admin_status 
        ];
    
        echo json_encode($response);
    
    } else {

        $response = [
            "status" => false,
            "message" => 'Неверный логин или пароль'
        ];

        echo json_encode($response);
    }
