<?php
    $connect = mysqli_connect('localhost', 'root', 'root', 'users');
    mysqli_query($connect, 'SET NAMES "utf8');
    if (!$connect) {
        die('Error coonect to Database');
    }
?>
