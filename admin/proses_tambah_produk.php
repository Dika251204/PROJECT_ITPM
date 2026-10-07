<?php

session_start();

include "../koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SESSION['role'] != 'admin') {
    echo "akses ditolak";
    exit;
}

// cek data produk
if (
    !isset($_POST['id_kategori']) ||
    !isset($_POST['nama_produk']) ||
    !isset($_POST['deskripsi']) ||
    !isset($_POST['harga']) ||
    !isset($_POST['stok'])
) {
    die("data produk belum lengkap");
}

// ambil data produk
$id_kategori = $_POST['id_kategori'];
$nama_produk = $_POST['nama_produk'];
$deskripsi = $_POST['deskripsi'];
$harga = $_POST['harga'];
$stok = $_POST['stok'];

// cek gambar
if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] != 0) {
    die("gambar wajib diunggah");
}

$gambar = $_FILES['gambar'];

// validasi gambar
$info_gambar = getimagesize($gambar['tmp_name']);

if ($info_gambar === false) {
    die("file yang diunggah bukan gambar");
}

// cek ukuran maksimal 2 mb
if ($gambar['size'] > 2 * 1024 * 1024) {
    die("ukuran gambar maksimal 2 mb");
}

// tentukan ekstensi gambar
$tipe_gambar = [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'image/webp' => 'webp'
];

$mime = $info_gambar['mime'];

if (!isset($tipe_gambar[$mime])) {
    die("format gambar harus jpg, png, atau webp");
}

$ekstensi = $tipe_gambar[$mime];

// buat nama file unik
$nama_file = uniqid('produk_') . '.' . $ekstensi;

// lokasi penyimpanan gambar
$folder = "../uploads/produk/";

// buat folder jika belum ada
if (!is_dir($folder)) {
    mkdir($folder, 0755, true);
}

// pindahkan gambar
$lokasi_gambar = $folder . $nama_file;

if (!move_uploaded_file($gambar['tmp_name'], $lokasi_gambar)) {
    die("gambar gagal diunggah");
}

// simpan data ke database
$query = mysqli_prepare($conn, "
    insert into produk
    (
        id_kategori,
        nama_produk,
        deskripsi,
        harga,
        stok,
        gambar
    )
    values (?, ?, ?, ?, ?, ?)
");

mysqli_stmt_bind_param(
    $query,
    "issdis",
    $id_kategori,
    $nama_produk,
    $deskripsi,
    $harga,
    $stok,
    $nama_file
);

if (!mysqli_stmt_execute($query)) {
    unlink($lokasi_gambar);
    die("produk gagal ditambahkan: " . mysqli_error($conn));
}

header("Location: produk.php");
exit;

?>