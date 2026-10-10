<?php
include "koneksi.php";

$password = "admin123";
$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = mysqli_prepare(
    $conn,
    "UPDATE users SET password = ? WHERE email = ?"
);

$email = "admin@uinma.ac.id";

mysqli_stmt_bind_param($stmt, "ss", $hash, $email);

if (mysqli_stmt_execute($stmt)) {
    echo "Password admin berhasil diperbarui!";
} else {
    echo "Gagal memperbarui password.";
}
?>