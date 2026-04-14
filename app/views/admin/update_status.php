<?php
require_once '../../controllers/OrderController.php';

if (!isset($_POST['id']) || !isset($_POST['status'])) {
    die("Data tidak lengkap");
}

$orderController = new OrderController();

$id = $_POST['id'];
$status = $_POST['status'];

// var_dump($id, $status); die;

$orderController->updateStatus($id, $status);

// direct ke admin
header("Location: orders.php");
exit;