<?php

session_start();

include "koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: auth/login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

$query = mysqli_query($conn, "
    select
        keranjang.id_keranjang,
        produk.nama_produk,
        produk.harga,
        produk.stok,
        keranjang.jumlah
    from keranjang
    join produk
        on keranjang.id_produk = produk.id_produk
    where keranjang.id_user = '$id_user'
    order by keranjang.id_keranjang desc
");

?>

<!DOCTYPE html>
<html>
<head>
    <title>keranjang - uinma merch printhub</title>
</head>
<body>

<nav>
    <a href="index.php">home</a> |
    <a href="produk.php">produk</a> |
    <a href="keranjang.php">keranjang</a> |
    <a href="auth/logout.php">logout</a>
</nav>

<hr>

<h1>keranjang belanja</h1>

<p>
    selamat datang, <?php echo $_SESSION['nama']; ?>
</p>

<?php if (mysqli_num_rows($query) == 0) { ?>

    <p>keranjang masih kosong.</p>

    <a href="produk.php">lihat produk</a>

<?php } else { ?>

    <?php $total = 0; ?>

    <?php while ($item = mysqli_fetch_assoc($query)) { ?>

        <?php
        $subtotal = $item['harga'] * $item['jumlah'];
        $total = $total + $subtotal;
        ?>

        <div>

            <h3>
                <?php echo $item['nama_produk']; ?>
            </h3>

            <p>
                harga:
                rp <?php echo number_format($item['harga'], 0, ',', '.'); ?>
            </p>

            <p>
                jumlah:
            </p>

            <a href="update_keranjang.php?id=<?php echo $item['id_keranjang']; ?>&aksi=kurang">
                -
            </a>

            <?php echo $item['jumlah']; ?>

            <a href="update_keranjang.php?id=<?php echo $item['id_keranjang']; ?>&aksi=tambah">
                +
            </a>

            <p>
                subtotal:
                rp <?php echo number_format($subtotal, 0, ',', '.'); ?>
            </p>

            <a href="hapus_keranjang.php?id=<?php echo $item['id_keranjang']; ?>">
                hapus
            </a>

        </div>

        <hr>

    <?php } ?>

    <h2>
        total:
        rp <?php echo number_format($total, 0, ',', '.'); ?>
    </h2>

    <br>

    <a href="checkout.php">
        checkout
    </a>

<?php } ?>

</body>
</html>