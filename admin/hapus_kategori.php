<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    die("Akses ditolak!");
}

if (!isset($_GET['id'])) {
    die("ID kategori tidak ditemukan!");
}

$id = (int) $_GET['id'];

if ($id <= 0) {
    die("ID kategori tidak valid!");
}

$stmt = mysqli_prepare(
    $conn,
    "DELETE FROM kategori WHERE id_kategori = ?"
);

mysqli_stmt_bind_param($stmt, "i", $id);

if (mysqli_stmt_execute($stmt)) {
    header("Location: kategori.php");
    exit;
} else {
    echo "Gagal menghapus kategori. Pastikan kategori tidak sedang digunakan oleh produk.";
}
?>