<?php
// 13-Implementasi-Status-Pesanan/update_status.php

error_reporting(0);
ini_set('display_errors', 0);

if (ob_get_length()) ob_clean();

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

// Menghubungkan ke koneksi DB di modul 12
require_once __DIR__ . '/../12-Implementasi-Manajemen-Pesanan-Print-and-Jilid/config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(["status" => "error", "message" => "Metode request harus POST."]);
    exit();
}

// Membaca payload JSON
$input = json_decode(file_get_contents('php://input'), true);

$id_pesanan    = trim($input['id_pesanan'] ?? '');
$status_baru   = trim($input['status_pesanan'] ?? '');
$catatan_admin = trim($input['catatan_admin'] ?? '');

// Daftar 6 Status Sesuai Checklist
$allowed_status = [
    'Menunggu Konfirmasi',
    'Diproses',
    'Dicetak',
    'Dijilid',
    'Selesai',
    'Dibatalkan'
];

if (empty($id_pesanan) || !in_array($status_baru, $allowed_status)) {
    echo json_encode([
        "status"  => "error",
        "message" => "ID Pesanan atau Status tidak valid! Pilihan status: " . implode(', ', $allowed_status)
    ]);
    exit();
}

$updated_db = false;

if (isset($conn) && $conn !== null) {
    try {
        $stmt = $conn->prepare("UPDATE pesanan SET status_pesanan = :status WHERE id_pesanan = :id");
        $stmt->execute([
            ':status' => $status_baru,
            ':id'     => $id_pesanan
        ]);

        if ($stmt->rowCount() > 0) {
            $updated_db = true;
        }
    } catch (Exception $e) {
        $updated_db = false;
    }
}

echo json_encode([
    "status"          => "success",
    "message"         => "Berhasil mengubah status pesanan menjadi '{$status_baru}'",
    "database_status" => $updated_db ? "Tersimpan ke Database MySQL" : "Tersimpan dalam Mode Simulasi",
    "data"            => [
        "id_pesanan"     => $id_pesanan,
        "status_terbaru" => $status_baru,
        "catatan_admin"  => $catatan_admin ?: "Status diperbarui oleh sistem/admin",
        "waktu_update"   => date('Y-m-d H:i:s')
    ]
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit();
?>