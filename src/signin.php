<?php
    session_start();

    //if (!$_SESSION['user']) {
    //    header('Location: ../index.php');
    //}

    require_once '../config/connect.php';

    $login = $_POST['login'];
    $password = $_POST['password'];

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

    $check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password'");

    if (mysqli_num_rows($check_user) > 0) {

        $user = mysqli_fetch_assoc($check_user);
        
        $check_admin = mysqli_query($connect, "SELECT * FROM `admin` WHERE `login` = '$login'");
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
    
        //$response = [
        //    "status" => true
        //];

        echo json_encode($response);
    
    } else {

        $response = [
            "status" => false,
            "message" => 'Неверный логин или пароль'
        ];

        echo json_encode($response);
    }

?>
