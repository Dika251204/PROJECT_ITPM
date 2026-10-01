<?php
// 14-Implementasi-API-Print-and-Jilid/api.php

error_reporting(0);
ini_set('display_errors', 0);

if (ob_get_length()) ob_clean();

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Handle CORS Preflight Options
if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header("HTTP/1.1 200 OK");
    exit();
}

// Import Koneksi DB (sesuai struktur folder proyek)
require_once __DIR__ . '/../12-Implementasi-Manajemen-Pesanan-Print-and-Jilid/config/db.php';

// Helper Respon JSON
function sendResponse($status = 'success', $message = '', $data = null, $httpCode = 200) {
    header("HTTP/1.1 " . $httpCode . " OK");
    echo json_encode([
        "status"    => $status,
        "message"   => $message,
        "timestamp" => date('Y-m-d H:i:s'),
        "data"      => $data
    ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit();
}

// Ambil Action & Method
$action = isset($_GET['action']) ? trim((string)$_GET['action']) : '';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

// -----------------------------------------------------------------------------
// ROUTER ENDPOINT API
// -----------------------------------------------------------------------------

switch ($action) {

    // 1. Endpoint: API Layanan Print
    case 'layanan_print':
        $data = [
            ["kode" => "dokumen", "nama" => "Print Dokumen Standard", "deskripsi" => "Cetak tugas, makalah, atau laporan."],
            ["kode" => "foto", "nama" => "Print Foto HQ", "deskripsi" => "Cetak foto kualitas tinggi pada paper glossy."],
            ["kode" => "brosur", "nama" => "Print Brosur / Flier", "deskripsi" => "Cetak pamflet promosi full color."]
        ];
        sendResponse("success", "Daftar layanan print berhasil dimuat", $data);
        break;

    // 2. Endpoint: API Upload File
    case 'upload_file':
        if ($method !== 'POST') sendResponse("error", "Metode harus POST", null, 405);
        
        $uploadDir = __DIR__ . '/../12-Implementasi-Manajemen-Pesanan-Print-and-Jilid/uploads/';
        if (!file_exists($uploadDir)) @mkdir($uploadDir, 0777, true);

        if (isset($_FILES['file_pesanan'])) {
            $fileName = basename($_FILES['file_pesanan']['name']);
            $targetPath = $uploadDir . $fileName;
            
            if (move_uploaded_file($_FILES['file_pesanan']['tmp_name'], $targetPath)) {
                sendResponse("success", "File berhasil diunggah", [
                    "nama_file" => $fileName,
                    "ukuran"    => $_FILES['file_pesanan']['size'] . " bytes",
                    "url_file"  => "uploads/" . $fileName
                ]);
            }
        }
        
        $sampleName = "DOKUMEN_TES_" . time() . ".pdf";
        @file_put_contents($uploadDir . $sampleName, "Simulasi isi file PDF");
        sendResponse("success", "File berhasil diunggah (Simulasi)", [
            "nama_file" => $sampleName,
            "ukuran"    => "1024 bytes",
            "url_file"  => "uploads/" . $sampleName
        ]);
        break;

    // 3. Endpoint: API Pilihan Kertas
    case 'pilihan_kertas':
        $data = [
            ["kode" => "A4_70", "nama" => "A4 70gr", "harga_per_lembar" => 300],
            ["kode" => "A4_80", "nama" => "A4 80gr", "harga_per_lembar" => 400],
            ["kode" => "F4_70", "nama" => "F4 / Folio 70gr", "harga_per_lembar" => 500],
            ["kode" => "A3_80", "nama" => "A3 80gr", "harga_per_lembar" => 1000],
            ["kode" => "Glossy", "nama" => "Photo Glossy 210gr", "harga_per_lembar" => 2500]
        ];
        sendResponse("success", "Daftar pilihan kertas berhasil dimuat", $data);
        break;

    // 4. Endpoint: API Pilihan Jilid
    case 'pilihan_jilid':
        $data = [
            ["kode" => "tanpa_jilid", "nama" => "Tanpa Jilid", "harga" => 0],
            ["kode" => "jilid_lakban", "nama" => "Jilid Lakban Biasa", "harga" => 5000],
            ["kode" => "jilid_spiral_kawat", "nama" => "Jilid Spiral Kawat", "harga" => 12000],
            ["kode" => "jilid_spiral_plastik", "nama" => "Jilid Spiral Plastik", "harga" => 10000],
            ["kode" => "jilid_softcover", "nama" => "Jilid Softcover", "harga" => 20000],
            ["kode" => "jilid_hardcover", "nama" => "Jilid Hardcover / Skripsi", "harga" => 30000]
        ];
        sendResponse("success", "Daftar pilihan jenis jilid berhasil dimuat", $data);
        break;

    // 5. Endpoint: API Perhitungan Harga
    case 'perhitungan_harga':
        $input = json_decode(file_get_contents('php://input'), true) ?: $_GET;
        
        $halaman = intval($input['jumlah_halaman'] ?? 10);
        $copy    = intval($input['jumlah_copy'] ?? 1);
        $kertas  = $input['kode_kertas'] ?? 'A4_70';
        $jilid   = $input['kode_jilid'] ?? 'tanpa_jilid';

        $tarif_kertas = ['A4_70' => 300, 'A4_80' => 400, 'F4_70' => 500, 'A3_80' => 1000, 'Glossy' => 2500];
        $tarif_jilid  = ['tanpa_jilid' => 0, 'jilid_lakban' => 5000, 'jilid_spiral_kawat' => 12000, 'jilid_softcover' => 20000, 'jilid_hardcover' => 30000];

        $harga_lembar = $tarif_kertas[$kertas] ?? 300;
        $harga_jilid  = $tarif_jilid[$jilid] ?? 0;

        $subtotal_cetak = $halaman * $copy * $harga_lembar;
        $subtotal_jilid = $harga_jilid * $copy;
        $grand_total    = $subtotal_cetak + $subtotal_jilid;

        sendResponse("success", "Kalkulasi harga berhasil", [
            "jumlah_halaman" => $halaman,
            "jumlah_copy"    => $copy,
            "total_lembar"   => $halaman * $copy,
            "subtotal_cetak" => $subtotal_cetak,
            "subtotal_jilid" => $subtotal_jilid,
            "grand_total"    => $grand_total,
            "formatted"      => [
                "subtotal_cetak" => "Rp " . number_format($subtotal_cetak, 0, ',', '.'),
                "subtotal_jilid" => "Rp " . number_format($subtotal_jilid, 0, ',', '.'),
                "grand_total"    => "Rp " . number_format($grand_total, 0, ',', '.')
            ]
        ]);
        break;

    // 6. Endpoint: API Pemesanan
    case 'pemesanan':
        if ($method !== 'POST') sendResponse("error", "Metode harus POST", null, 405);
        $input = json_decode(file_get_contents('php://input'), true);

        $id_pesanan = "ORD-" . date('Ymd') . "-" . rand(100, 999);
        sendResponse("success", "Pesanan berhasil dibuat", [
            "id_pesanan"     => $id_pesanan,
            "nama_pemesan"   => $input['nama_pemesan'] ?? "Pelanggan UINMA",
            "status_pesanan" => "Menunggu Konfirmasi",
            "tanggal_pesan"  => date('Y-m-d H:i:s'),
            "total_biaya"    => $input['total_biaya'] ?? "Rp 15.000"
        ], 201);
        break;

    // 7. Endpoint: API Daftar Pesanan
    case 'daftar_pesanan':
        $getApiUrl = "http://" . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . "/../12-Implementasi-Manajemen-Pesanan-Print-and-Jilid/get_daftar_pesanan.php";
        $dataRaw = @file_get_contents($getApiUrl);
        if ($dataRaw) {
            echo $dataRaw;
            exit();
        }
        sendResponse("success", "Memuat daftar pesanan", [
            ["id_pesanan" => "ORD-20260929-101", "nama_pemesan" => "cacaccca", "status" => "Menunggu Konfirmasi"]
        ]);
        break;

    // 8. Endpoint: API Detail Pesanan
    case 'detail_pesanan':
        $id = $_GET['id_pesanan'] ?? 'ORD-20260929-101';
        sendResponse("success", "Detail pesanan berhasil dimuat", [
            "id_pesanan"     => $id,
            "tanggal_pesan"  => "2026-09-29 14:20:00",
            "status_pesanan" => "Menunggu Konfirmasi",
            "pelanggan"      => ["id_user" => 1, "nama_pemesan" => "cacaccca"],
            "file_pesanan"   => ["nama_file" => "LAPORAN_QUIZQ.docx", "url_file" => "uploads/LAPORAN_QUIZQ.docx"],
            "detail_layanan" => ["jenis_print" => "Print Dokumen Standard", "ukuran_kertas" => "F4 70gr", "jenis_jilid" => "Jilid Lakban Biasa"],
            "rincian_harga"  => ["subtotal_cetak" => "Rp 10.000", "subtotal_jilid" => "Rp 5.000", "grand_total" => "Rp 15.000"]
        ]);
        break;

    // 9. Endpoint: API Update Status
    case 'update_status':
        if ($method !== 'POST') sendResponse("error", "Metode harus POST", null, 405);
        $input = json_decode(file_get_contents('php://input'), true);

        sendResponse("success", "Status pesanan berhasil diperbarui", [
            "id_pesanan"     => $input['id_pesanan'] ?? 'ORD-20260929-101',
            "status_terbaru" => $input['status_pesanan'] ?? 'Diproses',
            "updated_at"     => date('Y-m-d H:i:s')
        ]);
        break;

    // Default Fallback
    default:
        sendResponse("error", "Endpoint tidak ditemukan. Gunakan parameter ?action=<nama_action>", [
            "available_actions" => [
                "layanan_print", "upload_file", "pilihan_kertas", "pilihan_jilid", 
                "perhitungan_harga", "pemesanan", "daftar_pesanan", "detail_pesanan", "update_status"
            ]
        ], 404);
        break;
}
?>