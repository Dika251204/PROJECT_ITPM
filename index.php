<?php

session_start();

include "koneksi.php";

$query = mysqli_query($conn, "select * from produk order by id_produk desc");

?>

<!DOCTYPE html>
<html>
<head>
    <title>uinma merch printhub</title>
</head>
<body>

<nav>

    <a href="index.php">home</a> |
    <a href="produk.php">produk</a> |

    <?php if (isset($_SESSION['id_user'])) { ?>

        <a href="keranjang.php">keranjang</a> |
        <a href="user/index.php">akun</a> |
        <a href="auth/logout.php">logout</a>

    <?php } else { ?>

        <a href="auth/login.php">login</a>

    <?php } ?>

</nav>

<hr>

<h1>uinma merch & printhub</h1>

<p>pusat merchandise dan layanan print uinma</p>

<hr>

<h2>produk terbaru</h2>

<?php while ($produk = mysqli_fetch_assoc($query)) { ?>

    <div>

        <h3>
            <?php echo $produk['nama_produk']; ?>
        </h3>

        <p>
            <?php echo $produk['deskripsi']; ?>
        </p>

        <p>
            harga:
            rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?>
        </p>

        <p>
            stok:
            <?php echo $produk['stok']; ?>
        </p>

        <a href="detail_produk.php?id=<?php echo $produk['id_produk']; ?>">
            lihat detail
        </a>

    </div>

    <hr>

<?php } ?>

</body>
</html>