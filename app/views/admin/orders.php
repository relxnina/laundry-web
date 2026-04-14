<?php
require_once 'layout.php';
require_once '../../models/Order.php';

$orderModel = new Order();
$orders = $orderModel->getAll();
?>

<h2 class="text-lg font-bold mb-4">Daftar Order</h2>

<?php while($row = mysqli_fetch_assoc($orders)): ?>

<?php
//  warna status
$statusColor = "bg-gray-200 text-gray-600";

if ($row['status'] == 'waiting') $statusColor = "bg-yellow-100 text-yellow-600";
if ($row['status'] == 'process') $statusColor = "bg-blue-100 text-blue-600";
if ($row['status'] == 'waiting_payment') $statusColor = "bg-orange-100 text-orange-600";
if ($row['status'] == 'checking_payment') $statusColor = "bg-purple-100 text-purple-600";
if ($row['status'] == 'done') $statusColor = "bg-green-100 text-green-600";

$phone = $row['phone'];
?>

<div class="bg-white p-4 mb-4 rounded-xl shadow text-sm">

    <div class="flex justify-between items-center mb-2">
        <p class="font-semibold"><?= $row['customer_name']; ?></p>
        <span class="px-2 py-1 rounded text-xs <?= $statusColor ?>">
            <?= ucfirst(str_replace('_', ' ', $row['status'])); ?>
        </span>
    </div>

    <p class="text-gray-500"><?= $row['phone']; ?></p>
    <p class="text-gray-500 mb-2"><?= $row['address']; ?></p>

    <p>
        <?= $row['weight'] 
            ? $row['weight'].' Kg' 
            : $row['quantity'].' Item'; ?>
    </p>

    <p class="font-semibold mb-3">
        Rp <?= number_format($row['total_price']); ?>
    </p>

    <!-- bukti bayar -->
    <?php if ($row['status'] == 'checking_payment' && !empty($row['payment_proof'])): ?>

        <div class="mb-3">
            <a href="../../../public/uploads/<?= $row['payment_proof']; ?>" 
               target="_blank"
               class="bg-purple-500 hover:bg-purple-600 text-white px-3 py-1 rounded text-xs">
                Lihat Bukti
            </a>
        </div>

        <!-- terima / tolak -->
        <div class="flex gap-2 mb-3">

            <!-- terima -->
            <form method="POST" action="update_status.php" 
                  onsubmit="return confirm('ACC pembayaran ini?')">
                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                <input type="hidden" name="status" value="done">

                <button class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs">
                    ACC
                </button>
            </form>

            <!-- tolak -->
            <form method="POST" action="update_status.php" 
                  onsubmit="return confirm('Tolak pembayaran ini?')">
                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                <input type="hidden" name="status" value="waiting_payment">

                <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-xs">
                    Tolak
                </button>
            </form>

        </div>

    <?php endif; ?>

    <div class="flex gap-2 mb-3">

        <!-- whatsapp -->
        <a 
            href="https://wa.me/<?= $phone ?>" 
            target="_blank"
            class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-xs">
            WA
        </a>

        <!-- map -->
        <a 
            href="https://www.google.com/maps?q=<?= $row['latitude'] ?>,<?= $row['longitude'] ?>" 
            target="_blank"
            class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-xs">
            Map
        </a>

    </div>

    <!-- update status -->
    <form method="POST" action="update_status.php" class="flex gap-2">

        <input type="hidden" name="id" value="<?= $row['id']; ?>">

        <select name="status" class="border p-1 rounded text-xs w-full">

            <option value="waiting" <?= $row['status']=='waiting'?'selected':'' ?>>Menunggu</option>
            <option value="process" <?= $row['status']=='process'?'selected':'' ?>>Dikerjakan</option>
            <option value="waiting_payment" <?= $row['status']=='waiting_payment'?'selected':'' ?>>Menunggu Pembayaran</option>
            <option value="checking_payment" <?= $row['status']=='checking_payment'?'selected':'' ?>>Cek Pembayaran</option>
            <option value="done" <?= $row['status']=='done'?'selected':'' ?>>Selesai</option>

        </select>

        <button class="bg-sky-500 hover:bg-sky-600 text-white px-3 rounded text-xs">
            Update
        </button>

    </form>

</div>

<?php endwhile; ?>

</div>
</body>
</html>