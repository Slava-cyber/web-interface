<?php
    session_start();

    if (!$_SESSION['user']) {
        header('Location: ../index.php');
        die();
    }

    unset($_SESSION['user']);
    header('Location: ../index.php');
?>
