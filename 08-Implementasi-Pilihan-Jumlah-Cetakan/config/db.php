<?php
// 08-Implementasi-Pilihan-Jumlah-Cetakan/config/db.php

$host = 'localhost';
$dbname = 'pusat_mercis';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Jika koneksi DB gagal, variabel $conn bernilai null
    $conn = null;
}
?>