<?php
session_start();
require_once '../../helpers/function.php';
require_once '../../controllers/OrderController.php';
require_once '../../controllers/ServiceController.php';

// proteksi login nanti di ubah lagi
if (!isset($_SESSION['user'])) {
    header("Location: /Laundry-Web/app/views/auth/auth.php");
    exit;
}

$user = $_SESSION['user'];

$orderController = new OrderController();
$serviceController = new ServiceController();

// ambil data
$orders = $orderController->getLatestOrders($user['id']);
$services = $serviceController->getServices();

// ubah services ke array
$serviceData = [];
while ($row = mysqli_fetch_assoc($services)) {
    $serviceData[] = $row;
}
$totalService = count($serviceData);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Dashboard</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
</head>

<body class="bg-gray-100">

<!--  navbar -->
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

<!--  baner -->
<div class="p-4">
    <div class="bg-gray-300 h-32 rounded-xl"></div>
</div>

<!--  history -->
<div class="px-4">
    <div class="bg-white p-4 rounded-xl shadow">
        
        <div class="flex justify-between mb-3">
            <h2 class="font-semibold">History</h2>
            <a href="/Laundry-Web/app/views/user/history.php" class="text-xs text-blue-500">
                See All
            </a>
        </div>

        <?php if (mysqli_num_rows($orders) > 0): ?>
            
            <?php while($row = mysqli_fetch_assoc($orders)): ?>

            <div class="flex items-center gap-3 border p-2 rounded-lg mb-2">

                <img src="/Laundry-Web/assets/images/shirt.png" class="w-12 h-12 object-cover">

                <div class="text-xs">
                    <p class="font-semibold"><?= $row['customer_name']; ?></p>
                    <?php if ($row['weight']): ?>
                        <p><?= $row['weight']; ?> Kg</p>
                    <?php else: ?>
                        <p><?= $row['quantity']; ?> Item</p>
                    <?php endif; ?>
                    <p>Rp <?= number_format($row['total_price']); ?></p>

                    <!-- status -->
                    <?php
                    $statusColor = "text-yellow-500";
                    if ($row['status'] == 'done') $statusColor = "text-green-500";
                    if ($row['status'] == 'cancel') $statusColor = "text-red-500";
                    ?>

                    <p class="<?= $statusColor ?>">
                        <?= ucfirst($row['status']); ?>
                    </p>
                </div>

            </div>

            <?php endwhile; ?>

        <?php else: ?>
            <p class="text-xs text-gray-400">Belum ada history</p>
        <?php endif; ?>

    </div>
</div>


<!--  layanan -->
<div class="p-4 grid grid-cols-2 gap-3">

<?php foreach($serviceData as $index => $service): ?>

    <?php if($totalService % 2 != 0 && $index == $totalService - 1): ?>
        
        <!-- jumlah layanan ganjil -->
        <a href="/Laundry-Web/app/views/user/order.php?service=<?= $service['id']; ?>"
           class="col-span-2 bg-purple-400 rounded-xl p-4 flex justify-between items-center">

            <span class="font-semibold text-white">
                <?= $service['name']; ?>
            </span>

            <i class="ri-arrow-right-line text-white"></i>

        </a>

    <?php else: ?>

        <!-- jumlah layanan genap -->
        <a href="/Laundry-Web/app/views/user/order.php?service=<?= $service['id']; ?>"
           class="bg-blue-300 rounded-xl p-4 flex justify-between items-center">

            <span class="font-semibold">
                <?= $service['name']; ?>
            </span>

            <i class="ri-arrow-right-line"></i>

        </a>

    <?php endif; ?>

<?php endforeach; ?>

</div>


</body>
</html>