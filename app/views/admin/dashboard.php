<?php
require_once 'layout.php';
require_once '../../models/Order.php';
require_once '../../models/User.php';
require_once '../../models/Service.php';

$orderModel = new Order();
$userModel = new User();
$serviceModel = new Service();

$totalOrders = mysqli_num_rows($orderModel->getAll());
$totalUsers = mysqli_num_rows($userModel->getAll());
$totalServices = mysqli_num_rows($serviceModel->getAll());
?>

<div class="max-w-6xl mx-auto p-6">

<h2 class="text-2xl font-bold mb-6">Dashboard Admin</h2>

<!-- stat -->
<div class="grid grid-cols-3 gap-6 mb-8">

    <div class="bg-white p-5 rounded-2xl shadow hover:shadow-lg transition">
        <p class="text-gray-500 text-sm">Total Orders</p>
        <p class="text-3xl font-bold mt-1"><?= $totalOrders; ?></p>
    </div>

    <div class="bg-white p-5 rounded-2xl shadow hover:shadow-lg transition">
        <p class="text-gray-500 text-sm">Total Users</p>
        <p class="text-3xl font-bold mt-1"><?= $totalUsers; ?></p>
    </div>

    <div class="bg-white p-5 rounded-2xl shadow hover:shadow-lg transition">
        <p class="text-gray-500 text-sm">Total Services</p>
        <p class="text-3xl font-bold mt-1"><?= $totalServices; ?></p>
    </div>

</div>

<!-- menu -->
<div class="grid grid-cols-2 gap-6">

    <a href="orders.php" 
       class="bg-sky-500 hover:bg-sky-600 text-white p-6 rounded-2xl flex justify-between items-center transition">
        <span class="text-lg font-semibold">Kelola Order</span>
        <span class="text-xl">→</span>
    </a>

    <a href="services.php" 
       class="bg-purple-500 hover:bg-purple-600 text-white p-6 rounded-2xl flex justify-between items-center transition">
        <span class="text-lg font-semibold">Kelola Layanan</span>
        <span class="text-xl">→</span>
    </a>

    <a href="users.php" 
       class="bg-green-500 hover:bg-green-600 text-white p-6 rounded-2xl flex justify-between items-center transition">
        <span class="text-lg font-semibold">Manage User</span>
        <span class="text-xl">→</span>
    </a>

    <a href="reports.php" 
       class="bg-orange-500 hover:bg-orange-600 text-white p-6 rounded-2xl flex justify-between items-center transition">
        <span class="text-lg font-semibold">Reports</span>
        <span class="text-xl">→</span>
    </a>

</div>

</div>
</body>
</html>