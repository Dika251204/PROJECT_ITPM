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

if (!isset($_POST['id_pesanan']) || !isset($_POST['status'])) {
    header("Location: pesanan.php");
    exit;
}

$id_pesanan = $_POST['id_pesanan'];
$status = $_POST['status'];

$status_valid = [
    'menunggu',
    'diproses',
    'dikirim',
    'selesai',
    'dibatalkan'
];

if (!in_array($status, $status_valid)) {
    die("status tidak valid");
}

$query = mysqli_query($conn, "
    update pesanan
    set status = '$status'
    where id_pesanan = '$id_pesanan'
");

if (!$query) {
    die("gagal mengubah status: " . mysqli_error($conn));
}

header("Location: detail_pesanan.php?id=$id_pesanan");
exit;

?>