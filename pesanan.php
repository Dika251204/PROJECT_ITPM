<?php

session_start();

include "koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: auth/login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

if (!isset($_GET['id'])) {
    header("Location: user/pesanan.php");
    exit;
}

$id_pesanan = $_GET['id'];

$query = mysqli_query($conn, "
    select
        pesanan.id_pesanan,
        pesanan.tanggal_pesanan,
        pesanan.total_harga,
        pesanan.status
    from pesanan
    where pesanan.id_pesanan = '$id_pesanan'
    and pesanan.id_user = '$id_user'
");

$pesanan = mysqli_fetch_assoc($query);

if (!$pesanan) {
    die("pesanan tidak ditemukan");
}

$detail = mysqli_query($conn, "
    select
        detail_pesanan.jumlah,
        detail_pesanan.harga,
        produk.nama_produk
    from detail_pesanan
    join produk
        on detail_pesanan.id_produk = produk.id_produk
    where detail_pesanan.id_pesanan = '$id_pesanan'
");

?>

<!DOCTYPE html>
<html>

<head>

    <title>pesanan - uinma merch printhub</title>

</head>

<body>

<nav>

    <a href="index.php">home</a> |
    <a href="produk.php">produk</a> |
    <a href="keranjang.php">keranjang</a> |
    <a href="user/pesanan.php">pesanan saya</a> |
    <a href="auth/logout.php">logout</a>

</nav>

<hr>

<h1>detail pesanan</h1>

<p>
    nomor pesanan:
    <?php echo $pesanan['id_pesanan']; ?>
</p>

<p>
    tanggal:
    <?php echo $pesanan['tanggal_pesanan']; ?>
</p>

<p>
    status:
    <strong>
        <?php echo $pesanan['status']; ?>
    </strong>
</p>

<hr>

<h2>detail pesanan</h2>

<?php while ($item = mysqli_fetch_assoc($detail)) { ?>

    <?php

    $subtotal = $item['harga'] * $item['jumlah'];

    ?>

    <h3>
        <?php echo $item['nama_produk']; ?>
    </h3>

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

    total:
    rp <?php echo number_format($pesanan['total_harga'], 0, ',', '.'); ?>

</h2>

<br>

<a href="produk.php">
    kembali belanja
</a>

<br><br>

<a href="user/pesanan.php">
    lihat pesanan saya
</a>

<?php if ($pesanan['status'] == 'menunggu') { ?>

    <br><br>

    <a href="pembayaran.php?id=<?php echo $pesanan['id_pesanan']; ?>">
        lakukan pembayaran
    </a>

<?php } ?>

</body>

</html>