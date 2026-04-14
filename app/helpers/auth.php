<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function checkLogin() {
    if (!isset($_SESSION['user'])) {
        header("Location: /Laundry-Web/app/views/auth/auth.php");
        exit;
    }
}

function checkAdmin() {
    if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
        header("Location: /Laundry-Web/app/views/auth/auth.php");
        exit;
    }
}