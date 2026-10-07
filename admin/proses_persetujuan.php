<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

if (!isset($_GET['id'], $_GET['aksi'])) {
    header("Location: produk_masuk.php");
    exit;
}

$id_produk = (int) $_GET['id'];
$aksi = $_GET['aksi'];

if ($aksi == 'setuju') {
    $status = 'disetujui';
} elseif ($aksi == 'tolak') {
    $status = 'ditolak';
} else {
    die("Aksi tidak valid.");
}

$stmt = mysqli_prepare(
    $conn,
    "UPDATE produk SET status = ?
     WHERE id_produk = ? AND status = 'menunggu'"
);

mysqli_stmt_bind_param($stmt, "si", $status, $id_produk);

if (mysqli_stmt_execute($stmt)) {
    echo "<script>
        alert('Status produk berhasil diperbarui!');
        window.location.href = 'produk_masuk.php';
    </script>";
} else {
    echo "Gagal memperbarui status produk.";
}
?>