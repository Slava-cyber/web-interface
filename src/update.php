<?php
    session_start();

    require_once 'check/check_admin.php';
    require_once '../config/connect.php';
    
    $id = (int)$_POST['id'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $birth_date = $_POST['birth_date'];
    $gender = $_POST['gender'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    
    $check_id = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$id'");
    if (!(mysqli_num_rows($check_id) > 0)) {
        header('Location: ../profile.php');
        die();
    }

    $sql = "SELECT * FROM `users` WHERE `login` = ? AND (`id` < '$id' OR `id` > '$id')";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, 's', $login);
    mysqli_stmt_execute($stmt);
    $check_login = mysqli_stmt_get_result($stmt);
    //$check_login = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login' AND (`id` < '$id' OR `id` > '$id')");
    //$check_login_another_id = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login'");
    if (mysqli_num_rows($check_login) > 0) {
        $response = [
            "status" => false,
            "message" => 'Такой логин уже существует',
            "type" => 1,
            "fields" => ['login'],
            "id" => $id
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
        $gender = 'Женский';
    } else {
        $response = [
            "status" => false,
            "message" => 'Укажите пол'
        ];

        echo json_encode($response);
        die();
    }

    if ($password === $password_confirm) {
        $password = md5($password);
        $sql = "UPDATE `users`
        SET `name` = ?, `surname` = ?, `birth_date` = '$birth_date',
        `gender` = ?, `login` = ?,
        `password` = ? WHERE `users`.`id` = ?";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, 'sssssi', $name, $surname, $gender, $login, $password, $id);
        mysqli_stmt_execute($stmt);        

        /*mysqli_query($connect, "UPDATE `users`
        SET `name` = '$name', `surname` = '$surname', `birth_date` = '$birth_date',
        `gender` = '$gender', `login` = '$login',
        `password` = '$password' WHERE `users`.`id` = '$id'");
        */

        $response = [
            "status" => true,
            "message" => 'Изменения прошли успешно'
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