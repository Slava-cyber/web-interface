<?php
    session_start();
    if ($_SESSION['user']) {
        if ($_SESSION['user']['admin_status']) {
            header('Location: profile.php');
        } else {
            header('Location: user_profile.php');
        }
    }
?>


<!DOCTYPE html>
<html lang='ru'>
<head>
    <meta charset="UTF-8">
    <title>Авторизация и регистрация</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body class="index">
    <!-- Форма авторизации -->
    <form>
        <label>Логин</label>
        <input type="text" name="login" placeholder="Введите свой логин">
        <label>Пароль</label>
        <input type="password" name="password" placeholder="Введите пароль">
        <button type="submit" class="login-button">Войти</button>
        <p>
            У вас нет аккаунта? - <a href="/register.php">зарегистрируйтесь</a>
        </p>
        
        <p class="msg none">Error</p>
    
    </form>
    
    <script src="assets/js/jquery-3.4.1.min.js"></script>
    <script src="assets/js/main.js"></script>
    
</body>
</html>