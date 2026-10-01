<?php
// 10-Implementasi-Perhitungan-Harga/process_hitung.php

if (ob_get_length()) ob_clean();

error_reporting(0);
ini_set('display_errors', 0);

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(["status" => "error", "message" => "Metode request harus POST."]);
    exit();
}

// Master Data Tarif Layanan
$master_print = [
    'dokumen' => ['nama' => 'Print Dokumen Standard', 'harga_dasar' => 300],
    'foto'    => ['nama' => 'Print Foto High Quality', 'harga_dasar' => 2000],
    'brosur'  => ['nama' => 'Print Brosur / Flier', 'harga_dasar' => 1000]
];

$master_kertas = [
    'A4_70'  => ['nama' => 'A4 70gr', 'harga' => 200],
    'A4_80'  => ['nama' => 'A4 80gr', 'harga' => 300],
    'F4_70'  => ['nama' => 'F4/Folio 70gr', 'harga' => 250],
    'A3_80'  => ['nama' => 'A3 80gr', 'harga' => 600],
    'Glossy' => ['nama' => 'Kertas Foto Glossy 210gr', 'harga' => 2500]
];

$master_warna = [
    'hitam_putih'  => ['nama' => 'Hitam Putih (B&W)', 'harga' => 300],
    'warna_sedikit' => ['nama' => 'Warna Teks / Diagram (25%)', 'harga' => 600],
    'warna_full'    => ['nama' => 'Full Color (100%)', 'harga' => 1200]
];

$master_jilid = [
    'tanpa_jilid'          => ['nama' => 'Tanpa Jilid', 'harga' => 0],
    'jilid_lakban'         => ['nama' => 'Jilid Lakban Biasa', 'harga' => 5000],
    'jilid_spiral_kawat'   => ['nama' => 'Jilid Spiral Kawat', 'harga' => 12000],
    'jilid_spiral_plastik' => ['nama' => 'Jilid Spiral Plastik', 'harga' => 10000],
    'jilid_softcover'      => ['nama' => 'Jilid Softcover', 'harga' => 15000],
    'jilid_hardcover'      => ['nama' => 'Jilid Hardcover / Skripsi', 'harga' => 30000]
];

// Terima Data Input
$id_pesanan     = $_POST['id_pesanan'] ?? 'ORD-' . rand(1000, 9999);
$jenis_print    = $_POST['jenis_print'] ?? 'dokumen';
$ukuran_kertas  = $_POST['ukuran_kertas'] ?? 'A4_70';
$jenis_warna    = $_POST['jenis_warna'] ?? 'hitam_putih';
$jenis_jilid    = $_POST['jenis_jilid'] ?? 'tanpa_jilid';
$jumlah_halaman = max(1, intval($_POST['jumlah_halaman'] ?? 1));
$jumlah_copy    = max(1, intval($_POST['jumlah_copy'] ?? 1));

// Validasi Input
if (!isset($master_print[$jenis_print]) || 
    !isset($master_kertas[$ukuran_kertas]) || 
    !isset($master_warna[$jenis_warna]) || 
    !isset($master_jilid[$jenis_jilid])) {
    
    echo json_encode([
        "status" => "error",
        "message" => "Memvalidasi Gagal: Kombinasi layanan tidak ditemukan dalam master data."
    ]);
    exit();
}

// 8. Fungsi Kalkulasi Harga Utuh
function kalkulasiHargaTotal($print, $kertas, $warna, $jilid, $hal, $copy) {
    // 1. Menghitung harga print
    $harga_print = $print['harga_dasar'];
    
    // 2. Menghitung harga kertas
    $harga_kertas = $kertas['harga'];
    
    // 3. Menghitung harga warna
    $harga_warna = $warna['harga'];
    
    // Total biaya cetak per 1 lembar halaman
    $harga_per_lembar = $harga_print + $harga_kertas + $harga_warna;
    
    // 4. Menghitung harga berdasarkan jumlah
    $total_lembar = $hal * $copy;
    $subtotal_cetak = $harga_per_lembar * $total_lembar;
    
    // 5. Menghitung biaya jilid
    $biaya_jilid_satuan = $jilid['harga'];
    $subtotal_jilid = $biaya_jilid_satuan * $copy;
    
    // 6. Menghitung subtotal & 7. Menghitung total biaya
    $grand_total = $subtotal_cetak + $subtotal_jilid;

    return [
        "harga_print"        => $harga_print,
        "harga_kertas"       => $harga_kertas,
        "harga_warna"        => $harga_warna,
        "harga_per_lembar"   => $harga_per_lembar,
        "total_lembar"       => $total_lembar,
        "subtotal_cetak"     => $subtotal_cetak,
        "biaya_jilid_satuan" => $biaya_jilid_satuan,
        "subtotal_jilid"     => $subtotal_jilid,
        "grand_total"        => $grand_total
    ];
}

// Jalankan kalkulasi
$kalkulasi = kalkulasiHargaTotal(
    $master_print[$jenis_print],
    $master_kertas[$ukuran_kertas],
    $master_warna[$jenis_warna],
    $master_jilid[$jenis_jilid],
    $jumlah_halaman,
    $jumlah_copy
);

// 9 & 10. Output JSON Respons Berhasil (Validasi dan Kombinasi Layanan Teruji)
echo json_encode([
    "status"  => "success",
    "message" => "Perhitungan harga berhasil dihitung secara presisi!",
    "rincian_pesanan" => [
        "id_pesanan" => $id_pesanan,
        "kombinasi_layanan" => [
            "jenis_print"   => $master_print[$jenis_print]['nama'],
            "ukuran_kertas" => $master_kertas[$ukuran_kertas]['nama'],
            "jenis_warna"   => $master_warna[$jenis_warna]['nama'],
            "jenis_jilid"   => $master_jilid[$jenis_jilid]['nama'],
            "jumlah_halaman"=> $jumlah_halaman . " Halaman",
            "jumlah_copy"   => $jumlah_copy . " Copy"
        ],
        "kalkulasi_biaya" => [
            "harga_print_per_hal"  => "Rp " . number_format($kalkulasi['harga_print'], 0, ',', '.'),
            "harga_kertas_per_hal" => "Rp " . number_format($kalkulasi['harga_kertas'], 0, ',', '.'),
            "harga_warna_per_hal"  => "Rp " . number_format($kalkulasi['harga_warna'], 0, ',', '.'),
            "biaya_per_lembar"     => "Rp " . number_format($kalkulasi['harga_per_lembar'], 0, ',', '.'),
            "total_lembar_cetak"   => $kalkulasi['total_lembar'] . " Lembar",
            "subtotal_cetak"       => "Rp " . number_format($kalkulasi['subtotal_cetak'], 0, ',', '.'),
            "subtotal_jilid"       => "Rp " . number_format($kalkulasi['subtotal_jilid'], 0, ',', '.'),
            "grand_total_biaya"    => "Rp " . number_format($kalkulasi['grand_total'], 0, ',', '.')
        ]
    ]
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit();
?>