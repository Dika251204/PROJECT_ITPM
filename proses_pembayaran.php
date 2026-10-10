<?php

session_start();
include "koneksi.php";

if (!isset($_SESSION['id_user'])) {
    header("Location: auth/login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

if (
    !isset($_POST['id_pesanan']) ||
    !isset($_POST['metode_pembayaran'])
) {
    die("data pembayaran tidak lengkap");
}

$id_pesanan = (int) $_POST['id_pesanan'];
$metode = $_POST['metode_pembayaran'];

$metode_valid = ['transfer bank', 'qris', 'cash'];

if (!in_array($metode, $metode_valid, true)) {
    die("metode pembayaran tidak valid");
}

// cek pesanan milik pengguna
$stmt = mysqli_prepare($conn, "
    select id_pesanan, status
    from pesanan
    where id_pesanan = ?
    and id_user = ?
");

mysqli_stmt_bind_param($stmt, "ii", $id_pesanan, $id_user);
mysqli_stmt_execute($stmt);

$hasil = mysqli_stmt_get_result($stmt);
$pesanan = mysqli_fetch_assoc($hasil);

if (!$pesanan) {
    die("pesanan tidak ditemukan");
}

if ($pesanan['status'] != 'menunggu') {
    die("pesanan tidak dapat dibayar");
}

// cek bukti pembayaran
if (
    !isset($_FILES['bukti_pembayaran']) ||
    $_FILES['bukti_pembayaran']['error'] != 0
) {
    die("bukti pembayaran belum dipilih atau gagal diunggah");
}

$file = $_FILES['bukti_pembayaran'];

if ($file['size'] > 2 * 1024 * 1024) {
    die("ukuran bukti maksimal 2 MB");
}

$info = getimagesize($file['tmp_name']);

if (!$info) {
    die("file harus berupa gambar");
}

$tipe = $info['mime'];

$ekstensi = [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'image/webp' => 'webp'
];

if (!isset($ekstensi[$tipe])) {
    die("format gambar harus JPG, PNG, atau WebP");
}

$folder = "uploads/pembayaran/";

if (!is_dir($folder)) {
    mkdir($folder, 0777, true);
}

$nama_baru = uniqid("bukti_", true) . "." . $ekstensi[$tipe];
$tujuan = $folder . $nama_baru;

if (!move_uploaded_file($file['tmp_name'], $tujuan)) {
    die("bukti pembayaran gagal disimpan");
}

// simpan pembayaran
$stmt = mysqli_prepare($conn, "
    insert into pembayaran
    (
        id_pesanan,
        metode_pembayaran,
        bukti_pembayaran,
        status_pembayaran
    )
    values (?, ?, ?, 'menunggu')
");

mysqli_stmt_bind_param(
    $stmt,
    "iss",
    $id_pesanan,
    $metode,
    $tujuan
);

if (!mysqli_stmt_execute($stmt)) {
    unlink($tujuan);
    die("pembayaran gagal disimpan: " . mysqli_error($conn));
}

header("Location: pesanan.php?id=" . $id_pesanan);
exit;

?>