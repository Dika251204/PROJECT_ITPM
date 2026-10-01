<?php

if (ob_get_length()) ob_clean();

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");

// Ambil input
$id_pesanan  = $_POST['id_pesanan'] ?? 'ORD-8821';
$id_user     = $_POST['id_user'] ?? 1;
$kode_jilid  = $_POST['jenis_jilid'] ?? 'jilid_softcover';
$jumlah_copy = isset($_POST['jumlah_copy']) ? intval($_POST['jumlah_copy']) : 1;

// Master Data Jilid
$master_jilid = [
    "tanpa_jilid" => [
        "nama"  => "Tanpa Jilid",
        "harga" => 0,
        "desc"  => "Hanya dicetak biasa tanpa finishing jilid"
    ],
    "jilid_spiral_kawat" => [
        "nama"  => "Jilid Spiral Kawat",
        "harga" => 12000,
        "desc"  => "Menggunakan ring kawat fleksibel dan rapi"
    ],
    "jilid_spiral_plastik" => [
        "nama"  => "Jilid Spiral Plastik",
        "harga" => 10000,
        "desc"  => "Menggunakan ring plastik ekonomis"
    ],
    "jilid_lakban" => [
        "nama"  => "Jilid Lakban (Biasa)",
        "harga" => 5000,
        "desc"  => "Jilid mika + mika depan transparan & lakban hitam"
    ],
    "jilid_softcover" => [
        "nama"  => "Jilid Softcover / Lem Panas",
        "harga" => 15000,
        "desc"  => "Cover tipis dilaminasi lem panas"
    ],
    "jilid_hardcover" => [
        "nama"  => "Jilid Hardcover / Skripsi",
        "harga" => 30000,
        "desc"  => "Cover tebal karton premium (Standar Skripsi/Tugas Akhir)"
    ]
];

// Validasi
if (!isset($master_jilid[$kode_jilid])) {
    echo json_encode([
        "status" => "error",
        "message" => "Pilihan jenis jilid tidak ditemukan."
    ]);
    exit();
}

$jilid = $master_jilid[$kode_jilid];
$biaya_satuan = $jilid['harga'];
$total_biaya  = $biaya_satuan * $jumlah_copy;

// Response JSON
echo json_encode([
    "status" => "success",
    "message" => "Pilihan jenis jilid berhasil diproses!",
    "data_jilid" => [
        "id_pesanan"        => $id_pesanan,
        "id_user"           => $id_user,
        "kode_jilid"        => $kode_jilid,
        "nama_jilid"        => $jilid['nama'],
        "keterangan"        => $jilid['desc'],
        "biaya_per_jilid"   => $biaya_satuan,
        "jumlah_copy"       => $jumlah_copy,
        "total_biaya_jilid" => $total_biaya,
        "formatted_biaya"   => "Rp " . number_format($total_biaya, 0, ',', '.')
    ]
], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
exit();