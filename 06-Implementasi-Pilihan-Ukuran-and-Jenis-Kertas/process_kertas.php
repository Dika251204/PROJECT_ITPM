<?php
// 06-Implementasi-Pilihan-Ukuran-dan-Jenis-Kertas/process_kertas.php

require_once __DIR__ . '/config/db.php';

header("Content-Type: application/json; charset=UTF-8");

// Response jika diakses via GET (Menampilkan pilihan ukuran & jenis kertas)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {$data_kertas = [
        ["kode" => "A4 70gr", "ukuran" => "A4", "jenis" => "70gr", "harga_per_lembar" => 500],
        ["kode" => "A4 80gr", "ukuran" => "A4", "jenis" => "80gr", "harga_per_lembar" => 600],
        ["kode" => "F4 70gr", "ukuran" => "F4", "jenis" => "70gr", "harga_per_lembar" => 600],
        ["kode" => "A3 80gr", "ukuran" => "A3", "jenis" => "80gr", "harga_per_lembar" => 1200]
    ];
    echo json_encode([
        "status" => "success",
        "message" => "Daftar pilihan ukuran & jenis kertas berhasil dimuat.",
        "data" => $data_kertas
    ], JSON_PRETTY_PRINT);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("HTTP/1.1 405 Method Not Allowed");
    echo json_encode(["status" => "error", "message" => "Metode request harus POST."]);
    exit();
}

// Checklist 1-5: Konfigurasi Ukuran (A4, A3, F4), Jenis Kertas (70gr/80gr), & Tarif
$tarifKertas = [
    'A4 70gr' => 500,
    'A4 80gr' => 600,
    'F4 70gr' => 600,
    'A3 80gr' => 1200
];

// Pengambilan Data Form Input
$ukuran_kertas  = $_POST['ukuran_kertas'] ?? '';$jenis_print    = $_POST['jenis_print'] ?? 'hitam_putih';$id_user        = isset($_POST['id_user']) ? intval($_POST['id_user']) : 2;
$jumlah_halaman = isset($_POST['jumlah_halaman']) ? intval($_POST['jumlah_halaman']) : 1;
$jumlah_copy    = isset($_POST['jumlah_copy']) ? intval($_POST['jumlah_copy']) : 1;
$jenis_jilid    =$_POST['jenis_jilid'] ?? 'Tanpa Jilid';
$catatan        =$_POST['catatan'] ?? '';

// Validasi Pilihan Kertas
if (!array_key_exists($ukuran_kertas,$tarifKertas)) {
    header("HTTP/1.1 200 OK");
    echo json_encode([
        "status" => "error",
        "message" => "Validasi Gagal: Pilihan kertas '$ukuran_kertas' tidak tersedia!"
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

// Perhitungan Harga Subtotal Kertas & Total
$harga_kertas_per_lbr = $tarifKertas[$ukuran_kertas];
$subtotal_kertas      =$harga_kertas_per_lbr * $jumlah_halaman * $jumlah_copy;

$total_harga = isset($_POST['total_harga']) && floatval($_POST['total_harga']) > 0 
               ? floatval($_POST['total_harga']) 
               : $subtotal_kertas;

$nama_file = "dokumen_kertas_" . preg_replace("/[^a-zA-Z0-9]/", "_", $ukuran_kertas) . ".pdf";
$file_path = "uploads/" . $nama_file;

// Checklist 8 & 9: Menyimpan Pilihan & Menghubungkan ke Pesanan (`print_jilid`)
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
            "message" => "Pilihan ukuran & jenis kertas berhasil disimpan dan terhubung ke pesanan!",
            "data_pesanan" => [
                "id_print"           => $db->lastInsertId(),
                "ukuran_kertas"      => $ukuran_kertas,
                "harga_per_lembar"   => "Rp " . number_format($harga_kertas_per_lbr, 0, ',', '.'),
                "jumlah_halaman"     => $jumlah_halaman,
                "jumlah_copy"        => $jumlah_copy,
                "subtotal_kertas"    => "Rp " . number_format($subtotal_kertas, 0, ',', '.'),
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
echo json_encode(["status" => "success", "message" => "Kertas terproses (Tanpa DB)"], JSON_PRETTY_PRINT);
exit();
?>