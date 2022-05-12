<?php
    session_start();

    require_once 'src/check/check_admin.php';
    require_once 'config/connect.php';

    $sort_type = $_GET['sort_type'];
    $sort_dir = $_GET['sort_dir'];
    // simple protection against SQL injection with integer parameters
    $current_page = (int)$_GET['page'];
    $on_page = (int)$_GET['on_page'];

    // block check correct get parameters
    if (!isset($on_page) || $on_page < 1 || $on_page > 10) {
        $on_page = 1;
    }

     if (!($sort_dir === 'ASC' || $sort_dir === 'DESC')) {
        $sort_dir = 'ASC';
    }

    $status = 0;
    $users = mysqli_query($connect, "SELECT * FROM `users`");
    while ($field = mysqli_fetch_field($users)) {
        if ($sort_type === $field->name) {
            $status++;
        }
    }

    if (!($status > 0)) {
        $sort_type = 'id';
    }  
    
        // gettings records
    $users = mysqli_query($connect, "SELECT * FROM `users` ORDER BY `users`.`$sort_type` $sort_dir");
    $users = mysqli_fetch_all($users);
        // end
    
    $count_records = count($users);
    $count_pages = ceil($count_records / $on_page);

    if (!isset($current_page) || $current_page < 1 || $current_page > $count_pages) {
        $current_page = 1;
    }
    // end block

    // form links to navigate
    $url_get_sort = '&sort_type='.$sort_type.'&sort_dir='.$sort_dir;
    $url_basic = 'profile.php?page=';
    $url_get_without_page = '&on_page='.$on_page.$url_get_sort;
    $url_get_without_sort = $url_basic.$current_page.'&on_page='.$on_page;
    $url_get = 'page='.$current_page.$url_get_without_page;
    // end form
    
    // form paginator parameters
    $count_href = 5;
    $block = ceil(($current_page / $count_href));
    $section_left = ($block - 2) * $count_href + 1;
    $section_right = $block * $count_href + 1;
    $start_page = ($block - 1) * $count_href + 1;
    // end form
?>

<!DOCTYPE html>
<html lang='ru'>
<head>
    <meta charset="UTF-8">
    <title>Профиль</title>
    <link rel="stylesheet" href="assets/css/main.css">
</head>


