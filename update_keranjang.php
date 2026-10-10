<?php

session_start();

include "koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: auth/login.php");
    exit;
}

if (!isset($_GET['id']) || !isset($_GET['aksi'])) {
    header("Location: keranjang.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$id_keranjang = $_GET['id'];
$aksi = $_GET['aksi'];

$query = mysqli_query($conn, "
    select keranjang.jumlah, produk.stok
    from keranjang
    join produk
        on keranjang.id_produk = produk.id_produk
    where keranjang.id_keranjang = '$id_keranjang'
    and keranjang.id_user = '$id_user'
");

$item = mysqli_fetch_assoc($query);

if (!$item) {
    header("Location: keranjang.php");
    exit;
}

$jumlah = $item['jumlah'];
$stok = $item['stok'];

if ($aksi == "tambah") {

    if ($jumlah < $stok) {
        $jumlah++;
    }

}

if ($aksi == "kurang") {

    $jumlah--;

    if ($jumlah <= 0) {
        mysqli_query($conn, "
            delete from keranjang
            where id_keranjang = '$id_keranjang'
            and id_user = '$id_user'
        ");

        header("Location: keranjang.php");
        exit;
    }

}

mysqli_query($conn, "
    update keranjang
    set jumlah = '$jumlah'
    where id_keranjang = '$id_keranjang'
    and id_user = '$id_user'
");

header("Location: keranjang.php");
exit;

?>