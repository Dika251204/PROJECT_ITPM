<?php
// 12-Implementasi-Manajemen-Pesanan-Print-and-Jilid/config/db.php

$host     = 'localhost';
$dbname   = 'pusat_mercis';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $conn = null;
}
?>