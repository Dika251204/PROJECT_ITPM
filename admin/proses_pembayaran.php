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

if (!isset($_POST['id_pembayaran']) || !isset($_POST['aksi'])) {
    header("Location: pesanan.php");
    exit;
}

$id_pembayaran = $_POST['id_pembayaran'];
$aksi = $_POST['aksi'];

$query = mysqli_query($conn, "
    select *
    from pembayaran
    where id_pembayaran = '$id_pembayaran'
");

$pembayaran = mysqli_fetch_assoc($query);

if (!$pembayaran) {
    die("data pembayaran tidak ditemukan");
}

$id_pesanan = $pembayaran['id_pesanan'];

if ($aksi == "terima") {

    mysqli_query($conn, "
        update pembayaran
        set status_pembayaran = 'terverifikasi'
        where id_pembayaran = '$id_pembayaran'
    ");

    mysqli_query($conn, "
        update pesanan
        set status = 'diproses'
        where id_pesanan = '$id_pesanan'
    ");

}

if ($aksi == "tolak") {

    mysqli_query($conn, "
        update pembayaran
        set status_pembayaran = 'ditolak'
        where id_pembayaran = '$id_pembayaran'
    ");

    mysqli_query($conn, "
        update pesanan
        set status = 'dibatalkan'
        where id_pesanan = '$id_pesanan'
    ");

}

header("Location: detail_pesanan.php?id=$id_pesanan");
exit;

?>