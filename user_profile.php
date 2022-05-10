<?php
    session_start();
    if ($_SESSION['user']) {
        if ($_SESSION['user']['admin_status']) {
            header('Location: profile.php');
        }
    } else {
        header('Location: index.php');
    }
?>


<!DOCTYPE html>
<html lang='ru'>
<head>
    <meta charset="UTF-8">
    <title>Авторизация и регистрация</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body class="profile">
    <div class="log">
        <a href="src/logout.php" class="logout">Выход</a> <br>
    </div>
    <div class="user-profile">
         <p>
            К сожалению вы не администратор, так что здесь будет скучновато:( <br>
            Пока не дадут права админа, можно посмотреть как бегает Форест:)
        </p>
        <img src="img/forrest.gif">
    </div>
    
</body>
</html>