<?php
// 01-Setup-Backend-Print-and-Jilid/test_db.php

require_once __DIR__ . '/config/db.php';
header("Content-Type: application/json; charset=UTF-8");

$db = isset($conn) ? $conn : (isset($pdo) ? $pdo : null);

if ($db) {
    try {
        $stmt = $db->query("SELECT COUNT(*) AS total_users FROM users");
        $res = $stmt->fetch();
        echo json_encode([
            "status" => "success",
            "message" => "Koneksi Database Berhasil!",
            "database" => "uinma_merch_printhub",
            "total_users" => $res['total_users']
        ], JSON_PRETTY_PRINT);
        exit();
    } catch (PDOException $e) {
        echo json_encode(["status" => "error", "message" => $e->getMessage()], JSON_PRETTY_PRINT);
        exit();
    }
}

echo json_encode(["status" => "error", "message" => "Gagal terhubung ke database."], JSON_PRETTY_PRINT);
exit();
?>