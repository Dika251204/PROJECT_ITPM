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

if (!isset($_GET['id'])) {
    header("Location: produk.php");
    exit;
}

$id_produk = $_GET['id'];

$query = mysqli_query($conn, "
    delete from produk
    where id_produk = '$id_produk'
");

if (!$query) {
    die("produk gagal dihapus: " . mysqli_error($conn));
}

header("Location: produk.php");
exit;

?>