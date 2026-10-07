<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SESSION['role'] != 'penjual') {
    die("Akses ditolak");
}

$id_penjual = $_SESSION['id_user'];

$query = mysqli_prepare($conn, 
    "SELECT * FROM produk 
     WHERE id_penjual = ? 
     ORDER BY id_produk DESC"
);

mysqli_stmt_bind_param($query, "i", $id_penjual);
mysqli_stmt_execute($query);

$result = mysqli_stmt_get_result($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Produk Saya</title>
</head>
<body>

<h2>Daftar Produk Saya</h2>

<a href="index.php">Dashboard</a> |
<a href="tambah_produk.php">Tambah Produk</a>

<br><br>

<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Gambar</th>
        <th>Nama Produk</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    <?php
    $no = 1;

    if (mysqli_num_rows($result) > 0) {
        while ($produk = mysqli_fetch_assoc($result)) {
            
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

        <td>Rp<?= number_format($produk['harga'], 0, ',', '.') ?></td>

        <td><?= $produk['stok'] ?></td>

        <td><?= htmlspecialchars($produk['status']) ?></td>
        <td>
    <a href="edit_produk.php?id=<?= $produk['id_produk'] ?>">
        Edit
    </a>

    |

    <a href="hapus_produk.php?id=<?= $produk['id_produk'] ?>"
       onclick="return confirm('Yakin ingin menghapus produk ini?')">
        Hapus
    </a>
</td>
    </tr>

    <?php
        }
    } else {
    ?>
        <tr>
            <td colspan="6">Belum ada produk.</td>
        </tr>
    <?php } ?>
</table>

</body>
</html>