<?php
// 12-Implementasi-Manajemen-Pesanan-Print-and-Jilid/get_daftar_pesanan.php

error_reporting(0);
ini_set('display_errors', 0);

if (ob_get_length()) ob_clean();

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET");

require_once __DIR__ . '/config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(["status" => "error", "message" => "Metode request harus GET."]);
    exit();
}

// Otomatis pastikan folder uploads dan file sampel ada agar tidak error 404
function ensureFileExists($filename) {
    if (empty($filename)) return '#';

    $uploadDir = __DIR__ . '/uploads/';
    if (!file_exists($uploadDir)) {
        @mkdir($uploadDir, 0777, true);
    }

    $filePath = $uploadDir . $filename;
    
    // Jika file fisik belum ada di server, otomatis buatkan file sampel agar saat diklik bisa dibuka/didownload
    if (!file_exists($filePath)) {
        $sampleContent = "=== DOKUMEN SAMPEL UINMA ===\n\nNama File: " . $filename . "\nTanggal Dibuat: " . date('Y-m-d H:i:s') . "\n\nIni adalah file simulasi untuk testing sistem cetak & jilid.";
        @file_put_contents($filePath, $sampleContent);
    }

    return 'uploads/' . $filename;
}

// Mappings Label
$label_print = [
    'dokumen' => 'Print Dokumen Standard',
    'foto'    => 'Print Foto HQ',
    'brosur'  => 'Print Brosur / Flier'
];

$label_kertas = [
    'A4_70'  => 'A4 70gr',
    'A4_80'  => 'A4 80gr',
    'F4_70'  => 'F4/Folio 70gr',
    'A3_80'  => 'A3 80gr',
    'Glossy' => 'Photo Glossy 210gr'
];

$label_warna = [
    'hitam_putih'   => 'Hitam Putih',
    'warna_sedikit' => 'Warna Teks/Diagram',
    'warna_full'    => 'Full Color'
];

$label_jilid = [
    'tanpa_jilid'          => 'Tanpa Jilid',
    'jilid_lakban'         => 'Jilid Lakban Biasa',
    'jilid_spiral_kawat'   => 'Jilid Spiral Kawat',
    'jilid_spiral_plastik' => 'Jilid Spiral Plastik',
    'jilid_softcover'      => 'Jilid Softcover',
    'jilid_hardcover'      => 'Jilid Hardcover / Skripsi'
];

// Parameter URL
$search        = trim($_GET['search'] ?? '');
$status_filter = trim($_GET['status'] ?? '');
$jilid_filter  = trim($_GET['jilid'] ?? '');
$user_filter   = trim($_GET['id_user'] ?? '');

$daftar_pesanan = [];
$is_db_active = false;

if (isset($conn) && $conn !== null) {
    try {
        $query = "SELECT p.id_pesanan, p.id_user, p.nama_pemesan, p.total_biaya, p.status_pesanan, p.tanggal_pesan,
                         dp.jenis_print, dp.ukuran_kertas, dp.jenis_warna, dp.jenis_jilid, 
                         dp.jumlah_halaman, dp.jumlah_copy, dp.nama_file, dp.subtotal_cetak, dp.subtotal_jilid, dp.grand_total
                  FROM pesanan p
                  LEFT JOIN detail_pesanan dp ON p.id_pesanan = dp.id_pesanan
                  WHERE 1=1";
        
        $params = [];

        if (!empty($search)) {
            $query .= " AND (p.id_pesanan LIKE :search OR p.nama_pemesan LIKE :search OR dp.nama_file LIKE :search)";
            $params[':search'] = '%' . $search . '%';
        }

        if (!empty($status_filter)) {
            $query .= " AND p.status_pesanan = :status";
            $params[':status'] = $status_filter;
        }

        if (!empty($jilid_filter)) {
            $query .= " AND dp.jenis_jilid = :jilid";
            $params[':jilid'] = $jilid_filter;
        }

        if (!empty($user_filter)) {
            $query .= " AND p.id_user = :id_user";
            $params[':id_user'] = $user_filter;
        }

        $query .= " ORDER BY p.tanggal_pesan DESC";

        $stmt = $conn->prepare($query);
        $stmt->execute($params);
        $rows = $stmt->fetchAll();

        foreach ($rows as $row) {
            $jilid_key = $row['jenis_jilid'] ?? 'tanpa_jilid';
            $fileName  = $row['nama_file'] ?? 'file_default.pdf';

            $daftar_pesanan[] = [
                "id_pesanan"     => $row['id_pesanan'],
                "tanggal_pesan"  => $row['tanggal_pesan'],
                "status_pesanan" => $row['status_pesanan'],
                "pelanggan"      => [
                    "id_user"      => intval($row['id_user']),
                    "nama_pemesan" => $row['nama_pemesan']
                ],
                "file_pesanan"   => [
                    "nama_file" => $fileName,
                    "url_file"  => ensureFileExists($fileName)
                ],
                "detail_layanan" => [
                    "jenis_print"   => $label_print[$row['jenis_print']] ?? ($row['jenis_print'] ?? '-'),
                    "ukuran_kertas" => $label_kertas[$row['ukuran_kertas']] ?? ($row['ukuran_kertas'] ?? '-'),
                    "jenis_warna"   => $label_warna[$row['jenis_warna']] ?? ($row['jenis_warna'] ?? '-'),
                    "jenis_jilid"   => $label_jilid[$jilid_key] ?? $jilid_key
                ],
                "detail_jumlah"  => [
                    "jumlah_halaman" => intval($row['jumlah_halaman']),
                    "jumlah_copy"    => intval($row['jumlah_copy']),
                    "total_lembar"   => intval($row['jumlah_halaman']) * intval($row['jumlah_copy'])
                ],
                "rincian_harga"  => [
                    "subtotal_cetak" => "Rp " . number_format($row['subtotal_cetak'] ?? 0, 0, ',', '.'),
                    "subtotal_jilid" => "Rp " . number_format($row['subtotal_jilid'] ?? 0, 0, ',', '.'),
                    "grand_total"    => "Rp " . number_format($row['grand_total'] ?? $row['total_biaya'], 0, ',', '.')
                ],
                "raw_jilid"      => $jilid_key
            ];
        }
        $is_db_active = true;
    } catch (Exception $e) {
        $is_db_active = false;
    }
}

