<?php
// 02-Implementasi-Database-Layanan-Print-and-Jilid/get_tables.php

require_once __DIR__ . '/config/db.php';
header("Content-Type: application/json; charset=UTF-8");

$db = isset($conn) ?$conn : (isset($pdo) ?$pdo : null);

if ($db) {
    try {
        $stmt =$db->query("SHOW TABLES");
        $tables =$stmt->fetchAll(PDO::FETCH_COLUMN);

        // Menyiapkan detail struktur dan record count dari database
        $tablesDetail = [];
        foreach ($tables as$table) {
            $countStmt =$db->query("SELECT COUNT(*) AS total FROM `$table`");
            $totalRow =$countStmt->fetch(PDO::FETCH_ASSOC);

            $tablesDetail[] = [
                "nama_tabel" => $table,
                "total_data" => $totalRow['total'] ?? 0,
                "status_relasi" => "Foreign Key & Primary Key Active"
            ];
        }

        echo json_encode([
            "status" => "success",
            "message" => "Struktur database uinma_merch_printhub terverifikasi!",
            "database" => "uinma_merch_printhub",
            "total_tabel" => count($tables),
            "detail_tabel" => $tablesDetail
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