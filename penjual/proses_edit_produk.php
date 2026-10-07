<?php
session_start();
include "../koneksi.php";

if (!isset($_SESSION['id_user']) || $_SESSION['role'] != 'penjual') {
    header("Location: ../auth/login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: produk.php");
    exit;
}

$id_produk = (int) $_POST['id_produk'];
$id_penjual = $_SESSION['id_user'];
$id_kategori = (int) $_POST['id_kategori'];
$nama_produk = trim($_POST['nama_produk']);
$deskripsi = trim($_POST['deskripsi']);
$harga = (float) $_POST['harga'];
$stok = (int) $_POST['stok'];

// cek produk milik penjual
$stmt = mysqli_prepare($conn,
    "SELECT gambar FROM produk
     WHERE id_produk = ? AND id_penjual = ?"
);
mysqli_stmt_bind_param($stmt, "ii", $id_produk, $id_penjual);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$produk = mysqli_fetch_assoc($result);

if (!$produk) {
    die("Produk tidak ditemukan.");
}

// validasi
if ($nama_produk == '' || $harga < 0 || $stok < 0) {
    die("Data produk tidak valid.");
}

// cek kategori
$stmt = mysqli_prepare($conn,
    "SELECT id_kategori FROM kategori WHERE id_kategori = ?"
);
mysqli_stmt_bind_param($stmt, "i", $id_kategori);
mysqli_stmt_execute($stmt);

if (mysqli_stmt_get_result($stmt)->num_rows == 0) {
    die("Kategori tidak ditemukan.");
}

$gambar_lama = $produk['gambar'];
$nama_gambar = $gambar_lama;
$gambar_baru = false;

// jika foto baru diunggah
if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] != UPLOAD_ERR_NO_FILE) {
    if ($_FILES['gambar']['error'] != UPLOAD_ERR_OK) {
        die("Gagal mengunggah gambar.");
    }

    if ($_FILES['gambar']['size'] > 2 * 1024 * 1024) {
        die("Ukuran gambar maksimal 2 MB.");
    }

    $tipe = mime_content_type($_FILES['gambar']['tmp_name']);
    $jenis = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp'
    ];

    if (!isset($jenis[$tipe])) {
        die("Format gambar harus JPG, PNG, atau WebP.");
    }

    $folder = "../uploads/produk/";

    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
    }

    $nama_gambar = uniqid("produk_", true) . "." . $jenis[$tipe];
    $lokasi = $folder . $nama_gambar;

    if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $lokasi)) {
        die("Gagal menyimpan gambar.");
    }

    $gambar_baru = true;
}

// simpan perubahan
$stmt = mysqli_prepare($conn,
    "UPDATE produk
     SET id_kategori = ?, nama_produk = ?, deskripsi = ?,
         harga = ?, stok = ?, gambar = ?, status = 'menunggu'
     WHERE id_produk = ? AND id_penjual = ?"
);

mysqli_stmt_bind_param(
    $stmt,
    "issdisii",
    $id_kategori,
    $nama_produk,
    $deskripsi,
    $harga,
    $stok,
    $nama_gambar,
    $id_produk,
    $id_penjual
);

if (mysqli_stmt_execute($stmt)) {
    if ($gambar_baru && !empty($gambar_lama)) {
        $file_lama = "../uploads/produk/" . basename($gambar_lama);

        if (is_file($file_lama)) {
            unlink($file_lama);
        }
    }

    echo "<script>
        alert('Produk berhasil diperbarui dan menunggu persetujuan admin!');
        window.location.href = 'produk.php';
    </script>";
} else {
    if ($gambar_baru && is_file($lokasi)) {
        unlink($lokasi);
    }

    echo "Gagal memperbarui produk.";
}
?>