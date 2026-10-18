%%html

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Dashboard Mahasiswa - CampusMart</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f1f5f9;
            color: #111827;
        }

        /* =========================
           NAVBAR
        ========================= */

        .navbar {
            background: white;
            padding: 18px 7%;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .nav-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            text-decoration: none;
            font-size: 25px;
            font-weight: bold;
            color: #2563eb;
        }

        .logo span {
            color: #111827;
        }

        nav {
            display: flex;
            gap: 24px;
        }

        nav a {
            text-decoration: none;
            color: #374151;
            font-size: 14px;
        }

        nav a:hover {
            color: #2563eb;
        }

        .logout {
            background: #fee2e2;
            color: #dc2626;
            padding: 9px 15px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: bold;
        }

        /* =========================
           CONTAINER
        ========================= */

        .container {
            width: 86%;
            max-width: 1200px;
            margin: auto;
        }

        /* =========================
           DASHBOARD
        ========================= */

        .dashboard {
            padding: 40px 0;
        }

        .welcome {
            background: linear-gradient(
                135deg,
                #2563eb,
                #1d4ed8
            );

            color: white;

            padding: 30px;

            border-radius: 18px;

            margin-bottom: 30px;
        }

        .welcome h1 {
            font-size: 28px;
            margin-bottom: 8px;
        }

        .welcome p {
            color: #dbeafe;
            font-size: 15px;
        }

        /* =========================
           QUICK MENU
        ========================= */

        .section-title {
            font-size: 21px;
            margin-bottom: 18px;
        }

        .menu-grid {
            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 18px;

            margin-bottom: 35px;
        }

        .menu-card {
            background: white;

            padding: 23px;

            border-radius: 14px;

            text-decoration: none;

            color: #111827;

            box-shadow:
                0 4px 12px rgba(0,0,0,0.06);

            transition: 0.2s;
        }

        .menu-card:hover {
            transform: translateY(-4px);

            box-shadow:
                0 8px 20px rgba(0,0,0,0.1);
        }

        .menu-icon {
            width: 48px;
            height: 48px;

            background: #eff6ff;

            border-radius: 12px;

            display: flex;

            align-items: center;
            justify-content: center;

            font-size: 24px;

            margin-bottom: 14px;
        }

        .menu-card h3 {
            font-size: 16px;
            margin-bottom: 6px;
        }

        .menu-card p {
            font-size: 13px;
            color: #64748b;
            line-height: 1.5;
        }

        /* =========================
           CONTENT GRID
        ========================= */

        .content-grid {
            display: grid;

            grid-template-columns:
                1fr 1fr;

            gap: 22px;
        }

        .card {
            background: white;

            border-radius: 15px;

            padding: 25px;

            box-shadow:
                0 4px 12px rgba(0,0,0,0.06);
        }

        .card-title {
            font-size: 18px;

            margin-bottom: 20px;
        }

        /* =========================
           PROFILE
        ========================= */

        .profile {
            display: flex;

            align-items: center;

            gap: 15px;
        }

        .avatar {
            width: 60px;
            height: 60px;

            border-radius: 50%;

            background: #2563eb;

            color: white;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 23px;

            font-weight: bold;
        }

        .profile-info h3 {
            margin-bottom: 5px;
        }

        .profile-info p {
            color: #64748b;

            font-size: 13px;

            margin-bottom: 3px;
        }

        /* =========================
           ORDER
        ========================= */

        .order {
            display: flex;

            justify-content: space-between;

            align-items: center;

            padding: 14px 0;

            border-bottom: 1px solid #e5e7eb;
        }

        .order:last-child {
            border-bottom: none;
        }

        .order-info h4 {
            margin-bottom: 5px;
        }

        .order-info p {
            color: #64748b;

            font-size: 13px;
        }

        .status {
            padding: 6px 10px;

            border-radius: 20px;

            background: #dcfce7;

            color: #15803d;

            font-size: 12px;

            font-weight: bold;
        }

        .status-process {
            background: #fef3c7;

            color: #b45309;
        }

        /* =========================
           FOOTER
        ========================= */

        footer {
            margin-top: 30px;

            background: #111827;

            color: white;

            text-align: center;

            padding: 25px;

            font-size: 14px;
        }

        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 900px) {

            .menu-grid {
                grid-template-columns:
                    repeat(2, 1fr);
            }

        }

        @media (max-width: 650px) {

            .nav-content {
                flex-direction: column;

                gap: 15px;
            }

            nav {
                flex-wrap: wrap;

                justify-content: center;

                gap: 15px;
            }

            .menu-grid {
                grid-template-columns: 1fr;
            }

            .content-grid {
                grid-template-columns: 1fr;
            }

            .container {
                width: 92%;
            }

        }

    </style>

