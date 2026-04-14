<?php
session_start();

require_once '../../helpers/auth.php';
require_once '../../controllers/ServiceController.php';
require_once '../../controllers/OrderController.php';

checkLogin();

$serviceController = new ServiceController();
$orderController = new OrderController();

$serviceId = $_GET['service'] ?? null;
$service = $serviceController->getServiceById($serviceId);

if (!$service) {
    die("Service tidak ditemukan");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $data = [
        'user_id' => $_SESSION['user']['id'],
        'service_id' => $serviceId,
        'customer_name' => $_POST['customer_name'],
        'phone' => $_POST['phone'],
        'address' => $_POST['address'],
        'latitude' => $_POST['latitude'],
        'longitude' => $_POST['longitude'],
        'weight' => $_POST['weight'] ?? null,
        'quantity' => $_POST['quantity'] ?? null
    ];

    $orderController->createOrder($data);

    header("Location: /Laundry-Web/app/views/user/dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
</head>

<body class="bg-gray-100">

<div class="max-w-2xl mx-auto p-6">

<div class="bg-white p-5 rounded-2xl shadow">

    <h1 class="text-xl font-bold mb-4">Buat Order</h1>

    <!-- card layanan -->
    <div class="bg-gray-50 p-3 rounded-xl mb-4 flex gap-3 items-center">

        <img 
            src="/Laundry-Web/public/uploads/<?= $service['image'] ?: 'default.png' ?>" 
            class="w-20 h-20 object-cover rounded-lg"
        >

        <div>
            <p class="font-semibold"><?= $service['name']; ?></p>
            <p class="text-sm text-gray-500">
                Rp <?= number_format($service['price_per_kg']) ?> /
                <?= $service['input_type']=='weight'?'Kg':'Item' ?>
            </p>
        </div>

    </div>

    <form method="POST">

        <!-- nama -->
        <input 
            name="customer_name"
            placeholder="Nama"
            class="w-full mb-3 p-2 border rounded"
            required
        >

        <!-- whatsapp -->
        <input 
            name="phone"
            placeholder="No WhatsApp"
            class="w-full mb-3 p-2 border rounded"
            required
        >

        <!-- alamat -->
        <textarea 
            name="address"
            placeholder="Alamat Lengkap"
            class="w-full mb-3 p-2 border rounded"
            required
        ></textarea>

        <!-- map -->
        <div id="map" class="w-full h-48 mb-3 rounded"></div>

        <input type="hidden" name="latitude" id="lat">
        <input type="hidden" name="longitude" id="lng">

        <?php if ($service['input_type'] == 'weight'): ?>

            <input 
                name="weight"
                type="number"
                step="0.1"
                placeholder="Berat (Kg)"
                class="w-full mb-3 p-2 border rounded"
                required
            >

        <?php else: ?>

            <input 
                name="quantity"
                type="number"
                placeholder="Jumlah Item"
                class="w-full mb-3 p-2 border rounded"
                required
            >

        <?php endif; ?>

        <button class="bg-blue-500 hover:bg-blue-600 text-white w-full p-2 rounded">
            Buat Order
        </button>

    </form>

</div>
</div>

</body>

<script>
var map = L.map('map').setView([-6.9667, 110.4167], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap'
}).addTo(map);

var marker;

map.on('click', function(e) {
    var lat = e.latlng.lat;
    var lng = e.latlng.lng;

    if (marker) {
        map.removeLayer(marker);
    }

    marker = L.marker([lat, lng]).addTo(map);

    document.getElementById('lat').value = lat;
    document.getElementById('lng').value = lng;

    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
        .then(res => res.json())
        .then(data => {
            if (data.display_name) {
                document.querySelector('[name="address"]').value = data.display_name;
            }
        });
});
</script>

</html>