<?php
    session_start();
    
    if (!$_SESSION['user']) {
        header('Location: ../index.php');
    }
    
    require_once '../config/connect.php';
    
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $birth_date = $_POST['birth_date'];
    $gender = $_POST['gender'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    
    $check_login = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login'");
    
    if (mysqli_num_rows($check_login) > 0) {
        $response = [
            "status" => false,
            "message" => 'Такой логин уже существует',
            "type" => 1,
            "fields" => ['login']
        ];

        echo json_encode($response);
        die();
    }

    $error = [];

    if ($name == '') {
        $error[] = 'name';
    }

    if ($surname == '') {
        $error[] = 'surname';
    }
    
    if ($birth_date == '') {
        $error[] = 'birth_date';
    }
    
    if ($login == '') {
        $error[] = 'login';
    }

    if ($password == '') {
        $error[] = 'password';
    }

    if ($password_confirm == '') {
        $error[] = 'password_confirm';
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

    if ($gender == 1) {
        $gender = 'Мужской';
    } else if ($gender == 2) {
        $gender = 'женский';
    } else {
        $response = [
            "status" => false,
            "message" => 'Укажите пол',
            "gender" => $gender
        ];

        echo json_encode($response);
        die();
    }

    if ($password === $password_confirm) {
        $password = md5($password);
        mysqli_query($connect, "INSERT INTO `users` 
        (`id`, `name`, `surname`, `birth_date`, `gender`, `login`, `password`) 
        VALUES (NULL, '$name', '$surname', '$birth_date', '$gender', '$login', '$password')");

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
?>