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
        keranjang.id_produk,
        keranjang.jumlah,
        produk.nama_produk,
        produk.harga,
        produk.stok
    from keranjang
    join produk
        on keranjang.id_produk = produk.id_produk
    where keranjang.id_user = '$id_user'
");

if (mysqli_num_rows($query) == 0) {
    die("keranjang masih kosong");
}

$total = 0;

$data_keranjang = [];

while ($item = mysqli_fetch_assoc($query)) {

    $subtotal = $item['harga'] * $item['jumlah'];

    $total = $total + $subtotal;

    $data_keranjang[] = $item;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>checkout - uinma merch printhub</title>
</head>
<body>

<nav>
    <a href="index.php">home</a> |
    <a href="produk.php">produk</a> |
    <a href="keranjang.php">keranjang</a> |
    <a href="auth/logout.php">logout</a>
</nav>

<hr>

<h1>checkout</h1>

<p>
    nama:
    <?php echo $_SESSION['nama']; ?>
</p>

<hr>

<h2>pesanan</h2>

<?php foreach ($data_keranjang as $item) { ?>

    <?php
    $subtotal = $item['harga'] * $item['jumlah'];
    ?>

    <p>
        <strong>
            <?php echo $item['nama_produk']; ?>
        </strong>
    </p>

    <p>
        jumlah:
        <?php echo $item['jumlah']; ?>
    </p>

    <p>
        harga:
        rp <?php echo number_format($item['harga'], 0, ',', '.'); ?>
    </p>

    <p>
        subtotal:
        rp <?php echo number_format($subtotal, 0, ',', '.'); ?>
    </p>

    <hr>

<?php } ?>

<h2>
    total pembayaran:
    rp <?php echo number_format($total, 0, ',', '.'); ?>
</h2>

<br>

<form action="proses_checkout.php" method="post">

    <input
        type="hidden"
        name="total_harga"
        value="<?php echo $total; ?>"
    >

    <button type="submit">
        buat pesanan
    </button>

</form>

<br>

<a href="keranjang.php">
    kembali ke keranjang
</a>

</body>
</html>