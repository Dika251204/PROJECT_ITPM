<?php
session_start();

include "../koneksi.php";

$email = $_POST['email'];
$password = $_POST['password'];

$query = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ?");
mysqli_stmt_bind_param($query, "s", $email);
mysqli_stmt_execute($query);

$result = mysqli_stmt_get_result($query);
$user = mysqli_fetch_assoc($result);

if ($user) {

    // periksa password yang sudah di-hash
    if (password_verify($password, $user['password'])) {

        $_SESSION['id_user'] = $user['id_user'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['role'] = $user['role'];

        // arahkan sesuai role
        if ($user['role'] == 'admin') {
            header("Location: ../admin/index.php");
        } elseif ($user['role'] == 'penjual') {
            header("Location: ../penjual/index.php");
        } else {
            header("Location: ../user/index.php");
        }

        exit;

    } else {
        echo "Password salah!";
    }

} else {
    echo "Email tidak ditemukan!";
}
?>