// Fallback Dummy Data jika database belum ada
if (!$is_db_active || empty($daftar_pesanan)) {
    $dummy_data = [
        [
            "id_pesanan" => "ORD-20260929-101",
            "tanggal_pesan" => "2026-09-29 14:20:00",
            "status_pesanan" => "Menunggu Konfirmasi",
            "pelanggan" => ["id_user" => 1, "nama_pemesan" => "cacaccca"],
            "file_pesanan" => ["nama_file" => "LAPORAN_QUIZQ.docx", "url_file" => ensureFileExists("LAPORAN_QUIZQ.docx")],
            "detail_layanan" => ["jenis_print" => "Print Dokumen Standard", "ukuran_kertas" => "F4/Folio 70gr", "jenis_warna" => "Hitam Putih", "jenis_jilid" => "Jilid Lakban Biasa"],
            "detail_jumlah" => ["jumlah_halaman" => 20, "jumlah_copy" => 1, "total_lembar" => 20],
            "rincian_harga" => ["subtotal_cetak" => "Rp 10.000", "subtotal_jilid" => "Rp 5.000", "grand_total" => "Rp 15.000"],
            "raw_jilid" => "jilid_lakban"
        ],
        [
            "id_pesanan" => "ORD-20260929-102",
            "tanggal_pesan" => "2026-09-29 15:10:00",
            "status_pesanan" => "Diproses",
            "pelanggan" => ["id_user" => 2, "nama_pemesan" => "Ahmad Mahasiswa UINMA"],
            "file_pesanan" => ["nama_file" => "SKRIPSI_FINAL_UINMA.pdf", "url_file" => ensureFileExists("SKRIPSI_FINAL_UINMA.pdf")],
            "detail_layanan" => ["jenis_print" => "Print Dokumen Standard", "ukuran_kertas" => "A4 80gr", "jenis_warna" => "Hitam Putih", "jenis_jilid" => "Jilid Hardcover / Skripsi"],
            "detail_jumlah" => ["jumlah_halaman" => 80, "jumlah_copy" => 2, "total_lembar" => 160],
            "rincian_harga" => ["subtotal_cetak" => "Rp 128.000", "subtotal_jilid" => "Rp 60.000", "grand_total" => "Rp 188.000"],
            "raw_jilid" => "jilid_hardcover"
        ],
        [
            "id_pesanan" => "ORD-20260929-103",
            "tanggal_pesan" => "2026-09-29 16:00:00",
            "status_pesanan" => "Selesai",
            "pelanggan" => ["id_user" => 1, "nama_pemesan" => "cacaccca"],
            "file_pesanan" => ["nama_file" => "BROSUR_SEMINAR.pdf", "url_file" => ensureFileExists("BROSUR_SEMINAR.pdf")],
            "detail_layanan" => ["jenis_print" => "Print Brosur / Flier", "ukuran_kertas" => "Photo Glossy 210gr", "jenis_warna" => "Full Color", "jenis_jilid" => "Tanpa Jilid"],
            "detail_jumlah" => ["jumlah_halaman" => 5, "jumlah_copy" => 50, "total_lembar" => 250],
            "rincian_harga" => ["subtotal_cetak" => "Rp 1.175.000", "subtotal_jilid" => "Rp 0", "grand_total" => "Rp 1.175.000"],
            "raw_jilid" => "tanpa_jilid"
        ]
    ];

    $daftar_pesanan = array_filter($dummy_data, function($item) use ($search, $status_filter, $jilid_filter, $user_filter) {
        $matchSearch = empty($search) || 
                       stripos($item['id_pesanan'], $search) !== false || 
                       stripos($item['pelanggan']['nama_pemesan'], $search) !== false || 
                       stripos($item['file_pesanan']['nama_file'], $search) !== false;

        $matchStatus = empty($status_filter) || $item['status_pesanan'] === $status_filter;
        $matchJilid  = empty($jilid_filter) || ($item['raw_jilid'] ?? '') === $jilid_filter;
        $matchUser   = empty($user_filter) || intval($item['pelanggan']['id_user']) === intval($user_filter);

        return $matchSearch && $matchStatus && $matchJilid && $matchUser;
    });

    $daftar_pesanan = array_values($daftar_pesanan);
}

echo json_encode([
    "status"          => "success",
    "message"         => "Daftar pesanan berhasil dimuat",
    "database_status" => $is_db_active ? "Live Database" : "Mode Simulasi (Dummy Data)",
    "total_data"      => count($daftar_pesanan),
    "filter_aktif"    => [
        "search"  => $search ?: "Semua",
        "status"  => $status_filter ?: "Semua Status",
        "jilid"   => $jilid_filter ?: "Semua Jilid",
        "id_user" => $user_filter ?: "Semua User"
    ],
    "data"            => $daftar_pesanan
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit();
?>