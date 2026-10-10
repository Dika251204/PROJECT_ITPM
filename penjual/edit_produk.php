<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'penjual') {
    header("Location: ../auth/login.php");
    exit;
}

$id_produk = (int) $_GET['id'];
$id_penjual = $_SESSION['id_user'];

$stmt = mysqli_prepare($conn, 
    "SELECT * FROM produk 
     WHERE id_produk = ? AND id_penjual = ?"
);

mysqli_stmt_bind_param($stmt, "ii", $id_produk, $id_penjual);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$produk = mysqli_fetch_assoc($result);

if (!$produk) {
    die("Produk tidak ditemukan.");
}

$kategori = mysqli_query($conn, "SELECT * FROM kategori");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Produk</title>
</head>
<body>

<h2>Edit Produk</h2>

<form action="proses_edit_produk.php" method="POST"
      enctype="multipart/form-data">

    <input type="hidden" name="id_produk"
           value="<?= $produk['id_produk'] ?>">

    <label>Nama Produk</label><br>
    <input type="text" name="nama_produk"
           value="<?= htmlspecialchars($produk['nama_produk']) ?>" required>
    <br><br>

    <label>Kategori</label><br>
    <select name="id_kategori" required>
        <?php while ($k = mysqli_fetch_assoc($kategori)) { ?>
            <option value="<?= $k['id_kategori'] ?>"
                <?= $k['id_kategori'] == $produk['id_kategori'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($k['nama_kategori']) ?>
            </option>
        <?php } ?>
    </select>
    <br><br>

    <label>Deskripsi</label><br>
    <textarea name="deskripsi" rows="5"><?= htmlspecialchars($produk['deskripsi'] ?? '') ?></textarea>
    <br><br>

    <label>Harga</label><br>
    <input type="number" name="harga" min="0"
           value="<?= $produk['harga'] ?>" required>
    <br><br>

    <label>Stok</label><br>
    <input type="number" name="stok" min="0"
           value="<?= $produk['stok'] ?>" required>
    <br><br>

    <label>Foto Produk Saat Ini</label><br>

    <?php if (!empty($produk['gambar'])) { ?>
        <img src="../uploads/produk/<?= htmlspecialchars(basename($produk['gambar'])) ?>"
             width="100" alt="Foto produk">
    <?php } else { ?>
        Belum ada foto
    <?php } ?>

    <br><br>

    <label>Ganti Foto (Opsional)</label><br>
    <input type="file" name="gambar"
           accept="image/jpeg,image/png,image/webp">
    <br><br>

    <button type="submit">Simpan Perubahan</button>
</form>

<br>
<a href="produk.php">Kembali</a>

</body>
</html>