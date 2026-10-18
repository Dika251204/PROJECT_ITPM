%%html

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login - CampusMart</title>

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
            max-width: 420px;

            background: white;

            padding: 35px;

            border-radius: 18px;

            box-shadow:
                0 10px 30px rgba(0,0,0,0.08);
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

            color: #111827;

            margin-bottom: 8px;
        }

        .auth-subtitle {
            text-align: center;

            color: #64748b;

            font-size: 14px;

            margin-bottom: 25px;
        }

        .alert {
            padding: 12px;

            border-radius: 8px;

            margin-bottom: 20px;

            font-size: 14px;

            display: none;
        }

        .alert-error {
            background: #fee2e2;
            color: #b91c1c;
        }

        .alert-success {
            background: #dcfce7;
            color: #15803d;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;

            margin-bottom: 7px;

            font-size: 14px;

            font-weight: bold;

            color: #374151;
        }

        .form-group input {
            width: 100%;

            padding: 13px 14px;

            border: 1px solid #cbd5e1;

            border-radius: 9px;

            font-size: 14px;

            outline: none;
        }

        .form-group input:focus {
            border-color: #2563eb;

            box-shadow:
                0 0 0 3px rgba(37,99,235,0.10);
        }

        .btn-login {
            width: 100%;

            padding: 13px;

            border: none;

            border-radius: 9px;

            background: #2563eb;

            color: white;

            font-size: 16px;

            font-weight: bold;

            cursor: pointer;
        }

        .btn-login:hover {
            background: #1d4ed8;
        }

        .auth-link {
            text-align: center;

            margin-top: 20px;

            color: #64748b;

            font-size: 14px;
        }

        .auth-link a {
            color: #2563eb;

            font-weight: bold;

            text-decoration: none;
        }

        .auth-link a:hover {
            text-decoration: underline;
        }

        .back-home {
            display: block;

            text-align: center;

            margin-top: 15px;

            color: #64748b;

            font-size: 14px;

            text-decoration: none;
        }

        .back-home:hover {
            color: #2563eb;
        }

        @media (max-width: 480px) {

            .auth-container {
                padding: 15px;
            }

            .auth-card {
                padding: 25px 20px;
            }

            .logo {
                font-size: 26px;
            }

            .auth-title {
                font-size: 23px;
            }

        }

    </style>

</head>

<body>

<div class="auth-container">

    <div class="auth-card">

        <div class="logo">
            Campus<span>Mart</span>
        </div>

        <h1 class="auth-title">
            Selamat Datang
        </h1>

        <p class="auth-subtitle">
            Login untuk melanjutkan ke CampusMart
        </p>


        <!-- PESAN ERROR -->
        <div id="errorMessage"
             class="alert alert-error">
        </div>


        <!-- PESAN BERHASIL -->
        <div id="successMessage"
             class="alert alert-success">
        </div>


        <!-- FORM LOGIN -->
        <form id="loginForm">

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


            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    placeholder="Masukkan password"
                    required
                >

            </div>


            <button
                type="submit"
                class="btn-login"
            >
                Login
            </button>

        </form>


        <div class="auth-link">

            Belum punya akun?

            <a href="#"
               onclick="daftar()">
                Daftar sekarang
            </a>

        </div>


        <a
            href="#"
            class="back-home"
            onclick="homepage()"
        >
            ← Kembali ke Homepage
        </a>


    </div>

</div>


<script>

    // LOGIN
    document.getElementById("loginForm")
        .addEventListener("submit", function(event) {

        event.preventDefault();

        let email =
            document.getElementById("email").value;

        let password =
            document.getElementById("password").value;

        let error =
            document.getElementById("errorMessage");

        let success =
            document.getElementById("successMessage");


        error.style.display = "none";
        success.style.display = "none";


        if (email === "" || password === "") {

            error.innerHTML =
                "Email dan password harus diisi.";

            error.style.display = "block";

            return;
        }


        if (password.length < 6) {

            error.innerHTML =
                "Password minimal 6 karakter.";

            error.style.display = "block";

            return;
        }


        success.innerHTML =
            "Login berhasil! Selamat datang di CampusMart.";

        success.style.display = "block";


        // Contoh simulasi login
        setTimeout(function() {

            alert("Login berhasil!");

        }, 500);

    });


    // DAFTAR
    function daftar() {

        alert(
            "Silakan menuju halaman pendaftaran akun."
        );

    }


    // HOMEPAGE
    function homepage() {

        alert(
            "Kembali ke Homepage CampusMart."
        );

    }

</script>

</body>

</html>