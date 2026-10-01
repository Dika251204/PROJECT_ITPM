<?php
// 03-Implementasi-Upload-File/upload.php

require_once __DIR__ . '/config/db.php';

header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(["status" => "error", "message" => "Metode request harus POST."]);
    exit();
}

// 1. Memastikan Folder Penyimpanan Terbuat
$targetDir = __DIR__ . '/uploads/';
if (!file_exists($targetDir)) {
    mkdir($targetDir, 0777, true);
}

// 2. Menerima File dari User & Validasi Upload Gagal
if (!isset($_FILES['file_dokumen']) || $_FILES['file_dokumen']['error'] !== UPLOAD_ERR_OK) {
    header("HTTP/1.1 200 OK");
    echo json_encode([
        "status" => "error",
        "message" => "Upload Gagal: Berkas tidak ditemukan atau terjadi kesalahan saat mengunggah."
    ], JSON_PRETTY_PRINT);
    exit();
}

$file =$_FILES['file_dokumen'];
$originalName = basename($file['name']);
$fileExt = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

// 3. Membuat Nama File Unik (Mencegah Overwrite)
$cleanName = preg_replace("/[^a-zA-Z0-9_\.-]/", "_", pathinfo($originalName, PATHINFO_FILENAME));$uniqueFileName = time() . '_' . uniqid() . '_' . $cleanName . '.' .$fileExt;

$targetFilePath = $targetDir .$uniqueFileName;
$relativeDbPath = 'uploads/' .$uniqueFileName;

// Data Form Pesanan
$id_user        = isset($_POST['id_user']) ? intval($_POST['id_user']) : 2;
$jenis_print    = $_POST['jenis_print'] ?? 'hitam_putih';$ukuran_kertas  = $_POST['ukuran_kertas'] ?? 'A4 70gr';$jumlah_halaman = isset($_POST['jumlah_halaman']) ? intval($_POST['jumlah_halaman']) : 1;
$jumlah_copy    = isset($_POST['jumlah_copy']) ? intval($_POST['jumlah_copy']) : 1;
$jenis_jilid    = $_POST['jenis_jilid'] ?? 'Tanpa Jilid';$catatan        = $_POST['catatan'] ?? '';$total_harga    = isset($_POST['total_harga']) ? floatval($_POST['total_harga']) : 0;

// 4. Menyimpan File ke Server Physical Directory
if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {$db = isset($conn) ?$conn : (isset($pdo) ?$pdo : null);

    if ($db) {
        try {
            // 5. Menyimpan Informasi & Path File ke Database `print_jilid`
            $sql = "INSERT INTO print_jilid 
                    (id_user, nama_file, file_path, jenis_print, ukuran_kertas, jumlah_halaman, jumlah_copy, jenis_jilid, catatan, total_harga, status) 
                    VALUES 
                    (:id_user, :nama_file, :file_path, :jenis_print, :ukuran_kertas, :jumlah_halaman, :jumlah_copy, :jenis_jilid, :catatan, :total_harga, 'menunggu')";
            
            $stmt =$db->prepare($sql);$stmt->execute([
                ':id_user'        => $id_user,
                ':nama_file'      => $originalName,
                ':file_path'      => $relativeDbPath,
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
                "status" => "success",
                "message" => "File berhasil diunggah dan tersimpan di database!",
                "data" => [
                    "id_print"       => $db->lastInsertId(),
                    "nama_file_asli" => $originalName,
                    "nama_file_unik" => $uniqueFileName,
                    "path_simpan"    => $relativeDbPath,
                    "total_harga"    => "Rp " . number_format($total_harga, 0, ',', '.')
                ]
            ], JSON_PRETTY_PRINT);
            exit();

        } catch (PDOException $e) {
            header("HTTP/1.1 200 OK");
            echo json_encode(["status" => "error", "message" => "Database Error: " . $e->getMessage()], JSON_PRETTY_PRINT);
            exit();
        }
    }

    header("HTTP/1.1 200 OK");
    echo json_encode([
        "status" => "success",
        "message" => "File berhasil diunggah ke server (Tanpa Koneksi DB)",
        "file_path" => $relativeDbPath
    ], JSON_PRETTY_PRINT);
    exit();
} else {
    header("HTTP/1.1 200 OK");
    echo json_encode([
        "status" => "error",
        "message" => "Gagal memindahkan file ke direktori uploads."
    ], JSON_PRETTY_PRINT);
    exit();
}
?>