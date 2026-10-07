<?php

session_start();

include "koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: auth/login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

$query = mysqli_query($conn, "
    select
        keranjang.id_produk,
        keranjang.jumlah,
        produk.nama_produk,
        produk.harga,
        produk.stok
    from keranjang
    join produk
        on keranjang.id_produk = produk.id_produk
    where keranjang.id_user = '$id_user'
");

if (mysqli_num_rows($query) == 0) {
    die("keranjang masih kosong");
}

$total_harga = 0;
$data = [];

while ($item = mysqli_fetch_assoc($query)) {

    if ($item['jumlah'] > $item['stok']) {
        die("stok produk " . $item['nama_produk'] . " tidak mencukupi");
    }

    $subtotal = $item['harga'] * $item['jumlah'];

    $total_harga = $total_harga + $subtotal;

    $data[] = $item;
}

mysqli_begin_transaction($conn);

try {

    mysqli_query($conn, "
        insert into pesanan
        (id_user, total_harga, status)
        values
        ('$id_user', '$total_harga', 'menunggu')
    ");

    $id_pesanan = mysqli_insert_id($conn);

    foreach ($data as $item) {

        $id_produk = $item['id_produk'];
        $jumlah = $item['jumlah'];
        $harga = $item['harga'];

        mysqli_query($conn, "
            insert into detail_pesanan
            (id_pesanan, id_produk, jumlah, harga)
            values
            ('$id_pesanan', '$id_produk', '$jumlah', '$harga')
        ");

        mysqli_query($conn, "
            update produk
            set stok = stok - $jumlah
            where id_produk = '$id_produk'
        ");
    }

    mysqli_query($conn, "
        delete from keranjang
        where id_user = '$id_user'
    ");

    mysqli_commit($conn);

    header("Location: pesanan.php?id=$id_pesanan");
    exit;

} catch (Exception $e) {

    mysqli_rollback($conn);

    die("checkout gagal: " . $e->getMessage());
}

?>