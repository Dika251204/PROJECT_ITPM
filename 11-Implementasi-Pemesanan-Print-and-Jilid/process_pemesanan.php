<?php
// 11-Implementasi-Pemesanan-Print-and-Jilid/process_pemesanan.php

// 1. Matikan tampilan error langsung agar tidak merusak output JSON
error_reporting(0);
ini_set('display_errors', 0);

// 2. Bersihkan output buffer jika ada karakter sebelum header
if (ob_get_length()) ob_clean();

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

require_once __DIR__ . '/config/db.php';

// Validasi Metode Request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode([
        "status" => "error", 
        "message" => "Metode request harus POST."
    ]);
    exit();
}

// Master Price List Layanan
$master_print = [
    'dokumen' => ['nama' => 'Print Dokumen Standard', 'harga' => 300],
    'foto'    => ['nama' => 'Print Foto HQ', 'harga' => 2000],
    'brosur'  => ['nama' => 'Print Brosur / Flier', 'harga' => 1000]
];

$master_kertas = [
    'A4_70'  => ['nama' => 'A4 70gr', 'harga' => 200],
    'A4_80'  => ['nama' => 'A4 80gr', 'harga' => 300],
    'F4_70'  => ['nama' => 'F4/Folio 70gr', 'harga' => 250],
    'A3_80'  => ['nama' => 'A3 80gr', 'harga' => 600],
    'Glossy' => ['nama' => 'Photo Glossy 210gr', 'harga' => 2500]
];

$master_warna = [
    'hitam_putih'   => ['nama' => 'Hitam Putih', 'harga' => 300],
    'warna_sedikit' => ['nama' => 'Warna Teks/Diagram', 'harga' => 600],
    'warna_full'    => ['nama' => 'Full Color', 'harga' => 1200]
];

$master_jilid = [
    'tanpa_jilid'          => ['nama' => 'Tanpa Jilid', 'harga' => 0],
    'jilid_lakban'         => ['nama' => 'Jilid Lakban Biasa', 'harga' => 5000],
    'jilid_spiral_kawat'   => ['nama' => 'Jilid Spiral Kawat', 'harga' => 12000],
    'jilid_spiral_plastik' => ['nama' => 'Jilid Spiral Plastik', 'harga' => 10000],
    'jilid_softcover'      => ['nama' => 'Jilid Softcover', 'harga' => 15000],
    'jilid_hardcover'      => ['nama' => 'Jilid Hardcover / Skripsi', 'harga' => 30000]
];

// Ambil input POST
$id_user        = intval($_POST['id_user'] ?? 1);
$nama_pemesan   = trim($_POST['nama_pemesan'] ?? 'Pelanggan UINMA');
$jenis_print   = $_POST['jenis_print'] ?? 'foto';
$ukuran_kertas = $_POST['ukuran_kertas'] ?? 'F4_70';
$jenis_warna   = $_POST['jenis_warna'] ?? 'warna_sedikit';
$jenis_jilid   = $_POST['jenis_jilid'] ?? 'jilid_softcover';
$jumlah_halaman = max(1, intval($_POST['jumlah_halaman'] ?? 1));
$jumlah_copy    = max(1, intval($_POST['jumlah_copy'] ?? 1));

// Proses File Dokumen (PDF, DOC, DOCX)
$nama_file_simpan = "file_default.pdf";
$ukuran_file       = 0;

if (isset($_FILES['file_dokumen']) && $_FILES['file_dokumen']['error'] === UPLOAD_ERR_OK) {
    $upload_dir = __DIR__ . '/uploads/';
    if (!file_exists($upload_dir)) {
        @mkdir($upload_dir, 0777, true);
    }
    
    $file_tmp   = $_FILES['file_dokumen']['tmp_name'];
    $file_orig  = $_FILES['file_dokumen']['name'];
    $ukuran_file= $_FILES['file_dokumen']['size'];
    
    // Sanitasi nama file
    $nama_clean = preg_replace("/[^a-zA-Z0-9\._-]/", "_", $file_orig);
    $nama_file_simpan = time() . '_' . $nama_clean;
    
    @move_uploaded_file($file_tmp, $upload_dir . $nama_file_simpan);
}

// Perhitungan Harga
$harga_print   = $master_print[$jenis_print]['harga'] ?? 2000;
$harga_kertas  = $master_kertas[$ukuran_kertas]['harga'] ?? 250;
$harga_warna   = $master_warna[$jenis_warna]['harga'] ?? 600;
$harga_jilid   = $master_jilid[$jenis_jilid]['harga'] ?? 15000;

