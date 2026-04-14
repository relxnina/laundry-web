<?php
require_once __DIR__ . '/../config/database.php';

class User {

    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function findByEmail($email) {
        $email = mysqli_real_escape_string($this->conn, $email);
        $result = mysqli_query($this->conn, "SELECT * FROM users WHERE email='$email'");
        return mysqli_fetch_assoc($result);
    }

    public function create($data) {
        $name = $data['name'];
        $email = $data['email'];
        $phone = $data['phone'];
        $password = md5($data['password']);

        $query = "INSERT INTO users (name, email, phone, password) 
                  VALUES ('$name', '$email', '$phone', '$password')";

        return mysqli_query($this->conn, $query);
    }

    public function getAll() {
        return mysqli_query($this->conn, "SELECT * FROM users");
    }
}