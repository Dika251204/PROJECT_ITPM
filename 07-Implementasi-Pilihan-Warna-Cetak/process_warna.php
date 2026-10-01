<?php
// 07-Implementasi-Pilihan-Warna-Cetak/process_warna.php

// Matikan display error agar tidak merusak output JSON
error_reporting(E_ALL);
ini_set('display_errors', 0);

header("Content-Type: application/json; charset=UTF-8");

// Load db.php secara aman
if (file_exists(__DIR__ . '/config/db.php')) {
    require_once __DIR__ . '/config/db.php';
} elseif (file_exists(__DIR__ . '/../01-Setup-Backend-Print-and-Jilid/config/db.php')) {
    require_once __DIR__ . '/../01-Setup-Backend-Print-and-Jilid/config/db.php';
}

// Response jika diakses via GET
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $data_warna = [
        ["jenis_print" => "hitam_putih", "label" => "Hitam Putih (B/W)", "harga_per_halaman" => 500],
        ["jenis_print" => "warna", "label" => "Warna Full / Partial", "harga_per_halaman" => 1000]
    ];
    echo json_encode([
        "status" => "success",
        "message" => "Daftar pilihan warna cetak berhasil dimuat.",
        "data" => $data_warna
    ], JSON_PRETTY_PRINT);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(["status" => "error", "message" => "Metode request harus POST."]);
    exit();
}

// Config Tarif Warna
$tarifWarna = [
    'hitam_putih' => 500,
    'warna'       => 1000
];

// Ambil input
$jenis_print    = $_POST['jenis_print'] ?? '';
$ukuran_kertas  = $_POST['ukuran_kertas'] ?? 'A4 70gr';
$id_user        = isset($_POST['id_user']) ? intval($_POST['id_user']) : 2;
$jumlah_halaman = isset($_POST['jumlah_halaman']) ? intval($_POST['jumlah_halaman']) : 1;
$jumlah_copy    = isset($_POST['jumlah_copy']) ? intval($_POST['jumlah_copy']) : 1;
$jenis_jilid    = $_POST['jenis_jilid'] ?? 'Tanpa Jilid';
$catatan        = $_POST['catatan'] ?? '';

// Validasi Pilihan Warna
if (!array_key_exists($jenis_print, $tarifWarna)) {
    header("HTTP/1.1 200 OK");
    echo json_encode([
        "status" => "error",
        "message" => "Validasi Gagal: Pilihan warna cetak '$jenis_print' tidak valid!"
    ], JSON_PRETTY_PRINT);
    exit();
}

if ($jumlah_halaman <= 0 || $jumlah_copy <= 0) {
    header("HTTP/1.1 200 OK");
    echo json_encode([
        "status" => "error",
        "message" => "Validasi Gagal: Jumlah halaman dan copy harus lebih dari 0."
    ], JSON_PRETTY_PRINT);
    exit();
}

// Hitung Harga
$harga_cetak_per_hal  = $tarifWarna[$jenis_print];
$subtotal_warna_cetak = $harga_cetak_per_hal * $jumlah_halaman * $jumlah_copy;

$total_harga = isset($_POST['total_harga']) && floatval($_POST['total_harga']) > 0 
               ? floatval($_POST['total_harga']) 
               : $subtotal_warna_cetak;

$nama_file = "dokumen_cetak_" . $jenis_print . ".pdf";
$file_path = "uploads/" . $nama_file;

// Buat folder uploads jika belum ada
if (!file_exists(__DIR__ . '/uploads')) {
    @mkdir(__DIR__ . '/uploads', 0777, true);
}

// Simpan ke Database jika koneksi tersedia
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
            ':nama_file'      => $nama_file,
            ':file_path'      => $file_path,
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
            "message" => "Pilihan warna cetak berhasil disimpan dan terhubung ke pesanan!",
            "data_pesanan" => [
                "id_print"           => $db->lastInsertId(),
                "jenis_print"        => $jenis_print,
                "tarif_per_halaman"  => "Rp " . number_format($harga_cetak_per_hal, 0, ',', '.'),
                "jumlah_halaman"     => $jumlah_halaman,
                "jumlah_copy"        => $jumlah_copy,
                "subtotal_cetak"     => "Rp " . number_format($subtotal_warna_cetak, 0, ',', '.'),
                "total_keseluruhan"  => "Rp " . number_format($total_harga, 0, ',', '.'),
                "status_pesanan"     => "menunggu"
            ]
        ], JSON_PRETTY_PRINT);
        exit();

    } catch (PDOException $e) {
        header("HTTP/1.1 200 OK");
        echo json_encode(["status" => "error", "message" => "Database Error: " . $e->getMessage()], JSON_PRETTY_PRINT);
        exit();
    }
}

// Fallback jika tidak ada koneksi DB
header("HTTP/1.1 200 OK");
echo json_encode([
    "status" => "success",
    "message" => "Pilihan warna terproses (Mode tanpa DB)",
    "data_pesanan" => [
        "jenis_print" => $jenis_print,
        "total_harga" => "Rp " . number_format($total_harga, 0, ',', '.')
    ]
], JSON_PRETTY_PRINT);
exit();
?>