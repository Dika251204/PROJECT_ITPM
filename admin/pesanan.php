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
    order by pesanan.id_pesanan desc
");

?>

<!DOCTYPE html>
<html>

<head>

    <title>pesanan admin - uinma merch printhub</title>

</head>

<body>

<nav>

    <a href="index.php">dashboard</a> |
    <a href="pesanan.php">pesanan</a> |
    <a href="../auth/logout.php">logout</a>

</nav>

<hr>

<h1>daftar pesanan</h1>

<?php if (mysqli_num_rows($query) == 0) { ?>

    <p>belum ada pesanan.</p>

<?php } else { ?>

    <?php while ($pesanan = mysqli_fetch_assoc($query)) { ?>

        <div>

            <h3>
                pesanan #<?php echo $pesanan['id_pesanan']; ?>
            </h3>

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
                total:
                rp <?php echo number_format($pesanan['total_harga'], 0, ',', '.'); ?>
            </p>

            <p>
                status:
                <?php echo $pesanan['status']; ?>
            </p>

            <a href="detail_pesanan.php?id=<?php echo $pesanan['id_pesanan']; ?>">
                lihat detail
            </a>

        </div>

        <hr>

    <?php } ?>

<?php } ?>

</body>

</html>