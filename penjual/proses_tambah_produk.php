<?php
session_start();
include "../koneksi.php";

// cek login
if (!isset($_SESSION['id_user'])) {
    header("Location: ../auth/login.php");
    exit;
}

// cek role
if ($_SESSION['role'] != 'penjual') {
    die("Akses ditolak");
}

// pastikan form dikirim
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: tambah_produk.php");
    exit;
}

// ambil data form
$id_penjual = $_SESSION['id_user'];
$id_kategori = (int) $_POST['id_kategori'];
$nama_produk = trim($_POST['nama_produk']);
$deskripsi = trim($_POST['deskripsi']);
$harga = (float) $_POST['harga'];
$stok = (int) $_POST['stok'];

// validasi data
if (
    $id_kategori <= 0 ||
    $nama_produk == '' ||
    $harga < 0 ||
    $stok < 0
) {
    die("Data produk tidak valid.");
}

// cek kategori
$stmt = mysqli_prepare(
    $conn,
    "SELECT id_kategori FROM kategori WHERE id_kategori = ?"
);
mysqli_stmt_bind_param($stmt, "i", $id_kategori);
mysqli_stmt_execute($stmt);
$hasil = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($hasil) == 0) {
    die("Kategori tidak ditemukan.");
}

// cek gambar
if (!isset($_FILES['gambar']) || $_FILES['gambar']['error'] != 0) {
    die("Gambar wajib diunggah.");
}

$gambar = $_FILES['gambar'];
$ukuran_maksimal = 2 * 1024 * 1024;

if ($gambar['size'] > $ukuran_maksimal) {
    die("Ukuran gambar maksimal 2 MB.");
}

// validasi jenis gambar
$tipe = mime_content_type($gambar['tmp_name']);
$jenis_gambar = [
    'image/jpeg' => 'jpg',
    'image/png' => 'png',
    'image/webp' => 'webp'
];

if (!isset($jenis_gambar[$tipe])) {
    die("Format gambar harus JPG, PNG, atau WebP.");
}

// buat folder jika belum ada
$folder = "../uploads/produk/";

if (!is_dir($folder)) {
    mkdir($folder, 0755, true);
}

// buat nama gambar unik
$nama_gambar = uniqid("produk_", true) . "." . $jenis_gambar[$tipe];
$lokasi_gambar = $folder . $nama_gambar;

// pindahkan gambar
if (!move_uploaded_file($gambar['tmp_name'], $lokasi_gambar)) {
    die("Gagal mengunggah gambar.");
}

// simpan data produk
$stmt = mysqli_prepare(
    $conn,
    "INSERT INTO produk
    (id_kategori, id_penjual, nama_produk, deskripsi, harga, stok, gambar, status)
    VALUES (?, ?, ?, ?, ?, ?, ?, 'menunggu')"
);

mysqli_stmt_bind_param(
    $stmt,
    "iissdis",
    $id_kategori,
    $id_penjual,
    $nama_produk,
    $deskripsi,
    $harga,
    $stok,
    $nama_gambar
);

if (mysqli_stmt_execute($stmt)) {
    echo "<script>
        alert('Produk berhasil ditambahkan dan menunggu persetujuan admin!');
        window.location.href = 'index.php';
    </script>";
} else {
    // hapus gambar jika penyimpanan gagal
    unlink($lokasi_gambar);
    echo "Gagal menyimpan produk: " . htmlspecialchars(mysqli_error($conn));
}
?>