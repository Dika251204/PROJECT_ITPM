<?php

session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SESSION['role'] != 'user') {
    echo "akses ditolak";
    exit;
}

?>

<!DOCTYPE html>
<html>

<head>

    <title>akun user - uinma merch printhub</title>

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

<h1>akun user</h1>

<p>
    selamat datang,
    <?php echo $_SESSION['nama']; ?>
</p>

<hr>

<h2>menu user</h2>

<ul>

    <li>
        <a href="../index.php">
            home
        </a>
    </li>

    <li>
        <a href="../produk.php">
            lihat produk
        </a>
    </li>

    <li>
        <a href="../keranjang.php">
            keranjang
        </a>
    </li>

    <li>
        <a href="pesanan.php">
            pesanan saya
        </a>
    </li>

    <li>
        <a href="../auth/logout.php">
            logout
        </a>
    </li>

</ul>

</body>

</html>