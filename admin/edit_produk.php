<?php

session_start();

include "../koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SESSION['role'] != 'admin') {
    echo "akses ditolak";
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: produk.php");
    exit;
}

$id_produk = $_GET['id'];

$query = mysqli_query($conn, "
    select *
    from produk
    where id_produk = '$id_produk'
");

$produk = mysqli_fetch_assoc($query);

if (!$produk) {
    die("produk tidak ditemukan");
}

$query_kategori = mysqli_query($conn, "
    select *
    from kategori
    order by nama_kategori asc
");

?>

<!DOCTYPE html>
<html>

<head>

    <title>edit produk - uinma merch printhub</title>

</head>

<body>

<nav>

    <a href="index.php">dashboard</a> |
    <a href="pesanan.php">pesanan</a> |
    <a href="produk.php">produk</a> |
    <a href="../auth/logout.php">logout</a>

</nav>

<hr>

<h1>edit produk</h1>

<form action="proses_edit_produk.php" method="post">

    <input
        type="hidden"
        name="id_produk"
        value="<?php echo $produk['id_produk']; ?>"
    >

    <label>kategori</label>

    <br>

    <select name="id_kategori" required>

        <?php while ($kategori = mysqli_fetch_assoc($query_kategori)) { ?>

            <option
                value="<?php echo $kategori['id_kategori']; ?>"
                <?php
                if ($kategori['id_kategori'] == $produk['id_kategori']) {
                    echo "selected";
                }
                ?>
            >
                <?php echo $kategori['nama_kategori']; ?>
            </option>

        <?php } ?>

    </select>

    <br><br>

    <label>nama produk</label>

    <br>

    <input
        type="text"
        name="nama_produk"
        value="<?php echo $produk['nama_produk']; ?>"
        required
    >

    <br><br>

    <label>deskripsi</label>

    <br>

    <textarea
        name="deskripsi"
        rows="5"
        cols="40"
    ><?php echo $produk['deskripsi']; ?></textarea>

    <br><br>

    <label>harga</label>

    <br>

    <input
        type="number"
        name="harga"
        min="0"
        value="<?php echo $produk['harga']; ?>"
        required
    >

    <br><br>

    <label>stok</label>

    <br>

    <input
        type="number"
        name="stok"
        min="0"
        value="<?php echo $produk['stok']; ?>"
        required
    >

    <br><br>

    <label>nama file gambar</label>

    <br>

    <input
        type="text"
        name="gambar"
        value="<?php echo $produk['gambar']; ?>"
    >

    <br><br>

    <button type="submit">
        simpan perubahan
    </button>

</form>

<br>

<a href="produk.php">
    kembali ke produk
</a>

</body>

</html>