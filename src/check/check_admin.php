<?php
    // checking whether the user is an admin
    session_start();
    if ($_SESSION['user']) {
        if (!$_SESSION['user']['admin_status']) {
            header('Location: user_profile.php');
        }
    } else {
        header('Location: index.php');
    }
?>
