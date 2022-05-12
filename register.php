<?php
    session_start();
    if (!$_SESSION['user']['admin_status'] && $_SESSION['user']) {
        header('Location: user_profile.php');
        die();
    }

    $url_referer = $_SERVER['HTTP_REFERER'];

?>

<!DOCTYPE html>
<html lang='ru'>
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body class="index">
    <!-- Registration form -->
    <form>
        <label>Имя</label>
        <input type="hidden" name="url" value="<?= $url_referer ?>">
        <input type="text" name="name" placeholder="Введите имя">
        <label>Фамилия</label>
        <input type="text" name="surname" placeholder="Введите фамилию">
        <label>Дата рождения</label>
        <input type="date" name="birth_date" placeholder="Выберите дату рождения">
        <label>Укажите ваш пол</label>
        <div>
            <input id="radio1" name="gender" type="radio" value="1">
            <label for="radio1">Мужской</label><br/>
            <input id="radio2" name="gender" type="radio" value="2">
            <label for="radio2">Женский</label><br/>
        </div>
        <label>Логин</label>
        <input type="text" name="login" placeholder="Введите свой логин">
        <label>Пароль</label>
        <input type="password" name="password" placeholder="Введите пароль">
        <label>Подтверждение пароля</label>
        <input type="password" name="password_confirm" placeholder="Подтвердите пароль">
        <?php
            if ($_SESSION['user']['admin_status']) {
                ?>
                <button type="submit" class="register-button">Добавить нового пользователя</button>
                <p>
                    <a href="<?= $url_referer ?> ">Назад</a>
                </p>
                <?php
            } else {
                ?>
                <button type="submit" class="register-button">Зарегистрировать</button>
                <p>
                У вас уже есть аккаунт? - <a href="/">авторизируйтесь</a>
                </p>
                <?php
            }
            ?>
        <p class="msg none">'error</p>
    </form>

    <script src="assets/js/jquery-3.4.1.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>