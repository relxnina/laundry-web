<?php
require_once 'layout.php';
require_once '../../models/Order.php';

$orderModel = new Order();

$daily = mysqli_fetch_assoc($orderModel->getReport('daily'));
$weekly = mysqli_fetch_assoc($orderModel->getReport('weekly'));
$monthly = mysqli_fetch_assoc($orderModel->getReport('monthly'));
?>

<h2 class="font-bold mb-4">Reports</h2>

<div class="grid grid-cols-1 gap-4">

    <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">Harian</p>
        <p class="text-xl font-bold">Rp <?= number_format($daily['total'] ?? 0); ?></p>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">Mingguan</p>
        <p class="text-xl font-bold">Rp <?= number_format($weekly['total'] ?? 0); ?></p>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <p class="text-sm text-gray-500">Bulanan</p>
        <p class="text-xl font-bold">Rp <?= number_format($monthly['total'] ?? 0); ?></p>
    </div>

</div>