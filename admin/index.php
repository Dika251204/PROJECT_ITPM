<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SESSION['role'] != 'admin') {
    die("akses ditolak");
}

// menghitung data
$total_produk = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM produk")
)['total'];

$total_kategori = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM kategori")
)['total'];

$total_pengguna = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM users")
)['total'];

$total_penjual = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM users WHERE role = 'penjual'")
)['total'];

$produk_menunggu = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT COUNT(*) AS total FROM produk WHERE status = 'menunggu'")
)['total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - UINMA Merch PrintHub</title>
</head>

<body>

<nav>
    <a href="index.php">dashboard</a> |
    <a href="pesanan.php">pesanan</a> |
    <a href="produk.php">produk</a> |
    <a href="kategori.php">kategori</a> |
    <a href="produk_masuk.php">produk masuk</a> |
    <a href="../index.php">lihat website</a> |
    <a href="../auth/logout.php">logout</a>
</nav>

<hr>

<h1>Dashboard Admin</h1>

<p>
    Selamat datang,
    <?= htmlspecialchars($_SESSION['nama']); ?>
</p>

<hr>

<h2>Statistik Website</h2>

<table border="1" cellpadding="15" cellspacing="0">
    <tr>
        <th>Total Produk</th>
        <th>Total Kategori</th>
        <th>Total Pengguna</th>
        <th>Total Penjual</th>
        <th>Produk Menunggu</th>
    </tr>

    <tr>
        <td><?= $total_produk; ?></td>
        <td><?= $total_kategori; ?></td>
        <td><?= $total_pengguna; ?></td>
        <td><?= $total_penjual; ?></td>
        <td><?= $produk_menunggu; ?></td>
    </tr>
</table>

<hr>

<h2>Menu Admin</h2>

<ul>
    <li><a href="pesanan.php">Kelola Pesanan</a></li>
    <li><a href="produk.php">Kelola Produk</a></li>
    <li><a href="produk_masuk.php">Persetujuan Produk</a></li>
    <li><a href="kategori.php">Kelola Kategori</a></li>
    <li><a href="../index.php">Lihat Website</a></li>
    <li><a href="../auth/logout.php">Logout</a></li>
</ul>

</body>
</html>