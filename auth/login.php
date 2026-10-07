<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>login - uinma merch printhub</title>
</head>
<body>

<h2>login uinma merch printhub</h2>

<form action="proses_login.php" method="post">

    <label>email</label><br>
    <input type="email" name="email" required>

    <br><br>

    <label>password</label><br>
    <input type="password" name="password" required>

    <br><br>

    <button type="submit">login</button>

</form>

</body>
</html>