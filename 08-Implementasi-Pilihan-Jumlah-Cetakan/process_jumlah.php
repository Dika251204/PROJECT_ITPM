<?php
// 08-Implementasi-Pilihan-Jumlah-Cetakan/process_jumlah.php

error_reporting(E_ALL);
ini_set('display_errors', 0);

header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(["status" => "error", "message" => "Metode request harus POST."]);
    exit();
}

// 1 & 2. Menerima input jumlah halaman dan salinan
$id_user        = isset($_POST['id_user']) ? intval($_POST['id_user']) : 2;
$jumlah_halaman = isset($_POST['jumlah_halaman']) ? intval($_POST['jumlah_halaman']) : 0;
$jumlah_copy    = isset($_POST['jumlah_copy']) ? intval($_POST['jumlah_copy']) : 0;
$jenis_print    = $_POST['jenis_print'] ?? 'warna';
$ukuran_kertas  = $_POST['ukuran_kertas'] ?? 'A4 70gr';
$jenis_jilid    = $_POST['jenis_jilid'] ?? 'Tanpa Jilid';

// Batas Minimum & Maksimum
$MIN_HALAMAN = 1;
$MAX_HALAMAN = 1000;
$MIN_COPY    = 1;
$MAX_COPY    = 500;

// 3, 4, 5, & 9. Memvalidasi & Menangani input tidak valid (Min & Max)
if ($jumlah_halaman < $MIN_HALAMAN) {
    echo json_encode([
        "status" => "error",
        "message" => "Validasi Gagal: Jumlah halaman minimal $MIN_HALAMAN halaman."
    ], JSON_PRETTY_PRINT);
    exit();
}

if ($jumlah_halaman > $MAX_HALAMAN) {
    echo json_encode([
        "status" => "error",
        "message" => "Validasi Gagal: Jumlah halaman melebihi batas maksimum ($MAX_HALAMAN halaman)."
    ], JSON_PRETTY_PRINT);
    exit();
}

if ($jumlah_copy < $MIN_COPY) {
    echo json_encode([
        "status" => "error",
        "message" => "Validasi Gagal: Jumlah salinan/copy minimal $MIN_COPY copy."
    ], JSON_PRETTY_PRINT);
    exit();
}

if ($jumlah_copy > $MAX_COPY) {
    echo json_encode([
        "status" => "error",
        "message" => "Validasi Gagal: Jumlah salinan/copy melebihi batas maksimum ($MAX_COPY copy)."
    ], JSON_PRETTY_PRINT);
    exit();
}

// 6. Menhitung total lembar / total halaman tercetak
$total_lembar = $jumlah_halaman * $jumlah_copy;

// 8. Menghubungkan jumlah dengan harga
$harga_warna  = ($jenis_print === 'warna') ? 1000 : 500;
$harga_kertas = 500; // Standar A4 70gr
$harga_jilid  = ($jenis_jilid === 'Softcover') ? 15000 : (($jenis_jilid === 'Hardcover') ? 30000 : 0);

$subtotal_cetak = ($harga_warna + $harga_kertas) * $total_lembar;
$total_harga    = $subtotal_cetak + $harga_jilid;

// 7 & 10. Output sukses / Menguji perhitungan jumlah cetakan
echo json_encode([
    "status" => "success",
    "message" => "Validasi dan perhitungan jumlah cetakan berhasil!",
    "data_cetakan" => [
        "id_user"            => $id_user,
        "jumlah_halaman"     => $jumlah_halaman,
        "jumlah_copy"        => $jumlah_copy,
        "total_lembar_cetak" => $total_lembar,
        "rincian_biaya" => [
            "biaya_per_lembar"  => "Rp " . number_format($harga_warna + $harga_kertas, 0, ',', '.'),
            "subtotal_cetakan"  => "Rp " . number_format($subtotal_cetak, 0, ',', '.'),
            "biaya_jilid"       => "Rp " . number_format($harga_jilid, 0, ',', '.'),
            "total_keseluruhan" => "Rp " . number_format($total_harga, 0, ',', '.')
        ]
    ]
], JSON_PRETTY_PRINT);
exit();
?>