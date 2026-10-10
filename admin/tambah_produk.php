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

$query_kategori = mysqli_query($conn, "
    select *
    from kategori
    order by nama_kategori asc
");

?>

<!DOCTYPE html>
<html>

<head>
    <title>tambah produk - uinma merch printhub</title>
</head>

<body>

<nav>
    <a href="index.php">dashboard</a> |
    <a href="pesanan.php">pesanan</a> |
    <a href="produk.php">produk</a> |
    <a href="../auth/logout.php">logout</a>
</nav>

<hr>

<h1>tambah produk</h1>

<form action="proses_tambah_produk.php" method="post" enctype="multipart/form-data">

    <label>kategori</label>
    <br>

    <select name="id_kategori" required>
        <option value="">-- pilih kategori --</option>

        <?php while ($kategori = mysqli_fetch_assoc($query_kategori)) { ?>

            <option value="<?php echo $kategori['id_kategori']; ?>">
                <?php echo $kategori['nama_kategori']; ?>
            </option>

        <?php } ?>

    </select>

    <br><br>

    <label>nama produk</label>
    <br>

    <input type="text" name="nama_produk" required>

    <br><br>

    <label>deskripsi</label>
    <br>

    <textarea name="deskripsi" rows="5" cols="40"></textarea>

    <br><br>

    <label>harga</label>
    <br>

    <input type="number" name="harga" min="0" required>

    <br><br>

    <label>stok</label>
    <br>

    <input type="number" name="stok" min="0" required>

    <br><br>

    <label>gambar produk</label>
    <br>

    <input
        type="file"
        name="gambar"
        accept="image/*"
        required
    >

    <br><br>

    <button type="submit">
        simpan produk
    </button>

</form>

<br>

<a href="produk.php">kembali ke produk</a>

</body>
</html>