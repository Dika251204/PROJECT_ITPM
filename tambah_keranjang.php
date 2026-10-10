<?php

session_start();

include "koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: auth/login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: produk.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$id_produk = $_GET['id'];

$cek = mysqli_query($conn, "
    select * from keranjang
    where id_user = '$id_user'
    and id_produk = '$id_produk'
");

if (mysqli_num_rows($cek) > 0) {

    mysqli_query($conn, "
        update keranjang
        set jumlah = jumlah + 1
        where id_user = '$id_user'
        and id_produk = '$id_produk'
    ");

} else {

    mysqli_query($conn, "
        insert into keranjang (id_user, id_produk, jumlah)
        values ('$id_user', '$id_produk', 1)
    ");

}

header("Location: keranjang.php");
exit;

?>