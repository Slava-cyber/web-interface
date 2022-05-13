<?php
    session_start();

    require_once $_SERVER['DOCUMENT_ROOT'].'/src/check/check_admin.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/config/connect.php';
    $url_referer = $_SERVER['HTTP_REFERER'];
    
    // simple protection against SQL injection with integer parameters
    $user_id = (int)$_GET["id"];
    
    $user = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$user_id'");
    if (!(mysqli_num_rows($user) > 0)) {
        header('Location: /profile.php');
        die();
    }

    $user = mysqli_fetch_assoc($user);
?>


<!DOCTYPE html>
<html lang='ru'>
<head>
    <meta charset="UTF-8">
    <title>Обновление данных пользователя</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body class="index">
    <!-- Data update form -->
    <form>
        <h2>Обновление данных пользователя</h2> <br>
        <input type="hidden" name="url" value="<?= $url_referer ?>">
        <input type="hidden" name="id" value="<?= $user['id'] ?>">
        <label>Имя</label>
        <input type="text" name="name" placeholder="Введите имя", value="<?= $user['name']?>" >
        <label>Фамилия</label>
        <input type="text" name="surname" placeholder="Введите фамилию", value="<?= $user['surname']?>">
        <label>Дата рождения</label>
        <input type="date" name="birth_date" placeholder="Выберите дату рождения", value="<?= $user['birth_date']?>" min="1920-01-01" max="2022-05-01">
        <label>Укажите ваш пол</label>
        <div>
            <input id="radio1" name="gender" type="radio" value="1">
            <label for="radio1">Мужской</label><br/>
            <input id="radio2" name="gender" type="radio" value="2">
            <label for="radio2">Женский</label><br/>
        </div>
        <label>Логин</label>
        <input type="text" name="login" placeholder="Введите свой логин", value="<?= $user['login']?>">
        <label>Пароль</label>
        <input type="password" name="password" placeholder="Введите пароль">
        <label>Подтверждение пароля</label>
        <input type="password" name="password_confirm" placeholder="Подтвердите пароль">
        <button type="submit" class="change-button">Изменить данные</button>
        <p>
        <a href="<?= $url_referer ?>">Назад</a>
        </p>
        <p class="msg none">'error</p>
    </form>

    <script src="assets/js/jquery-3.4.1.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>