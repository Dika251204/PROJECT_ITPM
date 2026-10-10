<?php

include "koneksi.php";

$query = mysqli_query($conn, "
    select * from produk
    order by id_produk desc
");

?>

<!DOCTYPE html>
<html>
<head>
    <title>produk - uinma merch printhub</title>
</head>
<body>

<nav>
    <a href="index.php">home</a> |
    <a href="produk.php">produk</a> |
    <a href="auth/login.php">login</a>
</nav>

<hr>

<h1>produk uinma merch</h1>

<?php if (mysqli_num_rows($query) == 0) { ?>

    <p>belum ada produk.</p>

<?php } else { ?>

    <?php while ($produk = mysqli_fetch_assoc($query)) { ?>

        <div>

            <h3>
                <?php echo htmlspecialchars($produk['nama_produk']); ?>
            </h3>

            <?php if (!empty($produk['gambar'])) { ?>

                <img
                    src="uploads/produk/<?php echo rawurlencode(basename($produk['gambar'])); ?>"
                    alt="<?php echo htmlspecialchars($produk['nama_produk']); ?>"
                    width="200"
                    height="200"
                    style="object-fit: contain;"
                >

            <?php } else { ?>

                <p>belum ada gambar</p>

            <?php } ?>

            <p>
                <?php echo nl2br(htmlspecialchars($produk['deskripsi'])); ?>
            </p>

            <p>
                harga: rp
                <?php echo number_format($produk['harga'], 0, ',', '.'); ?>
            </p>

            <p>
                stok: <?php echo (int) $produk['stok']; ?>
            </p>

            <a href="detail_produk.php?id=<?php echo (int) $produk['id_produk']; ?>">
                lihat detail
            </a>

        </div>

        <hr>

    <?php } ?>

<?php } ?>

</body>
</html>