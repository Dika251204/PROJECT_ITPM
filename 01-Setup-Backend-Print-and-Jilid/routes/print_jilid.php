<?php
// routes/print_jilid.php

require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../upload.php';

if (!function_exists('handlePrintJilidRoutes')) {
    function handlePrintJilidRoutes($method) {
        global $conn, $pdo;
        $db = $conn ?? $pdo;

        switch (strtoupper($method)) {
            case 'GET':
                try {
                    $data = [];
                    if ($db) {
                        $stmt = $db->query("SELECT pj.*, u.nama FROM print_jilid pj JOIN users u ON pj.id_user = u.id_user ORDER BY pj.id_print DESC");
                        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    }

                    echo json_encode([
                        "status" => "success",
                        "message" => "Data layanan print & jilid berhasil diambil",
                        "data" => $data
                    ], JSON_PRETTY_PRINT);
                } catch (PDOException $e) {
                    echo json_encode([
                        "status" => "error",
                        "message" => $e->getMessage()
                    ], JSON_PRETTY_PRINT);
                }
                break;

            case 'POST':
                if (empty($_POST['id_user'])) {
                    echo json_encode([
                        "status" => "error",
                        "message" => "Field id_user wajib diisi."
                    ], JSON_PRETTY_PRINT);
                    exit();
                }

                $uploadResult = null;
                if (isset($_FILES['file_cetak'])) {
                    $uploadResult = handleFileUpload($_FILES['file_cetak']);
                    if (!$uploadResult['status']) {
                        echo json_encode([
                            "status" => "error",
                            "message" => $uploadResult['message'] ?? 'Gagal upload'
                        ], JSON_PRETTY_PRINT);
                        exit();
                    }
                }

                echo json_encode([
                    "status" => "success",
                    "message" => "Validasi request dan upload awal berhasil",
                    "data" => [
                        "id_user" => $_POST['id_user'],
                        "file_info" => $uploadResult
                    ]
                ], JSON_PRETTY_PRINT);
                break;

            default:
                echo json_encode([
                    "status" => "error",
                    "message" => "Metode HTTP tidak diizinkan"
                ], JSON_PRETTY_PRINT);
                break;
        }
    }
}
?>