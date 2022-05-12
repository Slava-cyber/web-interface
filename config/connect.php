<?php
    // Database config
    $connect = mysqli_connect(
        'localhost', // host
        'root', // username
        'root', // password
        'users' // database name
    );
    
    mysqli_query($connect, 'SET NAMES "utf8');
    if (!$connect) {
        die('Error coonect to Database');
    }
?>
