<?php
    session_start();

    require_once $_SERVER['DOCUMENT_ROOT'].'/src/check/check_admin.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
    
    $id = (int)$_POST['id'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $birth_date = $_POST['birth_date'];
    $gender = $_POST['gender'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];

    // checking the existence of id
    $check_id = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$id'");
    if (!(mysqli_num_rows($check_id) > 0)) {
        header('Location: /profile.php');
        die();
    }

    // protection against sql injection using prepared statements
    $sql = "SELECT * FROM `users` WHERE `login` = ? AND (`id` < '$id' OR `id` > '$id')";
    $stmt = mysqli_prepare($connect, $sql);
    mysqli_stmt_bind_param($stmt, 's', $login);
    mysqli_stmt_execute($stmt);
    $check_login = mysqli_stmt_get_result($stmt);

    // validation
    require_once $_SERVER['DOCUMENT_ROOT'].'/src/validation.php';

    if ($password === $password_confirm) {
        $password = md5($password);

        $sql = "UPDATE `users`
        SET `name` = ?, `surname` = ?, `birth_date` = '$birth_date',
        `gender` = ?, `login` = ?,
        `password` = ? WHERE `users`.`id` = ?";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, 'sssssi', $name, $surname, $gender, $login, $password, $id);
        mysqli_stmt_execute($stmt);        

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
