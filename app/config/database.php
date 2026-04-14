<?php

function connectDB() {
    $conn = mysqli_connect("localhost", "root", "", "laundry_app");

    if (!$conn) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }

    mysqli_set_charset($conn, "utf8mb4");

    return $conn;
}