$biaya_per_lembar = $harga_print + $harga_kertas + $harga_warna; // 2000 + 250 + 600 = 2850
$total_lembar     = $jumlah_halaman * $jumlah_copy;             // 20 * 1 = 20
$subtotal_cetak   = $biaya_per_lembar * $total_lembar;          // 2850 * 20 = 57.000
$subtotal_jilid   = $harga_jilid * $jumlah_copy;                // 15000 * 1 = 15.000
$grand_total      = $subtotal_cetak + $subtotal_jilid;          // 72.000

$id_pesanan = 'ORD-' . date('Ymd') . '-' . rand(100, 999);

// Coba simpan ke database (jika koneksi DB aktif)
$db_saved = false;
if (isset($conn) && $conn !== null) {
    try {
        $conn->beginTransaction();

        $stmt1 = $conn->prepare("INSERT INTO pesanan (id_pesanan, id_user, nama_pemesan, total_biaya, status_pesanan, tanggal_pesan) 
                                 VALUES (:id_pesanan, :id_user, :nama_pemesan, :total_biaya, 'Menunggu Konfirmasi', NOW())");
        $stmt1->execute([
            ':id_pesanan'   => $id_pesanan,
            ':id_user'      => $id_user,
            ':nama_pemesan' => $nama_pemesan,
            ':total_biaya'  => $grand_total
        ]);

        $stmt2 = $conn->prepare("INSERT INTO detail_pesanan 
            (id_pesanan, jenis_print, ukuran_kertas, jenis_warna, jenis_jilid, jumlah_halaman, jumlah_copy, nama_file, subtotal_cetak, subtotal_jilid, grand_total) 
            VALUES (:id_pesanan, :jenis_print, :ukuran_kertas, :jenis_warna, :jenis_jilid, :jumlah_halaman, :jumlah_copy, :nama_file, :subtotal_cetak, :subtotal_jilid, :grand_total)");
        
        $stmt2->execute([
            ':id_pesanan'     => $id_pesanan,
            ':jenis_print'   => $jenis_print,
            ':ukuran_kertas' => $ukuran_kertas,
            ':jenis_warna'   => $jenis_warna,
            ':jenis_jilid'   => $jenis_jilid,
            ':jumlah_halaman'=> $jumlah_halaman,
            ':jumlah_copy'   => $jumlah_copy,
            ':nama_file'     => $nama_file_simpan,
            ':subtotal_cetak'=> $subtotal_cetak,
            ':subtotal_jilid'=> $subtotal_jilid,
            ':grand_total'   => $grand_total
        ]);

        $conn->commit();
        $db_saved = true;
    } catch (Exception $e) {
        if ($conn->inTransaction()) {
            $conn->rollBack();
        }
        $db_saved = false;
    }
}

// Respon JSON Berhasil
echo json_encode([
    "status" => "success",
    "message" => "Pemesanan print & jilid berhasil diproses!",
    "database_status" => $db_saved ? "Tersimpan di Tabel Database" : "Mode Simulasi (DB Offline/Belum Diisi)",
    "data_pesanan" => [
        "id_pesanan"    => $id_pesanan,
        "user_info"     => [
            "id_user"      => $id_user,
            "nama_pemesan" => $nama_pemesan
        ],
        "layanan"       => [
            "jenis_print"   => $master_print[$jenis_print]['nama'] ?? $jenis_print,
            "ukuran_kertas" => $master_kertas[$ukuran_kertas]['nama'] ?? $ukuran_kertas,
            "jenis_warna"   => $master_warna[$jenis_warna]['nama'] ?? $jenis_warna,
            "jenis_jilid"   => $master_jilid[$jenis_jilid]['nama'] ?? $jenis_jilid
        ],
        "file_dokumen"  => [
            "nama_file"   => $nama_file_simpan,
            "ukuran_file" => $ukuran_file > 0 ? round($ukuran_file / 1024, 2) . " KB" : "Diunggah"
        ],
        "rincian_jumlah"=> [
            "halaman_per_copy" => $jumlah_halaman,
            "jumlah_copy"      => $jumlah_copy,
            "total_lembar"     => $total_lembar
        ],
        "rincian_biaya" => [
            "biaya_per_lembar" => "Rp " . number_format($biaya_per_lembar, 0, ',', '.'),
            "subtotal_cetak"   => "Rp " . number_format($subtotal_cetak, 0, ',', '.'),
            "subtotal_jilid"   => "Rp " . number_format($subtotal_jilid, 0, ',', '.'),
            "grand_total"      => "Rp " . number_format($grand_total, 0, ',', '.')
        ]
    ]
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit();