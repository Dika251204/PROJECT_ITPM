%%html

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Register - CampusMart</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #eff6ff;
            min-height: 100vh;
        }

        .auth-container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .auth-card {
            width: 100%;
            max-width: 450px;
            background: white;
            padding: 35px;
            border-radius: 18px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        }

        .logo {
            text-align: center;
            font-size: 30px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 10px;
        }

        .logo span {
            color: #111827;
        }

        .auth-title {
            text-align: center;
            font-size: 26px;
            margin-bottom: 8px;
        }

        .auth-subtitle {
            text-align: center;
            color: #64748b;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            font-size: 14px;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 13px;
            border: 1px solid #cbd5e1;
            border-radius: 9px;
            font-size: 14px;
            outline: none;
        }

        .form-group input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.10);
        }

        .btn-register {
            width: 100%;
            padding: 13px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 9px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-register:hover {
            background: #1d4ed8;
        }

        .auth-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #64748b;
        }

        .auth-link a {
            color: #2563eb;
            font-weight: bold;
            text-decoration: none;
        }

        .back-home {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #64748b;
            text-decoration: none;
            font-size: 14px;
        }

        .success {
            display: none;
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
            text-align: center;
            font-size: 14px;
        }

        .error {
            display: none;
            background: #fee2e2;
            color: #b91c1c;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 18px;
            text-align: center;
            font-size: 14px;
        }

        @media (max-width: 480px) {

            .auth-card {
                padding: 25px 20px;
            }

            .logo {
                font-size: 26px;
            }

        }

    </style>

</head>

<body>


<div class="auth-container">

    <div class="auth-card">


        <!-- LOGO -->

        <div class="logo">
            Campus<span>Mart</span>
        </div>


        <!-- JUDUL -->

        <h1 class="auth-title">
            Buat Akun
        </h1>


        <p class="auth-subtitle">
            Daftar untuk menggunakan CampusMart
        </p>


        <!-- PESAN ERROR -->

        <div class="error" id="errorMessage">
            Password dan konfirmasi password tidak sama.
        </div>


        <!-- PESAN BERHASIL -->

        <div class="success" id="successMessage">
            Pendaftaran berhasil!
        </div>


        <!-- FORM REGISTER -->

        <form id="registerForm">


            <!-- NAMA -->

            <div class="form-group">

                <label for="nama">
                    Nama Lengkap
                </label>

                <input
                    type="text"
                    id="nama"
                    placeholder="Masukkan nama lengkap"
                    required
                >

            </div>


            <!-- NIM -->

            <div class="form-group">

                <label for="nim">
                    NIM
                </label>

                <input
                    type="text"
                    id="nim"
                    placeholder="Masukkan NIM"
                    required
                >

            </div>


            <!-- EMAIL -->

            <div class="form-group">

                <label for="email">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    placeholder="Masukkan email"
                    required
                >

            </div>


            <!-- PASSWORD -->

            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    placeholder="Minimal 6 karakter"
                    minlength="6"
                    required
                >

            </div>


            <!-- KONFIRMASI PASSWORD -->

            <div class="form-group">

                <label for="konfirmasi_password">
                    Konfirmasi Password
                </label>

                <input
                    type="password"
                    id="konfirmasi_password"
                    placeholder="Masukkan ulang password"
                    required
                >

            </div>


            <!-- BUTTON -->

            <button
                type="submit"
                class="btn-register">

                Daftar

            </button>


        </form>


        <!-- LOGIN -->

        <div class="auth-link">

            Sudah punya akun?

            <a href="#" onclick="login()">
                Login
            </a>

        </div>


        <!-- HOME -->

        <a
            href="#"
            class="back-home"
            onclick="home()">

            ← Kembali ke Homepage

        </a>


    </div>

</div>


<script>

document.getElementById("registerForm").addEventListener("submit", function(event) {

    event.preventDefault();

    let nama = document.getElementById("nama").value;
    let nim = document.getElementById("nim").value;
    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;
    let konfirmasi = document.getElementById("konfirmasi_password").value;

    let error = document.getElementById("errorMessage");
    let success = document.getElementById("successMessage");


    error.style.display = "none";
    success.style.display = "none";


    // Cek password

    if (password !== konfirmasi) {

        error.innerHTML =
            "Password dan konfirmasi password tidak sama.";

        error.style.display = "block";

        return;
    }


    // Cek panjang password

    if (password.length < 6) {

        error.innerHTML =
            "Password minimal 6 karakter.";

        error.style.display = "block";

        return;
    }


    // Berhasil

    success.innerHTML =
        "Pendaftaran berhasil untuk " + nama + "!";

    success.style.display = "block";


    // Reset form

    document.getElementById("registerForm").reset();

});


function login() {

    alert("Menuju halaman Login");

}


function home() {

    alert("Kembali ke Homepage");

}

</script>


</body>

</html>