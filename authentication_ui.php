%%html

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Authentication - CampusMart</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f1f5f9;
            min-height: 100vh;
        }

        /* =========================
           CONTAINER
        ========================= */

        .auth-wrapper {
            min-height: 100vh;

            display: flex;
            justify-content: center;
            align-items: center;

            padding: 30px;
        }

        .auth-box {
            width: 100%;
            max-width: 900px;

            min-height: 550px;

            background: white;

            border-radius: 24px;

            overflow: hidden;

            display: grid;
            grid-template-columns: 42% 58%;

            box-shadow:
                0 20px 50px rgba(15, 23, 42, 0.12);
        }


        /* =========================
           LEFT BRANDING
        ========================= */

        .brand-section {
            background: linear-gradient(
                145deg,
                #2563eb,
                #1d4ed8
            );

            color: white;

            padding: 45px;

            display: flex;
            flex-direction: column;
            justify-content: center;

            position: relative;

            overflow: hidden;
        }

        .brand-section::before {
            content: "";

            position: absolute;

            width: 250px;
            height: 250px;

            border-radius: 50%;

            background: rgba(255,255,255,0.08);

            top: -80px;
            left: -80px;
        }

        .brand-section::after {
            content: "";

            position: absolute;

            width: 220px;
            height: 220px;

            border-radius: 50%;

            background: rgba(255,255,255,0.08);

            bottom: -80px;
            right: -70px;
        }

        .brand-content {
            position: relative;
            z-index: 2;
        }

        .brand-logo {
            font-size: 34px;

            font-weight: bold;

            margin-bottom: 25px;
        }

        .brand-logo span {
            color: #dbeafe;
        }

        .brand-title {
            font-size: 30px;

            line-height: 1.25;

            margin-bottom: 18px;
        }

        .brand-description {
            font-size: 15px;

            line-height: 1.7;

            color: #dbeafe;

            margin-bottom: 30px;
        }

        .feature {
            display: flex;

            align-items: center;

            gap: 12px;

            margin-bottom: 15px;

            font-size: 14px;
        }

        .feature-icon {
            width: 34px;
            height: 34px;

            border-radius: 9px;

            background: rgba(255,255,255,0.15);

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 17px;
        }


        /* =========================
           RIGHT FORM
        ========================= */

        .form-section {
            padding: 45px;

            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .form-header {
            margin-bottom: 25px;
        }

        .form-header h1 {
            font-size: 28px;

            color: #111827;

            margin-bottom: 8px;
        }

        .form-header p {
            color: #64748b;

            font-size: 14px;
        }


        /* =========================
           TABS
        ========================= */

        .tabs {
            display: flex;

            background: #f1f5f9;

            border-radius: 10px;

            padding: 4px;

            margin-bottom: 25px;
        }

        .tab {
            flex: 1;

            padding: 11px;

            border: none;

            background: transparent;

            border-radius: 8px;

            color: #64748b;

            font-weight: bold;

            cursor: pointer;

            font-size: 14px;
        }

        .tab.active {
            background: white;

            color: #2563eb;

            box-shadow:
                0 2px 6px rgba(0,0,0,0.08);
        }


        /* =========================
           ALERT
        ========================= */

        .alert {
            display: none;

            padding: 12px;

            border-radius: 8px;

            margin-bottom: 18px;

            font-size: 13px;
        }

        .alert-error {
            background: #fee2e2;

            color: #b91c1c;
        }

        .alert-success {
            background: #dcfce7;

            color: #15803d;
        }


        /* =========================
           FORM
        ========================= */

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;

            margin-bottom: 7px;

            font-size: 13px;

            font-weight: bold;

            color: #374151;
        }

        .form-group input {
            width: 100%;

            padding: 12px 14px;

            border: 1px solid #cbd5e1;

            border-radius: 9px;

            font-size: 14px;

            outline: none;

            transition: 0.2s;
        }

        .form-group input:focus {
            border-color: #2563eb;

            box-shadow:
                0 0 0 3px rgba(37,99,235,0.10);
        }


        /* =========================
           BUTTON
        ========================= */

        .btn-auth {
            width: 100%;

            padding: 13px;

            border: none;

            border-radius: 9px;

            background: #2563eb;

            color: white;

            font-size: 15px;

            font-weight: bold;

            cursor: pointer;

            margin-top: 5px;

            transition: 0.2s;
        }

        .btn-auth:hover {
            background: #1d4ed8;

            transform: translateY(-1px);
        }


        /* =========================
           USER
        ========================= */

        .user-section {
            display: none;

            text-align: center;
        }

        .avatar {
            width: 80px;
            height: 80px;

            margin: 0 auto 15px;

            border-radius: 50%;

            background: #2563eb;

            color: white;

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 30px;

            font-weight: bold;
        }

        .user-section h2 {
            color: #111827;

            margin-bottom: 7px;
        }

        .user-section p {
            color: #64748b;

            font-size: 14px;

            margin-bottom: 22px;
        }

        .btn-logout {
            width: 100%;

            padding: 12px;

            border: none;

            border-radius: 9px;

            background: #dc2626;

            color: white;

            font-weight: bold;

            cursor: pointer;
        }

        .btn-logout:hover {
            background: #b91c1c;
        }


        /* =========================
           FOOTER TEXT
        ========================= */

        .security-text {
            text-align: center;

            color: #94a3b8;

            font-size: 12px;

            margin-top: 20px;
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 750px) {

            .auth-box {
                grid-template-columns: 1fr;

                max-width: 500px;
            }

            .brand-section {
                display: none;
            }

            .form-section {
                padding: 35px 25px;
            }

        }

    </style>

