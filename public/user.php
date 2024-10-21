<?php
session_start(); 

if (!isset($_SESSION['user_name'])) {
    header('Location: login.php'); 
    exit;
}

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit;
}

include '../src/views/user.php';
?>
