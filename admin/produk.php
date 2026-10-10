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
        produk.id_produk,
        produk.nama_produk,
        produk.deskripsi,
        produk.harga,
        produk.stok,
        produk.gambar,
        kategori.nama_kategori
    from produk
    join kategori
        on produk.id_kategori = kategori.id_kategori
    order by produk.id_produk desc
");

?>

<!DOCTYPE html>
<html>

<head>
    <title>produk admin - uinma merch printhub</title>
</head>

<body>

<nav>
    <a href="index.php">dashboard</a> |
    <a href="pesanan.php">pesanan</a> |
    <a href="produk.php">produk</a> |
    <a href="../index.php">lihat website</a> |
    <a href="../auth/logout.php">logout</a>
</nav>

<hr>

<h1>kelola produk</h1>

<p>
    <a href="tambah_produk.php">+ tambah produk</a>
</p>

<hr>

<?php if (mysqli_num_rows($query) == 0) { ?>

    <p>belum ada produk.</p>

<?php } else { ?>

    <?php while ($produk = mysqli_fetch_assoc($query)) { ?>

        <div>

            <h2>
                <?php echo htmlspecialchars($produk['nama_produk']); ?>
            </h2>

            <p>
                kategori:
                <?php echo htmlspecialchars($produk['nama_kategori']); ?>
            </p>

            <?php if (!empty($produk['gambar'])) { ?>

                <p>gambar produk:</p>

                <img
                    src="../uploads/produk/<?php echo rawurlencode(basename($produk['gambar'])); ?>"
                    alt="gambar produk"
                    width="200"
                    height="200"
                    style="object-fit: contain;"
                >

            <?php } else { ?>

                <p>belum ada gambar</p>

            <?php } ?>

            <p>
                deskripsi:
                <?php echo nl2br(htmlspecialchars($produk['deskripsi'])); ?>
            </p>

            <p>
                harga:
                rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?>
            </p>

            <p>
                stok:
                <?php echo $produk['stok']; ?>
            </p>

            <a href="edit_produk.php?id=<?php echo $produk['id_produk']; ?>">
                edit
            </a>

            |

            <a
                href="hapus_produk.php?id=<?php echo $produk['id_produk']; ?>"
                onclick="return confirm('yakin ingin menghapus produk ini?')"
            >
                hapus
            </a>

        </div>

        <hr>

    <?php } ?>

<?php } ?>

</body>
</html>