<?php

session_start();

include "koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: auth/login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: keranjang.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$id_keranjang = $_GET['id'];

$query = mysqli_query($conn, "
    delete from keranjang
    where id_keranjang = '$id_keranjang'
    and id_user = '$id_user'
");

header("Location: keranjang.php");
exit;

?>