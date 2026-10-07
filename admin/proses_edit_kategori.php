<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    die("Akses ditolak!");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int) $_POST['id_kategori'];
    $nama = trim($_POST['nama_kategori']);

    if ($id <= 0 || $nama == "") {
        die("Data kategori tidak valid!");
    }

    $stmt = mysqli_prepare(
        $conn,
        "UPDATE kategori SET nama_kategori = ? WHERE id_kategori = ?"
    );

    mysqli_stmt_bind_param($stmt, "si", $nama, $id);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: kategori.php");
        exit;
    } else {
        echo "Gagal mengubah kategori: " . mysqli_error($conn);
    }
}
?>