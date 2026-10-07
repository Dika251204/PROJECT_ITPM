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

if (
    !isset($_POST['id_produk']) ||
    !isset($_POST['id_kategori']) ||
    !isset($_POST['nama_produk']) ||
    !isset($_POST['deskripsi']) ||
    !isset($_POST['harga']) ||
    !isset($_POST['stok'])
) {
    die("data produk belum lengkap");
}

$id_produk = $_POST['id_produk'];
$id_kategori = $_POST['id_kategori'];
$nama_produk = $_POST['nama_produk'];
$deskripsi = $_POST['deskripsi'];
$harga = $_POST['harga'];
$stok = $_POST['stok'];

$gambar = "";

if (isset($_POST['gambar'])) {
    $gambar = $_POST['gambar'];
}

$query = mysqli_query($conn, "
    update produk
    set
        id_kategori = '$id_kategori',
        nama_produk = '$nama_produk',
        deskripsi = '$deskripsi',
        harga = '$harga',
        stok = '$stok',
        gambar = '$gambar'
    where id_produk = '$id_produk'
");

if (!$query) {
    die("produk gagal diubah: " . mysqli_error($conn));
}

header("Location: produk.php");
exit;

?>