</head>


<body>


<!-- =========================
     NAVBAR
========================= -->

<header class="navbar">

    <div class="nav-content">

        <a href="#" class="logo">
            Campus<span>Mart</span>
        </a>


        <nav>

            <a href="#">
                Home
            </a>

            <a href="#">
                Merchandise
            </a>

            <a href="#">
                Print & Jilid
            </a>

            <a href="#">
                Keranjang
            </a>

            <a href="#">
                Profile
            </a>

        </nav>


        <a href="#"
           class="logout"
           onclick="logout()">

            Logout

        </a>

    </div>

</header>


<!-- =========================
     DASHBOARD
========================= -->

<main class="dashboard">

    <div class="container">


        <!-- WELCOME -->

        <div class="welcome">

            <h1>
                Selamat Datang, Rizma! 👋
            </h1>

            <p>
                Kelola kebutuhan kampusmu dengan mudah
                melalui CampusMart.
            </p>

        </div>


        <!-- MENU -->

        <h2 class="section-title">
            Menu Utama
        </h2>


        <div class="menu-grid">


            <!-- MERCHANDISE -->

            <a href="#"
               class="menu-card"
               onclick="openMenu('Merchandise')">

                <div class="menu-icon">
                    🛍️
                </div>

                <h3>
                    Merchandise
                </h3>

                <p>
                    Belanja merchandise kampus
                    favoritmu.
                </p>

            </a>


            <!-- PRINT -->

            <a href="#"
               class="menu-card"
               onclick="openMenu('Print & Jilid')">

                <div class="menu-icon">
                    🖨️
                </div>

                <h3>
                    Print & Jilid
                </h3>

                <p>
                    Cetak dan jilid dokumen
                    dengan mudah.
                </p>

            </a>


            <!-- CART -->

            <a href="#"
               class="menu-card"
               onclick="openMenu('Keranjang')">

                <div class="menu-icon">
                    🛒
                </div>

                <h3>
                    Keranjang
                </h3>

                <p>
                    Lihat barang yang sudah
                    kamu pilih.
                </p>

            </a>


            <!-- TRACKING -->

            <a href="#"
               class="menu-card"
               onclick="openMenu('Tracking Pesanan')">

                <div class="menu-icon">
                    📦
                </div>

                <h3>
                    Tracking Pesanan
                </h3>

                <p>
                    Pantau status pesananmu.
                </p>

            </a>


        </div>


        <!-- CONTENT -->

        <div class="content-grid">


            <!-- PROFILE -->

            <div class="card">

                <h2 class="card-title">
                    Informasi Mahasiswa
                </h2>


                <div class="profile">

                    <div class="avatar">
                        R
                    </div>


                    <div class="profile-info">

                        <h3>
                            Rizma Rahmadani
                        </h3>

                        <p>
                            NIM: 123456789
                        </p>

                        <p>
                            rizma@email.com
                        </p>

                    </div>

                </div>

            </div>


            <!-- PESANAN -->

            <div class="card">

                <h2 class="card-title">
                    Pesanan Terbaru
                </h2>


                <div class="order">

                    <div class="order-info">

                        <h4>
                            #CM001
                        </h4>

                        <p>
                            Hoodie Campus
                        </p>

                    </div>

                    <span class="status">
                        Dikirim
                    </span>

                </div>


                <div class="order">

                    <div class="order-info">

                        <h4>
                            #CM002
                        </h4>

                        <p>
                            Print & Jilid
                        </p>

                    </div>

                    <span class="status status-process">
                        Diproses
                    </span>

                </div>


            </div>

        </div>

    </div>

</main>


<!-- =========================
     FOOTER
========================= -->

<footer>

    © 2026 CampusMart

</footer>


<script>

    function openMenu(menu) {

        alert(
            "Menu " + menu +
            " dipilih."
        );

    }


    function logout() {

        alert(
            "Anda berhasil logout."
        );

    }

</script>


</body>

</html>