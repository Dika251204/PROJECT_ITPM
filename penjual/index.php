<?php

session_start();

include "../koneksi.php";

// cek login
if (!isset($_SESSION['id_user'])) {
    header("Location: ../auth/login.php");
    exit;
}

// cek role penjual
if ($_SESSION['role'] != 'penjual') {
    echo "akses ditolak";
    exit;
}

$id_penjual = $_SESSION['id_user'];

// hitung jumlah produk
$query = mysqli_prepare($conn, "
    SELECT COUNT(*) AS total
    FROM produk
    WHERE id_penjual = ?
");

mysqli_stmt_bind_param($query, "i", $id_penjual);
mysqli_stmt_execute($query);

$hasil = mysqli_stmt_get_result($query);
$data = mysqli_fetch_assoc($hasil);

$total_produk = $data['total'];

?>

<!DOCTYPE html>
<html>

<head>
    <title>dashboard penjual - uinma merch printhub</title>
</head>

<body>

<nav>
    <a href="index.php">dashboard</a> |
    <a href="produk.php">produk saya</a> |
    <a href="../index.php">lihat website</a> |
    <a href="../auth/logout.php">logout</a>
</nav>

<hr>

<h1>dashboard penjual</h1>

<p>
    selamat datang,
    <?php echo htmlspecialchars($_SESSION['nama']); ?>
</p>

<hr>

<h2>ringkasan toko</h2>

<p>
    jumlah produk saya:
    <?php echo $total_produk; ?>
</p>

<hr>

<h2>menu penjual</h2>

<ul>
    <li>
        <a href="produk.php">kelola produk saya</a>
    </li>
    <li>
        <a href="tambah_produk.php">tambah produk</a>
    </li>
    <li>
        <a href="../index.php">lihat marketplace</a>
    </li>
</ul>

</body>
</html>