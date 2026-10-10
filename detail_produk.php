<?php

include "koneksi.php";

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("id produk tidak valid");
}

$id = (int) $_GET['id'];

$query = mysqli_prepare($conn, "
    select * from produk
    where id_produk = ?
");

mysqli_stmt_bind_param($query, "i", $id);
mysqli_stmt_execute($query);

$hasil = mysqli_stmt_get_result($query);
$produk = mysqli_fetch_assoc($hasil);

if (!$produk) {
    die("produk tidak ditemukan");
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>detail produk - uinma merch printhub</title>
</head>
<body>

<nav>
    <a href="index.php">home</a> |
    <a href="produk.php">produk</a> |
    <a href="keranjang.php">keranjang</a> |
    <a href="auth/login.php">login</a>
</nav>

<hr>

<h1>detail produk</h1>

<h2>
    <?php echo htmlspecialchars($produk['nama_produk']); ?>
</h2>

<?php if (!empty($produk['gambar'])) { ?>

    <img
        src="uploads/produk/<?php echo rawurlencode(basename($produk['gambar'])); ?>"
        alt="<?php echo htmlspecialchars($produk['nama_produk']); ?>"
        width="300"
        height="300"
        style="object-fit: contain;"
    >

<?php } else { ?>

    <p>gambar produk belum tersedia</p>

<?php } ?>

<p>
    <?php echo nl2br(htmlspecialchars($produk['deskripsi'])); ?>
</p>

<p>
    harga:
    rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?>
</p>

<p>
    stok:
    <?php echo (int) $produk['stok']; ?>
</p>

<br>

<?php if ($produk['stok'] > 0) { ?>

    <a href="tambah_keranjang.php?id=<?php echo (int) $produk['id_produk']; ?>">
        tambah ke keranjang
    </a>

<?php } else { ?>

    <p>stok habis</p>

<?php } ?>

<br><br>

<a href="produk.php">kembali ke produk</a>

</body>
</html>