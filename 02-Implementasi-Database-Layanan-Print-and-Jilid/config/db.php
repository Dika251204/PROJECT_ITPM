<?php
// 02-Implementasi-Database-Layanan-Print-and-Jilid/config/db.php

$host = '127.0.0.1';
$db   = 'uinma_merch_printhub';
$user = 'root';
$pass = '';

$conn = null;
$pdo  = null;

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    $pdo = $conn;
} catch (PDOException $e) {
    $conn = null;
    $pdo  = null;
}
?>