<?php
require_once '../../config/database.php';

$conn = connectDB();

$name = $_POST['name'];
$price = $_POST['price'];
$type = $_POST['input_type'];

$filename = null;

// handle upload gambar
if (!empty($_FILES['image']['name'])) {
    $file = $_FILES['image'];
    $filename = time() . '_' . $file['name'];

    $target = '../../../public/uploads/' . $filename;

    move_uploaded_file($file['tmp_name'], $target);
}

// insert data dan gambar
mysqli_query($conn, "
    INSERT INTO services (name, price_per_kg, input_type, image) 
    VALUES ('$name', '$price', '$type', '$filename')
");

header("Location: services.php");