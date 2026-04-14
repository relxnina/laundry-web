<?php
require_once '../../helpers/auth.php';
checkAdmin();
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

<!-- nacbar -->
<div class="bg-sky-500 text-white p-4 flex justify-between">
    <h1 class="font-bold">Admin Panel</h1>

    <div class="flex gap-4">
        <a href="dashboard.php"><i class="ri-home-line"></i></a>
        <a href="orders.php"><i class="ri-file-list-line"></i></a>
        <a href="services.php"><i class="ri-store-line"></i></a>
        <a href="users.php"><i class="ri-user-line"></i></a>
        <a href="reports.php"><i class="ri-bar-chart-line"></i></a>
    </div>
</div>

<div class="p-4">