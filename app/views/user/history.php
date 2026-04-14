<?php
session_start();

require_once '../../helpers/auth.php';
require_once '../../models/Order.php';
require_once '../../config/database.php';

checkLogin();

/* ================= HANDLE UPLOAD BUKTI ================= */
if (isset($_FILES['payment_proof'])) {

    $conn = connectDB();

    $file = $_FILES['payment_proof'];

    $filename = time() . '_' . preg_replace('/\s+/', '_', $file['name']);
    $target = '../../../public/uploads/' . $filename;

    // upload file baru
    move_uploaded_file($file['tmp_name'], $target);

    if (!isset($_POST['order_id'])) {
        die("Order ID tidak ditemukan");
    }

    $id = $_POST['order_id'];

    // update DB
    mysqli_query($conn, "
        UPDATE orders 
        SET payment_proof='$filename', status='checking_payment'
        WHERE id='$id'
    ");

    header("Location: history.php");
    exit;
}

$user = $_SESSION['user'];

$orderModel = new Order();
$orders = $orderModel->getByUser($user['id']);
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="p-4">

    <h2 class="text-lg font-bold mb-4">History Order</h2>

    <?php while($row = mysqli_fetch_assoc($orders)): ?>

    <?php
        $statusColor = "bg-gray-200 text-gray-600";

        if ($row['status'] == 'waiting') $statusColor = "bg-yellow-100 text-yellow-600";
        if ($row['status'] == 'process') $statusColor = "bg-blue-100 text-blue-600";
        if ($row['status'] == 'waiting_payment') $statusColor = "bg-orange-100 text-orange-600";
        if ($row['status'] == 'checking_payment') $statusColor = "bg-purple-100 text-purple-600";
        if ($row['status'] == 'done') $statusColor = "bg-green-100 text-green-600";
    ?>

    <div class="bg-white p-4 mb-3 rounded-xl shadow text-sm">

        <!-- HEADER -->
        <div class="flex justify-between mb-2">
            <p class="font-semibold"><?= $row['customer_name']; ?></p>

            <span class="px-2 py-1 rounded text-xs <?= $statusColor ?>">
                <?= ucfirst(str_replace('_', ' ', $row['status'])); ?>
            </span>
        </div>

        <!-- ADDRESS -->
        <p><?= $row['address']; ?></p>

        <!-- WEIGHT / ITEM -->
        <p class="mt-1">
            <?php if (!empty($row['weight'])): ?>
                <?= $row['weight']; ?> Kg
            <?php elseif (!empty($row['quantity'])): ?>
                <?= $row['quantity']; ?> Item
            <?php else: ?>
                <span class="text-red-500">Data kosong</span>
            <?php endif; ?>
        </p>

        <!-- TOTAL -->
        <p class="font-semibold mb-2">
            Rp <?= number_format($row['total_price']); ?>
        </p>

        <!-- ALERT REJECT -->
        <?php if ($row['status'] == 'waiting_payment' && !empty($row['payment_proof'])): ?>
            <p class="text-red-500 text-xs mb-2">
                Pembayaran ditolak, silakan upload ulang.
            </p>
        <?php endif; ?>

        <!-- PAYMENT SECTION -->
        <?php if ($row['status'] == 'waiting_payment'): ?>

        <div class="flex gap-2 items-center">

            <!-- QRIS BUTTON -->
            <button
                onclick="openQRIS(<?= $row['total_price']; ?>)"
                class="bg-green-500 text-white px-3 py-1 rounded text-xs">
                Bayar QRIS
            </button>

            <!-- UPLOAD FORM -->
            <form method="POST" enctype="multipart/form-data">

                <input type="hidden" name="order_id" value="<?= $row['id']; ?>">

                <input type="file"
                       name="payment_proof"
                       accept="image/*"
                       required
                       class="text-xs mb-2">

                <button class="bg-blue-500 text-white px-3 py-1 rounded text-xs">
                    Upload Bukti
                </button>

            </form>

        </div>

        <?php endif; ?>

    </div>

    <?php endwhile; ?>

</div>

<!-- ================= QRIS MODAL ================= -->
<div id="qrisModal"
     class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">

    <div class="bg-white p-5 rounded-xl w-72 text-center">

        <h3 class="font-bold mb-2">Scan QRIS</h3>

        <img src="/uploads/qris.png" class="w-48 mx-auto mb-3">

        <p class="text-sm text-gray-600 mb-2">Total pembayaran:</p>

        <p id="qrisAmount" class="font-bold text-lg mb-4"></p>

        <button onclick="closeQRIS()" class="text-sm text-gray-500">
            Tutup
        </button>

    </div>
</div>

<script>
function openQRIS(amount) {
    document.getElementById('qrisModal').classList.remove('hidden');
    document.getElementById('qrisAmount').innerText =
        'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
}

function closeQRIS() {
    document.getElementById('qrisModal').classList.add('hidden');
}
</script>

</body>
</html>