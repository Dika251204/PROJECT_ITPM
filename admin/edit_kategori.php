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

$stmt = mysqli_prepare($conn, "SELECT * FROM kategori WHERE id_kategori = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$kategori = mysqli_fetch_assoc($result);

if (!$kategori) {
    die("Kategori tidak ditemukan!");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kategori</title>
</head>
<body>

<h2>Edit Kategori</h2>

<form action="proses_edit_kategori.php" method="POST">
    <input type="hidden" name="id_kategori"
           value="<?= $kategori['id_kategori']; ?>">

    <label>Nama Kategori:</label><br>
    <input type="text" name="nama_kategori"
           value="<?= htmlspecialchars($kategori['nama_kategori']); ?>"
           required>

    <br><br>
    <button type="submit">Simpan Perubahan</button>
</form>

<br>
<a href="kategori.php">Kembali</a>

</body>
</html>