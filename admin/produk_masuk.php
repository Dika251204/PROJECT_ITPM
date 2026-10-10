<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$query = mysqli_query($conn, "
    SELECT produk.*, users.nama AS nama_penjual,
           kategori.nama_kategori
    FROM produk
    LEFT JOIN users ON produk.id_penjual = users.id_user
    LEFT JOIN kategori ON produk.id_kategori = kategori.id_kategori
    WHERE produk.status = 'menunggu'
    ORDER BY produk.id_produk DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Persetujuan Produk</title>
</head>
<body>

<h2>Persetujuan Produk Penjual</h2>

<a href="index.php">Kembali ke Dashboard</a>

<br><br>

<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Gambar</th>
        <th>Nama Produk</th>
        <th>Penjual</th>
        <th>Kategori</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Aksi</th>
    </tr>

    <?php
    $no = 1;

    if (mysqli_num_rows($query) > 0) {
        while ($produk = mysqli_fetch_assoc($query)) {
    ?>
    <tr>
        <td><?= $no++ ?></td>

        <td>
            <?php if (!empty($produk['gambar'])) { ?>
                <img src="../uploads/produk/<?= htmlspecialchars(basename($produk['gambar'])) ?>"
                     width="80" alt="Foto produk">
            <?php } else { ?>
                Tidak ada gambar
            <?php } ?>
        </td>

        <td><?= htmlspecialchars($produk['nama_produk']) ?></td>
        <td><?= htmlspecialchars($produk['nama_penjual'] ?? '-') ?></td>
        <td><?= htmlspecialchars($produk['nama_kategori'] ?? '-') ?></td>
        <td>Rp<?= number_format($produk['harga'], 0, ',', '.') ?></td>
        <td><?= (int) $produk['stok'] ?></td>

        <td>
            <a href="proses_persetujuan.php?id=<?= $produk['id_produk'] ?>&aksi=setuju"
               onclick="return confirm('Setujui produk ini?')">
                Setujui
            </a>
            |
            <a href="proses_persetujuan.php?id=<?= $produk['id_produk'] ?>&aksi=tolak"
               onclick="return confirm('Tolak produk ini?')">
                Tolak
            </a>
        </td>
    </tr>
    <?php
        }
    } else {
    ?>
    <tr>
        <td colspan="8">Tidak ada produk yang menunggu persetujuan.</td>
    </tr>
    <?php } ?>
</table>

</body>
</html>