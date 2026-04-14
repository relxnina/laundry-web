<?php
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Service.php';
require_once __DIR__ . '/../helpers/function.php';

class OrderController {

    public function createOrder($data) {

        $serviceModel = new Service();
        $service = $serviceModel->find($data['service_id']);

        if (!$service) {
            return false;
        }

        //  hitung tital
        if ($service['input_type'] == 'weight') {
            $weight = $data['weight'] ?? 0;
            $total = $weight * $service['price_per_kg'];
            $data['quantity'] = null;
        } else {
            $qty = $data['quantity'] ?? 0;
            $total = $qty * $service['price_per_kg'];
            $data['weight'] = null;
        }

        //  nomor wangsaf
        $data['phone'] = formatPhone($data['phone']);

        $data['total_price'] = $total;

        //  valid-in minimal
        if ($total <= 0) {
            return false;
        }

        $order = new Order();
        return $order->create($data);
    }

    public function getLatestOrders($userId) {
        $order = new Order();
        return $order->getLatestByUser($userId);
    }

    public function updateStatus($id, $status) {
        $order = new Order();
        return $order->updateStatus($id, $status);
    }

    public function getOrderById($id) {
        $order = new Order();
        return $order->find($id);
    }
}