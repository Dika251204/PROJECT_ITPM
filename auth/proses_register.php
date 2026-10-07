<?php

session_start();

include "../koneksi.php";

// cek data
if (
    empty($_POST['nama']) ||
    empty($_POST['email']) ||
    empty($_POST['password']) ||
    empty($_POST['role'])
) {
    die("semua data wajib diisi");
}

// ambil data
$nama = trim($_POST['nama']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$role = $_POST['role'];

// validasi role
if (!in_array($role, ['user', 'penjual'])) {
    die("role tidak valid");
}

// cek email
$cek = mysqli_prepare($conn, "
    select id_user from users where email = ?
");

mysqli_stmt_bind_param($cek, "s", $email);
mysqli_stmt_execute($cek);
$hasil = mysqli_stmt_get_result($cek);

if (mysqli_num_rows($hasil) > 0) {
    die("email sudah terdaftar");
}

// enkripsi password
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// simpan akun
$query = mysqli_prepare($conn, "
    insert into users (nama, email, password, role)
    values (?, ?, ?, ?)
");

mysqli_stmt_bind_param(
    $query,
    "ssss",
    $nama,
    $email,
    $password_hash,
    $role
);

if (mysqli_stmt_execute($query)) {
    echo "registrasi berhasil!";
    echo "<br>";
    echo "<a href='login.php'>login sekarang</a>";
} else {
    echo "registrasi gagal: " . mysqli_error($conn);
}

?>