</head>


<body>


<div class="auth-wrapper">

    <div class="auth-box">


        <!-- =========================
             BRANDING
        ========================= -->

        <div class="brand-section">

            <div class="brand-content">

                <div class="brand-logo">

                    Campus<span>Mart</span>

                </div>


                <h2 class="brand-title">

                    Semua kebutuhan
                    kampus dalam satu tempat.

                </h2>


                <p class="brand-description">

                    Platform CampusMart untuk
                    membeli merchandise kampus
                    dan menggunakan layanan
                    print & jilid dengan mudah.

                </p>


                <div class="feature">

                    <div class="feature-icon">
                        🛍️
                    </div>

                    <span>
                        Merchandise Kampus
                    </span>

                </div>


                <div class="feature">

                    <div class="feature-icon">
                        🖨️
                    </div>

                    <span>
                        Layanan Print & Jilid
                    </span>

                </div>


                <div class="feature">

                    <div class="feature-icon">
                        🔒
                    </div>

                    <span>
                        Akun yang aman
                    </span>

                </div>

            </div>

        </div>


        <!-- =========================
             FORM SECTION
        ========================= -->

        <div class="form-section">


            <!-- LOGIN & REGISTER -->

            <div id="authContent">


                <div class="form-header">

                    <h1>
                        Selamat Datang
                    </h1>

                    <p>
                        Kelola akun CampusMart kamu
                    </p>

                </div>


                <!-- TABS -->

                <div class="tabs">

                    <button
                        id="loginTab"
                        class="tab active"
                        onclick="showLogin()">

                        Login

                    </button>


                    <button
                        id="registerTab"
                        class="tab"
                        onclick="showRegister()">

                        Register

                    </button>

                </div>


                <!-- ALERT -->

                <div id="errorMessage"
                     class="alert alert-error">
                </div>


                <div id="successMessage"
                     class="alert alert-success">
                </div>


                <!-- =========================
                     LOGIN FORM
                ========================= -->

                <form id="loginForm">


                    <div class="form-group">

                        <label>
                            Email
                        </label>

                        <input
                            type="email"
                            id="loginEmail"
                            placeholder="Masukkan email"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Password
                        </label>

                        <input
                            type="password"
                            id="loginPassword"
                            placeholder="Masukkan password"
                            required
                        >

                    </div>


                    <button
                        type="submit"
                        class="btn-auth">

                        Login

                    </button>


                </form>


                <!-- =========================
                     REGISTER FORM
                ========================= -->

                <form
                    id="registerForm"
                    style="display:none;">

                    <div class="form-group">

                        <label>
                            Nama Lengkap
                        </label>

                        <input
                            type="text"
                            id="registerName"
                            placeholder="Masukkan nama lengkap"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            NIM
                        </label>

                        <input
                            type="text"
                            id="registerNim"
                            placeholder="Masukkan NIM"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Email
                        </label>

                        <input
                            type="email"
                            id="registerEmail"
                            placeholder="Masukkan email"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Password
                        </label>

                        <input
                            type="password"
                            id="registerPassword"
                            placeholder="Minimal 6 karakter"
                            required
                        >

                    </div>


                    <div class="form-group">

                        <label>
                            Konfirmasi Password
                        </label>

                        <input
                            type="password"
                            id="confirmPassword"
                            placeholder="Ulangi password"
                            required
                        >

                    </div>


                    <button
                        type="submit"
                        class="btn-auth">

                        Buat Akun

                    </button>

                </form>


                <div class="security-text">

                    🔒 Data akun kamu tetap aman

                </div>


            </div>


            <!-- =========================
                 USER LOGIN
            ========================= -->

            <div id="userSection"
                 class="user-section">


                <div id="avatar"
                     class="avatar">

                    U

                </div>


                <h2 id="userName">
                    User
                </h2>


                <p id="userEmail">
                    email@example.com
                </p>


                <button
                    class="btn-logout"
                    onclick="logout()">

                    Logout

                </button>


            </div>


        </div>

    </div>

