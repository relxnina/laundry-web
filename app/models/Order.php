<?php
require_once __DIR__ . '/../config/database.php';

class Order {

    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function create($data) {

        $weight = isset($data['weight']) ? $data['weight'] : "NULL";
        $quantity = isset($data['quantity']) ? $data['quantity'] : "NULL";

        $query = "INSERT INTO orders 
            (user_id, service_id, customer_name, phone, address, latitude, longitude, weight, quantity, total_price, status) 
            VALUES (
                '{$data['user_id']}',
                '{$data['service_id']}',
                '{$data['customer_name']}',
                '{$data['phone']}',
                '{$data['address']}',
                '{$data['latitude']}',
                '{$data['longitude']}',
                " . ($weight !== null ? $weight : "NULL") . ",
                " . ($quantity !== null ? $quantity : "NULL") . ",
                '{$data['total_price']}',
                'waiting'
            )";

        return mysqli_query($this->conn, $query);
    }

    public function getLatestByUser($userId) {
        return mysqli_query($this->conn,
            "SELECT * FROM orders 
             WHERE user_id='$userId'
             ORDER BY created_at DESC LIMIT 3"
        );
    }

    public function updateStatus($id, $status) {

        $id = mysqli_real_escape_string($this->conn, $id);
        $status = mysqli_real_escape_string($this->conn, $status);

        $query = "UPDATE orders SET status='$status' WHERE id='$id'";
        $result = mysqli_query($this->conn, $query);

        if (!$result) {
            die("ERROR UPDATE: " . mysqli_error($this->conn));
        }

        if (mysqli_affected_rows($this->conn) == 0) {
            // debug opsional
            // echo "tidak ada perubahan (status mungkin sama)";
        }

        return $result;
    }

    public function getAll() {
        return mysqli_query($this->conn, "SELECT * FROM orders ORDER BY created_at DESC");
    }

    public function getReport($type) {

    if ($type == 'daily') {
        $filter = "DATE(created_at) = CURDATE()";
    } elseif ($type == 'weekly') {
        $filter = "YEARWEEK(created_at, 1) = YEARWEEK(CURDATE(), 1)";
    } else {
        $filter = "MONTH(created_at) = MONTH(CURDATE())";
    }

        return mysqli_query($this->conn,
            "SELECT SUM(total_price) as total FROM orders WHERE $filter AND status='done'"
        );
    }

    public function getByUser($userId) {
        return mysqli_query($this->conn, 
            "SELECT * FROM orders WHERE user_id='$userId' ORDER BY created_at DESC"
        );
    }
}