<body class="profile">
    <div class="log">
        <a href="src/logout.php" class="logout">Выход</a>
    </div>
    <div class="profile_container">
        <div class="forms">
            <div class="div_sort">
                <form class="form">
                    <h2>Выберите поле для сортировки</h2> <br>
                    <h5><label>Выберите поле для сортировки</label></h5>
                    <div>
                        <input type="hidden" name="no_sort" value="<?= $url_get_without_sort ?>">
                        <input id="radio1" name="sort_type" type="radio" value="id">
                        <label for="radio1">id</label>
                        <input id="radio2" name="sort_type" type="radio" value="name">
                        <label for="radio2">Имя</label>
                        <input id="radio3" name="sort_type" type="radio" value="surname">
                        <label for="radio3">Фамилия</label>
                        <input id="radio4" name="sort_type" type="radio" value="birth_date">
                        <label for="radio4">Дата рождения</label>
                        <input id="radio5" name="sort_type" type="radio" value="gender">
                        <label for="radio5">Пол</label>
                    </div>
                    <h5><label>Тип сортировки</label></h5>
                    <div>
                        <input id="radio1" name="sort_dir" type="radio" value="ASC">
                        <label for="radio1">По возрастанию</label>
                        <input id="radio2" name="sort_dir" type="radio" value="DESC">
                        <label for="radio2">По убыванию</label>
                    </div>
                    <button type="submit" class="sort-button">Отсортировать</button>
                    <p class="msg none">'error</p>
                </form>
            </div>
            <div class="div_paginator">
                <form class="form">
                    <h2>Количество записей на одной странице</h2> <br>
                    <h5><label>Введите количество записей, отображащихся на одной странице</label></h5>
                    <div>
                        <input type="hidden" name="sort" value="<?= $url_get_sort ?>">
                        <input type="number" id="number" name="on_page" min="1" max="10">
                    </div>
                    <button type="submit" class="paginator-button">Ввести</button>
                    <p class="msg2 none">Сейчас на странице отображается записей: <?= $record_on_page ?></p>
                </form>
            </div> 
        </div>

        <div class = add_user>
            <a href="register.php" class="add">Добавить нового пользователя</a>
        </div>

        <table class="table">
            <tr>
                <th>ID</th>
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Дата рождения</th>
                <th>Пол</th>
                <th>Логин</th>
                <th>Пароль</th>
            </tr>

            <?php
                $start_record = ($current_page - 1) * $on_page;
                for ($i = $start_record; $i < $start_record + $on_page && $i < $count_records; $i++) {
                    ?>
                    <tr>
                        <td class="cell"><a href="user_view.php?id=<?= $users[$i][0] ?>&<?= $url_get ?>"><?= $users[$i][0] ?></a></td>
                        <td><?= $users[$i][1] ?></td>
                        <td><?= $users[$i][2] ?></td>
                        <td class="cell"><?= $users[$i][3] ?></td>
                        <td class="cell"><?= $users[$i][4] ?></td>
                        <td><?= $users[$i][5] ?></td>
                        <td><?= $users[$i][6] ?></td>
                        <td><a href="user_update.php?id=<?= $users[$i][0] ?>">Изменить</a></td>
                        <td><a href="src/delete.php?id=<?= $users[$i][0] ?>">Удалить</a></td>
                        <?php
                            $check_login = $users[$i][5]; 
                            $sql = "SELECT * FROM `admin` WHERE `login` = ?";
                            $stmt = mysqli_prepare($connect, $sql);
                            mysqli_stmt_bind_param($stmt, 's', $check_login);
                            mysqli_stmt_execute($stmt);
                            $check_admin = mysqli_stmt_get_result($stmt); 
                            //$check_admin = mysqli_query($connect, "SELECT * FROM `admin` WHERE `login` = '$check_login'");
                            if (mysqli_num_rows($check_admin) > 0) {
                                ?>
                                <td>Admin</td>
                                <?php
                            }
                        ?>
                    </tr>
                    <?php
                }
            ?>
        </table>

        <!-- Paginator -->
        <div class="paginator">
            <nav>
                <ul>
                    
                <?php
                    if ($current_page > 1) {
                        ?>
                        <!-- transition to the previous page -->
                        <li><a href="<?= $url_basic ?><?= $current_page - 1 ?><?= $url_get_without_page ?>"><</a></li>
                        <?php    
                    }
                ?>  

                    <?php
                        if ($start_page != 1) {
                            ?>
                            <li><a href="<?= $url_basic ?>1<?= $url_get_without_page ?>">1</a></li>
                            <!-- display occurs in blocks of 5 pages, "..." transition to the next or previous block -->
                            <li><a href="<?= $url_basic ?><?= $section_left ?><?= $url_get_without_page ?>">...</a></li>
                            <?php    
                        }
                    ?>

                    <?php
                        $i = $start_page;
                        while ($i < $start_page + $count_href and $i <= $count_pages) {
                            if ($i == $current_page) {
                                ?>
                                <!-- displaying the current page with a separate class for highlighting -->
                                <li><a class="active" href="<?= $url_basic ?><?= $i ?><?= $url_get_without_page ?>"><?= $i ?></a></li>
                                <?php
                            } else {
                            ?>
                            <li><a href="<?= $url_basic ?><?= $i ?><?= $url_get_without_page ?>"><?= $i ?></a></li>
                            <?php
                            }
                            $i++;    
                        }
                    ?>

                    <?php
                        if ($i - 1 != $count_pages) {
                            ?>
                            <!-- display occurs in blocks of 5 pages, "..." transition to the next or previous block -->
                            <li><a href="<?= $url_basic ?><?= $section_right ?><?= $url_get_without_page ?>">...</a></li>
                            <li><a href="<?= $url_basic ?><?= $count_pages?><?= $url_get_without_page ?>"><?=$count_pages?></a></li>
                            <?php        
                        }
                    ?>
                    
                    <?php
                        if ($current_page < $count_pages) {
                            ?>
                            <!-- transition to the next page -->
                            <li><a href="<?= $url_basic ?><?= $current_page + 1 ?><?= $url_get_without_page ?>">></a></li>
                            <?php    
                        }
                    ?>

                </ul>
            </nav>
        </div>
    </div>

    <script src="assets/js/jquery-3.4.1.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>
</html>
