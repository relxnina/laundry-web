<?php
require_once 'layout.php';
require_once '../../helpers/auth.php';
require_once '../../models/Service.php';

checkAdmin();

$serviceModel = new Service();

/* hapus layanan */
if (isset($_GET['delete'])) {

    $id = $_GET['delete'];

    $service = $serviceModel->getById($id);

    // hapus file lama
    if ($service && !empty($service['image'])) {

        $path = __DIR__ . '/../../../public/uploads/' . $service['image'];

        if (file_exists($path)) {
            unlink($path);
        }
    }

    $serviceModel->delete($id);

    header("Location: services.php");
    exit;
}


/* update layanan */
if (isset($_POST['update'])) {

    $data = $_POST;

    $uploadDir = __DIR__ . '/../../../public/uploads/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // default image
    $data['image'] = null;

    // upload gambar baru kalau ada
    if (!empty($_FILES['image']['name'])) {

        $fileName = time() . '_' . preg_replace(
            '/\s+/',
            '_',
            basename($_FILES['image']['name'])
        );

        $tmp = $_FILES['image']['tmp_name'];

        move_uploaded_file($tmp, $uploadDir . $fileName);

        $data['image'] = $fileName;
    }

    $serviceModel->update($data);

    header("Location: services.php");
    exit;
}


/* ambil data */
$services = $serviceModel->getAll();
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">

<div class="max-w-3xl mx-auto">

    <h2 class="text-2xl font-bold mb-6">Manajemen Layanan</h2>

    <!-- CREATE -->
    <div class="bg-white p-5 rounded-xl shadow mb-6">

        <form method="POST" action="create_service.php" enctype="multipart/form-data" class="space-y-3">

            <input name="name" placeholder="Nama Layanan" required class="w-full border p-2 rounded">

            <input name="price" placeholder="Harga" required class="w-full border p-2 rounded">

            <select name="input_type" class="w-full border p-2 rounded">
                <option value="weight">Per Kg</option>
                <option value="item">Per Item</option>
            </select>

            <input type="file" name="image" class="w-full border p-2 rounded">

            <button class="w-full bg-blue-500 text-white py-2 rounded">
                Tambah
            </button>

        </form>
    </div>

    <!-- list -->
    <div class="bg-white p-5 rounded-xl shadow">

        <div class="space-y-3">

        <?php while ($s = mysqli_fetch_assoc($services)): ?>

            <div class="border p-3 rounded flex justify-between items-center">

                <div class="flex items-center gap-3">

                    <?php if (!empty($s['image'])): ?>
                        <img src="/uploads/<?= $s['image'] ?>"
                             class="w-12 h-12 object-cover rounded">
                    <?php endif; ?>

                    <div>
                        <p class="font-semibold"><?= $s['name']; ?></p>
                        <p class="text-gray-500 text-sm">
                            Rp <?= number_format($s['price_per_kg']); ?> /
                            <?= $s['input_type'] == 'weight' ? 'Kg' : 'Item'; ?>
                        </p>
                    </div>

                </div>

                <div class="flex gap-2">

                    <button
                        onclick="openModal(
                            <?= $s['id'] ?>,
                            '<?= $s['name'] ?>',
                            <?= $s['price_per_kg'] ?>,
                            '<?= $s['input_type'] ?>'
                        )"
                        class="bg-yellow-400 text-white px-3 py-1 rounded text-xs">
                        Edit
                    </button>

                    <a href="?delete=<?= $s['id'] ?>"
                       onclick="return confirm('Yakin hapus?')"
                       class="bg-red-500 text-white px-3 py-1 rounded text-xs">
                        Hapus
                    </a>

                </div>
            </div>

        <?php endwhile; ?>

        </div>
    </div>

</div>

<!-- MODAL -->
<div id="modal" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center">

    <div class="bg-white p-5 rounded-lg w-80">

        <h3 class="font-bold mb-3">Edit Layanan</h3>

        <form method="POST" enctype="multipart/form-data">

            <input type="hidden" name="id" id="edit_id">

            <input name="name" id="edit_name" class="w-full border p-2 mb-2 rounded">

            <input name="price" id="edit_price" class="w-full border p-2 mb-2 rounded">

            <select name="input_type" id="edit_type" class="w-full border p-2 mb-3 rounded">
                <option value="weight">Kg</option>
                <option value="item">Item</option>
            </select>

            <input type="file" name="image" class="w-full border p-2 mb-3 rounded">

            <button name="update" class="w-full bg-blue-500 text-white py-2 rounded">
                Update
            </button>

        </form>

        <button onclick="closeModal()" class="mt-2 text-sm text-gray-500 w-full">
            Batal
        </button>

    </div>
</div>

<script>
function openModal(id, name, price, type) {
    document.getElementById('modal').classList.remove('hidden');

    document.getElementById('edit_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_price').value = price;
    document.getElementById('edit_type').value = type;
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
}
</script>

</body>
</html>