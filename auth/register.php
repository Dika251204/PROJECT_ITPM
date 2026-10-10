<!DOCTYPE html>
<html>
<head>
    <title>registrasi - uinma merch printhub</title>
</head>
<body>

<h1>daftar akun</h1>

<form action="proses_register.php" method="post">

    <label>nama lengkap</label>
    <br>
    <input type="text" name="nama" required>

    <br><br>

    <label>email</label>
    <br>
    <input type="email" name="email" required>

    <br><br>

    <label>password</label>
    <br>
    <input type="password" name="password" required>

    <br><br>

    <label>daftar sebagai</label>
    <br>

    <select name="role" required>
        <option value="user">pembeli</option>
        <option value="penjual">penjual</option>
    </select>

    <br><br>

    <button type="submit">daftar</button>

</form>

<br>

<a href="login.php">sudah punya akun? login</a>

</body>
</html>