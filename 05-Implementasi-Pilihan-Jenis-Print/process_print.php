<?php
// 05-Implementasi-Pilihan-Jenis-Print/process_print.php

require_once __DIR__ . '/config/db.php';

header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(["status" => "error", "message" => "Metode request harus POST."]);
    exit();
}

// 1. Daftar Data & Tarif Resmi Jenis Print
$tarifPrint = [
    'hitam_putih' => 500,  // Rp 500 per halaman
    'warna'       => 1000  // Rp 1.000 per halaman
];

// 2. Menerima Data Input
$jenis_print    = $_POST['jenis_print'] ?? '';$id_user        = isset($_POST['id_user']) ? intval($_POST['id_user']) : 2;
$jumlah_halaman = isset($_POST['jumlah_halaman']) ? intval($_POST['jumlah_halaman']) : 1;
$jumlah_copy    = isset($_POST['jumlah_copy']) ? intval($_POST['jumlah_copy']) : 1;
$ukuran_kertas  =$_POST['ukuran_kertas'] ?? 'A4 70gr';
$jenis_jilid    =$_POST['jenis_jilid'] ?? 'Tanpa Jilid';
$catatan        =$_POST['catatan'] ?? '';

// 3. Validasi Pilihan Jenis Print
if (!array_key_exists($jenis_print,$tarifPrint)) {
    header("HTTP/1.1 200 OK");
    echo json_encode([
        "status" => "error",
        "message" => "Validasi Gagal: Jenis print '$jenis_print' tidak valid! Pilihan yang diizinkan: 'hitam_putih' atau 'warna'."
    ], JSON_PRETTY_PRINT);
    exit();
}

if ($jumlah_halaman <= 0 || $jumlah_copy <= 0) {
    header("HTTP/1.1 200 OK");
    echo json_encode([
        "status" => "error",
        "message" => "Validasi Gagal: Jumlah halaman dan copy harus lebih besar dari 0."
    ], JSON_PRETTY_PRINT);
    exit();
}

// 4. Perhitungan Harga Jenis Print
$harga_per_hal = $tarifPrint[$jenis_print];
$harga_print   =$harga_per_hal * $jumlah_halaman * $jumlah_copy;

// Total harga kumulatif jika dikirim dari simulator (termasuk kertas & jilid)
$total_harga   = isset($_POST['total_harga']) && floatval($_POST['total_harga']) > 0 
                 ? floatval($_POST['total_harga']) 
                 : $harga_print;

// Default nama file untuk simulasi API pilihan print
$nama_file      = "simulasi_print_" . $jenis_print . ".pdf";
$file_path      = "uploads/" . $nama_file;

// 5. Menyimpan Pilihan Jenis Print ke Database `print_jilid`
$db = isset($conn) ?$conn : (isset($pdo) ?$pdo : null);

if ($db) {
    try {
        $sql = "INSERT INTO print_jilid 
                (id_user, nama_file, file_path, jenis_print, ukuran_kertas, jumlah_halaman, jumlah_copy, jenis_jilid, catatan, total_harga, status) 
                VALUES 
                (:id_user, :nama_file, :file_path, :jenis_print, :ukuran_kertas, :jumlah_halaman, :jumlah_copy, :jenis_jilid, :catatan, :total_harga, 'menunggu')";
        
        $stmt =$db->prepare($sql);$stmt->execute([
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
            "message" => "Pilihan Jenis Print Berhasil Disimpan ke Pesanan!",
            "data_pilihan" => [
                "id_print"           => $db->lastInsertId(),
                "jenis_print"        => $jenis_print,
                "label_jenis_print"  => $jenis_print === 'hitam_putih' ? 'Print Hitam Putih' : 'Print Warna',
                "tarif_per_halaman"  => "Rp " . number_format($harga_per_hal, 0, ',', '.'),
                "jumlah_halaman"     => $jumlah_halaman,
                "jumlah_copy"        => $jumlah_copy,
                "subtotal_print"     => "Rp " . number_format($harga_print, 0, ',', '.'),
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

header("HTTP/1.1 200 OK");
echo json_encode([
    "status" => "success",
    "message" => "Pilihan jenis print terproses (Tanpa Koneksi DB)",
    "jenis_print" => $jenis_print
], JSON_PRETTY_PRINT);
exit();
?>