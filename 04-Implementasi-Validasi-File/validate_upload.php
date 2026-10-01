<?php
// 04-Implementasi-Validasi-File/validate_upload.php

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

// 2. Memvalidasi Keberadaan Berkas yang Diunggah
if (!isset($_FILES['file_dokumen']) || $_FILES['file_dokumen']['error'] !== UPLOAD_ERR_OK) {
    header("HTTP/1.1 200 OK");
    echo json_encode([
        "status" => "error",
        "message" => "Validasi Gagal: File tidak ditemukan atau terjadi kesalahan saat pengunggahan."
    ], JSON_PRETTY_PRINT);
    exit();
}

$file = $_FILES['file_dokumen'];

// 3. Memvalidasi File Kosong (0 Byte)
if ($file['size'] <= 0) {
    header("HTTP/1.1 200 OK");
    echo json_encode([
        "status" => "error",
        "message" => "Validasi Gagal: File yang diunggah kosong (0 Byte)."
    ], JSON_PRETTY_PRINT);
    exit();
}

// 4. Membatasi Ukuran File (Maksimal 10 MB = 10 * 1024 * 1024 Byte)
$maxFileSize = 10 * 1024 * 1024;
if ($file['size'] > $maxFileSize) {
    header("HTTP/1.1 200 OK");
    echo json_encode([
        "status" => "error",
        "message" => "Validasi Gagal: Ukuran file melebihi batas maksimum 10 MB (" . round($file['size'] / (1024 * 1024), 2) . " MB)."
    ], JSON_PRETTY_PRINT);
    exit();
}

// 5. Membatasi Format File (Hanya PDF, DOC, DOCX)
$allowedExtensions = ['pdf', 'doc', 'docx'];
$originalName = basename($file['name']);
$fileExt = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

if (!in_array($fileExt, $allowedExtensions)) {
    header("HTTP/1.1 200 OK");
    echo json_encode([
        "status" => "error",
        "message" => "Validasi Gagal: Format file '." . $fileExt . "' tidak diizinkan. Hanya menerima format PDF, DOC, dan DOCX."
    ], JSON_PRETTY_PRINT);
    exit();
}

// 6. Memvalidasi & Sanitasi Nama File (Mengamankan Proses Penyimpanan)
$rawFileName = pathinfo($originalName, PATHINFO_FILENAME);
$cleanFileName = preg_replace("/[^a-zA-Z0-9_\.-]/", "_", $rawFileName);

// 7. Mencegah Nama File Duplikat (Unique File Generator)
$uniqueFileName = time() . '_' . uniqid() . '_' . $cleanFileName . '.' . $fileExt;
$targetFilePath = $targetDir . $uniqueFileName;
$relativeDbPath = 'uploads/' . $uniqueFileName;

// Pengambilan Data Form
$id_user        = isset($_POST['id_user']) ? intval($_POST['id_user']) : 2;
$jenis_print    = $_POST['jenis_print'] ?? 'hitam_putih';
$ukuran_kertas  = $_POST['ukuran_kertas'] ?? 'A4 70gr';
$jumlah_halaman = isset($_POST['jumlah_halaman']) ? intval($_POST['jumlah_halaman']) : 1;
$jumlah_copy    = isset($_POST['jumlah_copy']) ? intval($_POST['jumlah_copy']) : 1;
$jenis_jilid    = $_POST['jenis_jilid'] ?? 'Tanpa Jilid';
$catatan        = $_POST['catatan'] ?? '';
$total_harga    = isset($_POST['total_harga']) ? floatval($_POST['total_harga']) : 0;

// 8. Pindahkan File Fisik & Simpan Informasi ke Database
if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
    $db = isset($conn) ? $conn : (isset($pdo) ? $pdo : null);

    if ($db) {
        try {
            $sql = "INSERT INTO print_jilid 
                    (id_user, nama_file, file_path, jenis_print, ukuran_kertas, jumlah_halaman, jumlah_copy, jenis_jilid, catatan, total_harga, status) 
                    VALUES 
                    (:id_user, :nama_file, :file_path, :jenis_print, :ukuran_kertas, :jumlah_halaman, :jumlah_copy, :jenis_jilid, :catatan, :total_harga, 'menunggu')";
            
            $stmt = $db->prepare($sql);
            $stmt->execute([
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
                "message" => "File LOLOS VALIDASI dan berhasil disimpan ke database!",
                "detail_validasi" => [
                    "id_print"        => $db->lastInsertId(),
                    "nama_file_asli"  => $originalName,
                    "nama_file_unik"  => $uniqueFileName,
                    "ekstensi"        => $fileExt,
                    "ukuran_file"     => round($file['size'] / 1024, 2) . " KB",
                    "path_tersimpan"  => $relativeDbPath,
                    "status_validasi" => "PASSED (Format, Ukuran, & Sanitasi Aman)"
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
        "message" => "File lolos validasi dan tersimpan di server.",
        "path" => $relativeDbPath
    ], JSON_PRETTY_PRINT);
    exit();
} else {
    header("HTTP/1.1 200 OK");
    echo json_encode(["status" => "error", "message" => "Gagal memindahkan file ke folder uploads."], JSON_PRETTY_PRINT);
    exit();
}
?>