<?php

session_start();

include "koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: auth/login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id_pesanan = $_GET['id'];

$query = mysqli_query($conn, "
    select
        pesanan.id_pesanan,
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

?>

<!DOCTYPE html>
<html>

<head>

    <title>pembayaran - uinma merch printhub</title>

</head>

<body>

<nav>

    <a href="index.php">home</a> |
    <a href="produk.php">produk</a> |
    <a href="keranjang.php">keranjang</a> |
    <a href="auth/logout.php">logout</a>

</nav>

<hr>

<h1>pembayaran</h1>

<p>
    nomor pesanan:
    <?php echo $pesanan['id_pesanan']; ?>
</p>

<p>
    total pembayaran:
    rp <?php echo number_format($pesanan['total_harga'], 0, ',', '.'); ?>
</p>

<p>
    status pesanan:
    <?php echo $pesanan['status']; ?>
</p>

<hr>

<h2>pilih metode pembayaran</h2>

<form action="proses_pembayaran.php" method="post" enctype="multipart/form-data">

    <input
        type="hidden"
        name="id_pesanan"
        value="<?php echo $pesanan['id_pesanan']; ?>"
    >

    <label>metode pembayaran</label>

    <br>

    <select name="metode_pembayaran" required>

        <option value="">
            -- pilih pembayaran --
        </option>

        <option value="transfer bank">
            transfer bank
        </option>

        <option value="qris">
            qris
        </option>

        <option value="cash">
            cash
        </option>

    </select>

    <br><br>

    <label>bukti pembayaran</label>

    <br>

    <input
        type="file"
        name="bukti_pembayaran"
        accept="image/*"
        required
    >

    <br><br>

    <button type="submit">
        kirim pembayaran
    </button>

</form>

<br>

<a href="pesanan.php?id=<?php echo $id_pesanan; ?>">
    kembali ke pesanan
</a>

</body>

</html>