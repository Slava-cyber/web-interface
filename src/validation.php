<?php

    if (!isset($id)) {
        header('Location: /index.php');
        die();
    }

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
    $message = 'Проверьте правильность полей';

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
            "message" => $message,
            "type" => 1,
            "fields" => $error
        ];

        echo json_encode($response); 
        die();
    }

    if (strlen($password) < 5 || strlen($password_confirm) < 5) {
        $error[] = 'password';
        $error[] = 'password_confirm';
        $message = 'Пароль должен быть более 4 символов';
        $response = [
            "status" => false,
            "message" => $message,
            "type" => 1,
            "fields" => $error
        ];

        echo json_encode($response); 
        die();
    }

    if ($gender == 1) {
        $gender = 'Мужской';
    } else if ($gender == 2) {
        $gender = 'Женский';
    } else {
        $response = [
            "status" => false,
            "message" => 'Укажите пол',
            "gender" => $gender
        ];

        echo json_encode($response);
        die();
    }