</div>


<script>

    /*
    ===================================
    DATA USER SEMENTARA
    ===================================
    */

    let user = null;


    /*
    ===================================
    ELEMENT
    ===================================
    */

    const loginForm =
        document.getElementById("loginForm");

    const registerForm =
        document.getElementById("registerForm");

    const loginTab =
        document.getElementById("loginTab");

    const registerTab =
        document.getElementById("registerTab");

    const errorMessage =
        document.getElementById("errorMessage");

    const successMessage =
        document.getElementById("successMessage");


    /*
    ===================================
    HIDE ALERT
    ===================================
    */

    function hideAlert() {

        errorMessage.style.display = "none";

        successMessage.style.display = "none";

    }


    /*
    ===================================
    LOGIN TAB
    ===================================
    */

    function showLogin() {

        hideAlert();

        loginForm.style.display = "block";

        registerForm.style.display = "none";

        loginTab.classList.add("active");

        registerTab.classList.remove("active");

    }


    /*
    ===================================
    REGISTER TAB
    ===================================
    */

    function showRegister() {

        hideAlert();

        loginForm.style.display = "none";

        registerForm.style.display = "block";

        loginTab.classList.remove("active");

        registerTab.classList.add("active");

    }


    /*
    ===================================
    REGISTER
    ===================================
    */

    registerForm.addEventListener(
        "submit",
        function(event) {

            event.preventDefault();

            hideAlert();


            let name =
                document.getElementById(
                    "registerName"
                ).value;

            let nim =
                document.getElementById(
                    "registerNim"
                ).value;

            let email =
                document.getElementById(
                    "registerEmail"
                ).value;

            let password =
                document.getElementById(
                    "registerPassword"
                ).value;

            let confirmPassword =
                document.getElementById(
                    "confirmPassword"
                ).value;


            if (password.length < 6) {

                errorMessage.innerHTML =
                    "Password minimal 6 karakter.";

                errorMessage.style.display =
                    "block";

                return;

            }


            if (password !== confirmPassword) {

                errorMessage.innerHTML =
                    "Konfirmasi password tidak sama.";

                errorMessage.style.display =
                    "block";

                return;

            }


            user = {

                name: name,

                nim: nim,

                email: email,

                password: password

            };


            successMessage.innerHTML =
                "Akun berhasil dibuat. Silakan login.";

            successMessage.style.display =
                "block";


            registerForm.reset();


            setTimeout(function() {

                showLogin();

            }, 1200);

        }
    );


    /*
    ===================================
    LOGIN
    ===================================
    */

    loginForm.addEventListener(
        "submit",
        function(event) {

            event.preventDefault();

            hideAlert();


            let email =
                document.getElementById(
                    "loginEmail"
                ).value;

            let password =
                document.getElementById(
                    "loginPassword"
                ).value;


            if (user === null) {

                errorMessage.innerHTML =
                    "Akun belum tersedia. Silakan Register terlebih dahulu.";

                errorMessage.style.display =
                    "block";

                return;

            }


            if (email !== user.email) {

                errorMessage.innerHTML =
                    "Email tidak sesuai.";

                errorMessage.style.display =
                    "block";

                return;

            }


            if (password !== user.password) {

                errorMessage.innerHTML =
                    "Password salah.";

                errorMessage.style.display =
                    "block";

                return;

            }


            successMessage.innerHTML =
                "Login berhasil!";

            successMessage.style.display =
                "block";


            setTimeout(function() {

                showUser();

            }, 700);

        }
    );


    /*
    ===================================
    SHOW USER
    ===================================
    */

    function showUser() {

        document.getElementById(
            "authContent"
        ).style.display = "none";


        document.getElementById(
            "userSection"
        ).style.display = "block";


        document.getElementById(
            "userName"
        ).innerHTML = user.name;


        document.getElementById(
            "userEmail"
        ).innerHTML = user.email;


        document.getElementById(
            "avatar"
        ).innerHTML =
            user.name.charAt(0).toUpperCase();

    }


    /*
    ===================================
    LOGOUT
    ===================================
    */

    function logout() {

        user = null;


        document.getElementById(
            "userSection"
        ).style.display = "none";


        document.getElementById(
            "authContent"
        ).style.display = "block";


        loginForm.reset();


        showLogin();


        successMessage.innerHTML =
            "Kamu berhasil logout.";

        successMessage.style.display =
            "block";

    }

</script>


</body>

</html>