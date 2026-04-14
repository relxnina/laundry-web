<?php

function getGreeting() {
    date_default_timezone_set('Asia/Jakarta');
    $hour = date('H');

    if ($hour >= 5 && $hour < 12) return "Good Morning";
    if ($hour < 15) return "Good Afternoon";
    if ($hour < 18) return "Good Evening";
    return "Good Night";
}

function formatRupiah($angka) {
    return "Rp " . number_format($angka, 0, ',', '.');
}

function formatPhone($phone) {
    $phone = preg_replace('/[^0-9]/', '', $phone);

    if (substr($phone, 0, 1) == '0') {
        $phone = '62' . substr($phone, 1);
    }

    return $phone;
}