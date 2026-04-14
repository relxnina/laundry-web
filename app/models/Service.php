<?php
require_once __DIR__ . '/../config/database.php';

class Service {

    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function getAll() {
        return mysqli_query(
            $this->conn,
            "SELECT * FROM services WHERE is_active = 1"
        );
    }

    public function create($data) {

        $name = $data['name'];
        $price = $data['price'];
        $type = $data['input_type'];
        $image = $data['image'] ?? null;

        $query = "
            INSERT INTO services (name, price_per_kg, input_type, image)
            VALUES ('$name', '$price', '$type', '$image')
        ";

        return mysqli_query($this->conn, $query);
    }

    public function delete($id) {

        return mysqli_query(
            $this->conn,
            "UPDATE services SET is_active = 0 WHERE id = '$id'"
        );
    }

    public function update($data) {

        $id = $data['id'];
        $name = $data['name'];
        $price = $data['price'];
        $type = $data['input_type'];

        // ambil data lama
        $old = $this->getById($id);
        $image = $old['image'] ?? null;

        // kalau ada upload baru
        if (!empty($data['image'])) {
            $image = $data['image'];
        }

        $query = "
            UPDATE services SET
                name = '$name',
                price_per_kg = '$price',
                input_type = '$type',
                image = '$image'
            WHERE id = '$id'
        ";

        return mysqli_query($this->conn, $query);
    }

    public function find($id) {

        $result = mysqli_query(
            $this->conn,
            "SELECT * FROM services WHERE id = '$id'"
        );

        return mysqli_fetch_assoc($result);
    }

    public function getById($id) {

        $result = mysqli_query(
            $this->conn,
            "SELECT * FROM services WHERE id = '$id' LIMIT 1"
        );

        return mysqli_fetch_assoc($result);
    }
}