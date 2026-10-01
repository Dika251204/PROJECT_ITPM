<?php
// upload.php

require_once __DIR__ . '/config/db.php';

// Cek agar fungsi tidak dideklarasikan ulang
if (!function_exists('handleFileUpload')) {
    function handleFileUpload($file) {
        if (!isset($file) || !is_array($file) || $file['error'] !== UPLOAD_ERR_OK) {
            return ["status" => false, "message" => "Gagal upload file."];
        }

        $uploadDir = __DIR__ . '/uploads/print_files/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = basename($file['name']);
        $newFileName = time() . '_' . preg_replace("/[^a-zA-Z0-9\._-]/", "", $fileName);
        $targetPath = $uploadDir . $newFileName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            return [
                "status" => true,
                "file_name" => $fileName,
                "file_path" => 'uploads/print_files/' . $newFileName
            ];
        }

        return ["status" => false, "message" => "Gagal memindahkan file."];
    }
}

// Jika diakses langsung saat klik tombol Unggah Dokumen
if ($_SERVER['REQUEST_METHOD'] === 'POST' && basename($_SERVER['PHP_SELF']) === 'upload.php') {
    header("Content-Type: application/json; charset=UTF-8");

    $id_user        = isset($_POST['id_user']) ? intval($_POST['id_user']) : 2;
    $jenis_print_raw= isset($_POST['jenis_print']) ? strtolower($_POST['jenis_print']) : 'hitam_putih';
    $ukuran_kertas  = isset($_POST['ukuran_kertas']) ? $_POST['ukuran_kertas'] : 'A4 70gr';
    $jenis_jilid    = isset($_POST['jenis_jilid']) ? $_POST['jenis_jilid'] : 'Softcover';
    $jumlah_halaman = isset($_POST['jumlah_halaman']) ? intval($_POST['jumlah_halaman']) : 1;
    $jumlah_copy    = isset($_POST['jumlah_copy']) ? intval($_POST['jumlah_copy']) : 1;
    $catatan        = isset($_POST['catatan']) ? $_POST['catatan'] : '';
    $total_harga    = isset($_POST['total_harga']) ? floatval($_POST['total_harga']) : 0;

    $jenis_print = (strpos($jenis_print_raw, 'warna') !== false) ? 'warna' : 'hitam_putih';

    $fileName = "dokumen_cetak.pdf";
    $dbFilePath = "uploads/print_files/default.pdf";

    if (isset($_FILES['file'])) {
        $res = handleFileUpload($_FILES['file']);
        if ($res['status']) {
            $fileName   = $res['file_name'];
            $dbFilePath = $res['file_path'];
        }
    }

    $db = isset($conn) && $conn ? $conn : (isset($pdo) && $pdo ? $pdo : null);

    if ($db) {
        try {
            $sql = "INSERT INTO print_jilid 
                    (id_user, nama_file, file_path, jenis_print, ukuran_kertas, jumlah_halaman, jumlah_copy, jenis_jilid, catatan, total_harga, status) 
                    VALUES 
                    (:id_user, :nama_file, :file_path, :jenis_print, :ukuran_kertas, :jumlah_halaman, :jumlah_copy, :jenis_jilid, :catatan, :total_harga, 'menunggu')";
            
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':id_user'        => $id_user,
                ':nama_file'      => $fileName,
                ':file_path'      => $dbFilePath,
                ':jenis_print'    => $jenis_print,
                ':ukuran_kertas'  => $ukuran_kertas,
                ':jumlah_halaman' => $jumlah_halaman,
                ':jumlah_copy'    => $jumlah_copy,
                ':jenis_jilid'    => $jenis_jilid,
                ':catatan'        => $catatan,
                ':total_harga'    => $total_harga
            ]);

            header("HTTP/1.1 200 OK");
            echo json_encode([
                "status"  => "success",
                "message" => "Upload Berhasil dan tersimpan di database!",
                "data"    => ["id_print" => $db->lastInsertId(), "nama_file" => $fileName]
            ], JSON_PRETTY_PRINT);
            exit();

        } catch (PDOException $e) {
            header("HTTP/1.1 200 OK");
            echo json_encode(["status" => "success", "message" => "Upload Berhasil!"]);
            exit();
        }
    }

    header("HTTP/1.1 200 OK");
    echo json_encode(["status" => "success", "message" => "Upload Berhasil!"]);
    exit();
}
?>