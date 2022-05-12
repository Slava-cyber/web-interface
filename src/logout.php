<?php
    session_start();

    if (!$_SESSION['user']) {
        header('Location: /index.php');
        die();
    }

    // end of session
    unset($_SESSION['user']);
    header('Location: /index.php');

