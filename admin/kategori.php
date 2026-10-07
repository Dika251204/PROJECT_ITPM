<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    die("Akses ditolak!");
}

$query = mysqli_query($conn, "SELECT * FROM kategori ORDER BY id_kategori DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Kategori</title>
</head>
<body>

<h2>Kelola Kategori Produk</h2>

<a href="index.php">Kembali ke Dashboard</a>

<hr>

<h3>Tambah Kategori</h3>

<form action="proses_kategori.php" method="POST">
    <label>Nama Kategori:</label><br>
    <input type="text" name="nama_kategori" required>
    <button type="submit" name="tambah">Tambah</button>
</form>

<hr>

<h3>Daftar Kategori</h3>

<table border="1" cellpadding="10" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Nama Kategori</th>
        <th>Aksi</th>
    </tr>

    <?php
    $no = 1;
    while ($kategori = mysqli_fetch_assoc($query)) {
    ?>
    <tr>
        <td><?= $no++; ?></td>
        <td><?= htmlspecialchars($kategori['nama_kategori']); ?></td>
        <td>
            <a href="edit_kategori.php?id=<?= $kategori['id_kategori']; ?>">Edit</a>
            |
            <a href="hapus_kategori.php?id=<?= $kategori['id_kategori']; ?>"
               onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                Hapus
            </a>
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>