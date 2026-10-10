<?php
session_start();
include "../koneksi.php";

// cek login
if (!isset($_SESSION['id_user'])) {
    header("Location: ../auth/login.php");
    exit;
}

// cek role penjual
if ($_SESSION['role'] != 'penjual') {
    echo "Akses ditolak";
    exit;
}

// ambil kategori
$query = mysqli_query($conn, "SELECT * FROM kategori ORDER BY nama_kategori");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Produk</title>
</head>
<body>

    <h2>Tambah Produk</h2>

    <form action="proses_tambah_produk.php" method="POST"
          enctype="multipart/form-data">

        <label>Nama Produk</label><br>
        <input type="text" name="nama_produk" required>
        <br><br>

        <label>Kategori</label><br>
        <select name="id_kategori" required>
            <option value="">-- Pilih Kategori --</option>

            <?php while ($kategori = mysqli_fetch_assoc($query)) { ?>
                <option value="<?= $kategori['id_kategori'] ?>">
                    <?= htmlspecialchars($kategori['nama_kategori']) ?>
                </option>
            <?php } ?>
        </select>
        <br><br>

        <label>Deskripsi</label><br>
        <textarea name="deskripsi" rows="5"></textarea>
        <br><br>

        <label>Harga</label><br>
        <input type="number" name="harga" min="0"
               step="0.01" required>
        <br><br>

        <label>Stok</label><br>
        <input type="number" name="stok" min="0" required>
        <br><br>

        <label>Foto Produk</label><br>
        <input type="file" name="gambar"
               accept="image/jpeg,image/png,image/webp" required>
        <br><br>

        <button type="submit">Simpan Produk</button>

    </form>

    <br>
    <a href="index.php">Kembali ke Dashboard</a>

</body>
</html>