<?php
    session_start();
    require_once 'src/check/check_admin.php';
    
    /*session_start();
    if ($_SESSION['user']) {
        if (!$_SESSION['user']['admin_status']) {
            header('Location: user_profile.php');
        }
    } else {
        header('Location: index.php');
    }*/
    
    require_once 'config/connect.php';
    $id = $_GET['id'];

    $url_get = $_SERVER['QUERY_STRING'];

    $user = mysqli_query($connect, "SELECT * FROM `users` WHERE `id` = '$id'");
    if (!(mysqli_num_rows($user) > 0)) {
        header('Location: profile.php?'.$url_get);
    }

    $user = mysqli_fetch_assoc($user);
    $login = $user['name'];
    $check_admin = mysqli_query($connect, "SELECT * FROM `admin` WHERE `login` = '$login'");
    if (mysqli_num_rows($check_admin) > 0) {
        $admin_status = true;
    } else {
        $admin_status = false;
    }

?>


<!DOCTYPE html>
<html lang='ru'>
<head>
    <meta charset="UTF-8">
    <title>Профиль пользователя</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>

<h3>Информация о пользователе <?= $user['login'] ?> </h3>
<p>-Имя: <?= $user['name'] ?></p>
<p>-Фамилия: <?= $user['surname'] ?></p>
<p>-Дата рождения: <?= $user['birth_date'] ?></p>
<p>-Пол: <?= $user['gender'] ?></p>
<a href="profile.php?<?= $url_get ?>">Вернуться к списку пользователей</a>
<br><br><br><br><br>
<?php 
    if ($admin_status) {
        ?>
        <a href="src/admin/admin_delete.php?login=<?= $login ?>&<?= $url_get ?>">Убрать права администратора</a>
        <?php
    } else {
        ?>
        <a href="src/admin/admin_add.php?login=<?= $login ?>&<?= $url_get ?>">Дать права администратора</a>
        <?php
    }
?>
</body>
</html>
