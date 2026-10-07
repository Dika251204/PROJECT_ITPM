<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'penjual') {
    header("Location: ../auth/login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: produk.php");
    exit;
}

$id_produk = (int) $_GET['id'];
$id_penjual = $_SESSION['id_user'];

// cek kepemilikan produk
$stmt = mysqli_prepare($conn,
    "SELECT gambar FROM produk
     WHERE id_produk = ? AND id_penjual = ?"
);

mysqli_stmt_bind_param($stmt, "ii", $id_produk, $id_penjual);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$produk = mysqli_fetch_assoc($result);

if (!$produk) {
    die("Produk tidak ditemukan.");
}

// hapus produk
$stmt = mysqli_prepare($conn,
    "DELETE FROM produk
     WHERE id_produk = ? AND id_penjual = ?"
);

mysqli_stmt_bind_param($stmt, "ii", $id_produk, $id_penjual);

if (mysqli_stmt_execute($stmt)) {
    if (!empty($produk['gambar'])) {
        $file = "../uploads/produk/" . basename($produk['gambar']);

        if (is_file($file)) {
            unlink($file);
        }
    }

    echo "<script>
        alert('Produk berhasil dihapus!');
        window.location.href = 'produk.php';
    </script>";
} else {
    echo "Gagal menghapus produk. Produk mungkin sudah digunakan dalam pesanan.";
}
?>