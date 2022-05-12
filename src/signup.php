<?php
    session_start();
    
    if (!$_SESSION['user']['admin_status'] && $_SESSION['user']) {
        header('Location: ../index.php');
        die();
    }
    
    require_once '../config/connect.php';
    
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

    //$check_login = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login'");
    
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
        //$message = 'Пароль должен быть более 4 символов';
    }

    if ($password_confirm == '') {
        $error[] = 'password_confirm';
       // $message = 'Пароль должен быть более 4 символов';
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

    if ($password === $password_confirm) {
        $password = md5($password);

        $sql = "INSERT INTO `users` 
        (`id`, `name`, `surname`, `birth_date`, `gender`, `login`, `password`) 
        VALUES (NULL, ?, ?, '$birth_date', ?, ?, ?)";
        $stmt = mysqli_prepare($connect, $sql);
        mysqli_stmt_bind_param($stmt, 'sssss', $name, $surname, $gender, $login, $password);
        mysqli_stmt_execute($stmt);

        /*mysqli_query($connect, "INSERT INTO `users` 
        (`id`, `name`, `surname`, `birth_date`, `gender`, `login`, `password`) 
        VALUES (NULL, '$name', '$surname', '$birth_date', '$gender', '$login', '$password')");
*/
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