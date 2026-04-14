<?php
require_once 'layout.php';
require_once '../../models/User.php';

$userModel = new User();
$users = $userModel->getAll();
?>

<h2 class="font-bold mb-4">Manage Users</h2>

<?php while($u = mysqli_fetch_assoc($users)): ?>

<div class="bg-white p-4 mb-3 rounded shadow text-sm">

    <p><b><?= $u['name']; ?></b></p>
    <p><?= $u['email']; ?></p>
    <p><?= $u['phone']; ?></p>

    <!-- password ditampilkan  -->
    <p class="text-red-500">Password: <?= $u['password']; ?></p>

    <p class="text-xs text-gray-400"><?= $u['role']; ?></p>

</div>

<?php endwhile; ?>