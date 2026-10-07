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
    header("Location: pesanan.php");
    exit;
}

$id_pesanan = $_GET['id'];

$query = mysqli_query($conn, "
    select
        pesanan.id_pesanan,
        users.nama,
        users.email,
        pesanan.tanggal_pesanan,
        pesanan.total_harga,
        pesanan.status
    from pesanan
    join users
        on pesanan.id_user = users.id_user
    where pesanan.id_pesanan = '$id_pesanan'
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

$pembayaran = mysqli_query($conn, "
    select
        id_pembayaran,
        metode_pembayaran,
        bukti_pembayaran,
        status_pembayaran,
        tanggal_pembayaran
    from pembayaran
    where id_pesanan = '$id_pesanan'
    order by id_pembayaran desc
");

$data_pembayaran = mysqli_fetch_assoc($pembayaran);

?>

<!DOCTYPE html>
<html>

<head>

    <title>detail pesanan admin</title>

</head>

<body>

<nav>

    <a href="index.php">dashboard</a> |
    <a href="pesanan.php">pesanan</a> |
    <a href="../auth/logout.php">logout</a>

</nav>

<hr>

<h1>detail pesanan</h1>

<h2>
    pesanan #<?php echo $pesanan['id_pesanan']; ?>
</h2>

<p>
    nama:
    <?php echo $pesanan['nama']; ?>
</p>

<p>
    email:
    <?php echo $pesanan['email']; ?>
</p>

<p>
    tanggal:
    <?php echo $pesanan['tanggal_pesanan']; ?>
</p>

<p>
    status pesanan:
    <?php echo $pesanan['status']; ?>
</p>
<?php if ($pesanan['status'] != 'selesai' && $pesanan['status'] != 'dibatalkan') { ?>

    <form action="proses_status_pesanan.php" method="post">

        <input
            type="hidden"
            name="id_pesanan"
            value="<?php echo $pesanan['id_pesanan']; ?>"
        >

        <label>ubah status pesanan</label>

        <br>

        <select name="status">

            <option value="menunggu"
                <?php if ($pesanan['status'] == 'menunggu') echo 'selected'; ?>>
                menunggu
            </option>

            <option value="diproses"
                <?php if ($pesanan['status'] == 'diproses') echo 'selected'; ?>>
                diproses
            </option>

            <option value="dikirim"
                <?php if ($pesanan['status'] == 'dikirim') echo 'selected'; ?>>
                dikirim
            </option>

            <option value="selesai"
                <?php if ($pesanan['status'] == 'selesai') echo 'selected'; ?>>
                selesai
            </option>

            <option value="dibatalkan">
                dibatalkan
            </option>

        </select>

        <button type="submit">
            ubah status
        </button>

    </form>

<?php } ?>
<hr>

<h2>produk yang dipesan</h2>

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

<hr>

<h2>pembayaran</h2>

<?php if (!$data_pembayaran) { ?>

    <p>
        belum ada pembayaran.
    </p>

<?php } else { ?>

    <p>
        metode:
        <?php echo $data_pembayaran['metode_pembayaran']; ?>
    </p>

    <p>
        tanggal pembayaran:
        <?php echo $data_pembayaran['tanggal_pembayaran']; ?>
    </p>

    <p>
        status pembayaran:
        <?php echo $data_pembayaran['status_pembayaran']; ?>
    </p>
<?php if ($data_pembayaran['status_pembayaran'] == 'menunggu') { ?>

    <br>

    <form action="proses_pembayaran.php" method="post">

        <input
            type="hidden"
            name="id_pembayaran"
            value="<?php echo $data_pembayaran['id_pembayaran']; ?>"
        >

        <button
            type="submit"
            name="aksi"
            value="terima"
        >
            terima pembayaran
        </button>

        <button
            type="submit"
            name="aksi"
            value="tolak"
        >
            tolak pembayaran
        </button>

    </form>

<?php } ?>
    <p>
        bukti pembayaran:
    </p>

    <p>
        <img
            src="../<?php echo $data_pembayaran['bukti_pembayaran']; ?>"
            width="300"
        >
    </p>

<?php } ?>

<br>

<a href="pesanan.php">
    kembali ke daftar pesanan
</a>

</body>

</html>