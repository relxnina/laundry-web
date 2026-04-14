<?php

$uri = $_SERVER['REQUEST_URI'];

if ($uri == '/') {
    require_once '../views/user/dashboard.php';
}