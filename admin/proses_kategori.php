<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    die("Akses ditolak!");
}

if (isset($_POST['tambah'])) {
    $nama_kategori = trim($_POST['nama_kategori']);

    if ($nama_kategori == "") {
        die("Nama kategori tidak boleh kosong!");
    }

    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO kategori (nama_kategori) VALUES (?)"
    );

    mysqli_stmt_bind_param($stmt, "s", $nama_kategori);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: kategori.php");
        exit;
    } else {
        echo "Gagal menambahkan kategori: " . mysqli_error($conn);
    }
}
?>