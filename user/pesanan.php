<?php

session_start();

include "../koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SESSION['role'] != 'user') {
    echo "akses ditolak";
    exit;
}

$id_user = $_SESSION['id_user'];

$query = mysqli_query($conn, "
    select
        id_pesanan,
        tanggal_pesanan,
        total_harga,
        status
    from pesanan
    where id_user = '$id_user'
    order by id_pesanan desc
");

?>

<!DOCTYPE html>
<html>

<head>

    <title>pesanan saya - uinma merch printhub</title>

</head>

<body>

<nav>

    <a href="index.php">akun</a> |
    <a href="../index.php">home</a> |
    <a href="../produk.php">produk</a> |
    <a href="../keranjang.php">keranjang</a> |
    <a href="pesanan.php">pesanan saya</a> |
    <a href="../auth/logout.php">logout</a>

</nav>

<hr>

<h1>pesanan saya</h1>

<p>
    nama:
    <?php echo $_SESSION['nama']; ?>
</p>

<hr>

<?php if (mysqli_num_rows($query) == 0) { ?>

    <p>
        belum ada pesanan.
    </p>

    <a href="../produk.php">
        mulai belanja
    </a>

<?php } else { ?>

    <?php while ($pesanan = mysqli_fetch_assoc($query)) { ?>

        <div>

            <h2>
                pesanan #<?php echo $pesanan['id_pesanan']; ?>
            </h2>

            <p>
                tanggal:
                <?php echo $pesanan['tanggal_pesanan']; ?>
            </p>

            <p>
                total:
                rp <?php echo number_format($pesanan['total_harga'], 0, ',', '.'); ?>
            </p>

            <p>
                status:
                <strong>
                    <?php echo $pesanan['status']; ?>
                </strong>
            </p>

            <a href="../pesanan.php?id=<?php echo $pesanan['id_pesanan']; ?>">
                lihat detail
            </a>

        </div>

        <hr>

    <?php } ?>

<?php } ?>

</body>

</html>