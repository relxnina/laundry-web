<?php
session_start();
require_once '../../controllers/AuthController.php';

$auth = new AuthController();
$error = "";

// handle submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($_POST['type'] == 'login') {
        $error = $auth->login($_POST['email'], $_POST['password']);
    }

    if ($_POST['type'] == 'register') {
        $error = $auth->register($_POST);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">

<div class="bg-white p-6 rounded-xl shadow w-80">

    <!-- login/register -->
    <div class="flex mb-4">
        <button onclick="showLogin()" class="w-1/2">Login</button>
        <button onclick="showRegister()" class="w-1/2">Register</button>
    </div>

    <!-- login -->
    <form method="POST" id="loginForm">
        <input type="hidden" name="type" value="login">

        <input name="email" placeholder="Email" class="w-full mb-2 p-2 border">
        <input name="password" type="password" placeholder="Password" class="w-full mb-2 p-2 border">

        <button class="bg-blue-500 text-white w-full p-2 rounded">Login</button>
    </form>

    <!-- register -->
    <form method="POST" id="registerForm" class="hidden">
        <input type="hidden" name="type" value="register">

        <input name="name" placeholder="Nama" class="w-full mb-2 p-2 border">
        <input name="email" placeholder="Email" class="w-full mb-2 p-2 border">
        <input name="phone" placeholder="No WhatsApp" class="w-full mb-2 p-2 border">
        <input name="password" type="password" placeholder="Password" class="w-full mb-2 p-2 border">

        <button class="bg-green-500 text-white w-full p-2 rounded">Register</button>
    </form>

    <p class="text-red-500 text-sm mt-2"><?= $error ?></p>
</div>

<script>
function showLogin() {
    document.getElementById('loginForm').classList.remove('hidden');
    document.getElementById('registerForm').classList.add('hidden');
}

function showRegister() {
    document.getElementById('registerForm').classList.remove('hidden');
    document.getElementById('loginForm').classList.add('hidden');
}
</script>

</body>
</html>