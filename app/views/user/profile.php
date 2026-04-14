<?php
session_start();
require_once '../../helpers/auth.php';

checkLogin();

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="flex items-center justify-between p-4 bg-sky-400 text-white">
    
    <h1 class="text-sm font-semibold">
        <?= getGreeting(); ?> <?= $user['name']; ?> 👋
    </h1>

    <div class="flex gap-4 text-lg">
        <a href="/"><i class="ri-home-line"></i></a>
        <a href="/Laundry-Web/app/views/user/history.php"><i class="ri-history-line"></i></a>
        <a href="/Laundry-Web/app/views/user/profile.php"><i class="ri-user-line"></i></a>
    </div>
</div>

<div class="max-w-md mx-auto mt-10 px-4">

    <div class="bg-white rounded-2xl shadow p-6 text-center">

        <div class="w-20 h-20 mx-auto mb-3 rounded-full bg-blue-500 flex items-center justify-center text-white text-2xl font-bold">
            <?= strtoupper(substr($user['name'], 0, 1)); ?>
        </div>
        <h2 class="text-xl font-bold"><?= $user['name']; ?></h2>
        <p class="text-gray-500 text-sm"><?= $user['email']; ?></p>
        <div class="border-t my-4"></div>
        <div class="text-left text-sm space-y-2">
            <div class="flex justify-between">
                <span class="text-gray-500">Phone</span>
                <span><?= $user['phone'] ?? '-' ?></span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Address</span>
                <span class="text-right"><?= $user['address'] ?? '-' ?></span>
            </div>
        </div>

        <!-- tombol logout -->
        <a href="../logout.php" 
           class="block mt-6 bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg text-sm transition">
            Logout
        </a>

    </div>

</div>

</body>
</html>