%%html

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>CampusMart - Responsive Design</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f5f7fb;
            color: #333;
        }

        /* NAVBAR */
        .navbar {
            background: white;
            padding: 15px 7%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
            text-decoration: none;
        }

        .logo span {
            color: #111827;
        }

        .nav-menu {
            display: flex;
            gap: 25px;
            list-style: none;
        }

        .nav-menu a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
        }

        .nav-menu a:hover {
            color: #2563eb;
        }

        /* HERO */
        .hero {
            max-width: 1200px;
            margin: 40px auto;
            padding: 50px;
            background: white;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 30px;
        }

        .hero-text {
            flex: 1;
        }

        .hero-text h1 {
            font-size: 42px;
            margin-bottom: 15px;
            color: #111827;
        }

        .hero-text p {
            font-size: 17px;
            line-height: 1.7;
            color: #666;
            margin-bottom: 25px;
        }

        .btn {
            display: inline-block;
            background: #2563eb;
            color: white;
            padding: 12px 22px;
            border-radius: 8px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background: #1d4ed8;
        }

        .hero-image {
            flex: 1;
            text-align: center;
            font-size: 130px;
        }

        /* CARD */
        .container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .section-title {
            text-align: center;
            margin-bottom: 30px;
        }

        .section-title h2 {
            font-size: 30px;
            margin-bottom: 10px;
        }

        .section-title p {
            color: #777;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 3px 12px rgba(0,0,0,0.07);
        }

        .card-icon {
            font-size: 50px;
            margin-bottom: 15px;
        }

        .card h3 {
            margin-bottom: 10px;
        }

        .card p {
            color: #777;
            line-height: 1.6;
            margin-bottom: 20px;
        }

        /* FOOTER */
        footer {
            margin-top: 50px;
            background: #111827;
            color: white;
            text-align: center;
            padding: 25px;
        }

        /* ========================= */
        /* TABLET */
        /* ========================= */

        @media (max-width: 900px) {

            .navbar {
                padding: 15px 4%;
            }

            .nav-menu {
                gap: 15px;
            }

            .hero {
                margin: 30px 20px;
                padding: 35px;
            }

            .hero-text h1 {
                font-size: 34px;
            }

            .cards {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* ========================= */
        /* HP / MOBILE */
        /* ========================= */

        @media (max-width: 600px) {

            .navbar {
                flex-direction: column;
                gap: 15px;
                padding: 15px;
            }

            .nav-menu {
                width: 100%;
                display: grid;
                grid-template-columns: repeat(2, 1fr);
                gap: 10px;
                text-align: center;
            }

            .nav-menu a {
                display: block;
                padding: 8px;
                background: #f3f4f6;
                border-radius: 6px;
            }

            .hero {
                margin: 20px 15px;
                padding: 30px 20px;
                flex-direction: column;
                text-align: center;
            }

            .hero-text h1 {
                font-size: 30px;
            }

            .hero-text p {
                font-size: 15px;
            }

            .hero-image {
                font-size: 90px;
            }

            .cards {
                grid-template-columns: 1fr;
            }

            .container {
                padding: 0 15px;
            }

            .section-title h2 {
                font-size: 25px;
            }

            .card {
                padding: 20px;
            }

            footer {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar">

        <a href="#" class="logo">
            Campus<span>Mart</span>
        </a>

        <ul class="nav-menu">
            <li><a href="#">Home</a></li>
            <li><a href="#">Merchandise</a></li>
            <li><a href="#">Print & Jilid</a></li>
            <li><a href="#">Keranjang</a></li>
            <li><a href="#">Dashboard</a></li>
        </ul>

    </nav>


    <!-- HERO -->
    <section class="hero">

        <div class="hero-text">

            <h1>
                Selamat Datang di CampusMart
            </h1>

            <p>
                Platform kebutuhan mahasiswa untuk membeli
                merchandise kampus serta menggunakan layanan
                print dan jilid dengan mudah.
            </p>

            <a href="#" class="btn">
                Mulai Belanja
            </a>

        </div>

        <div class="hero-image">
            🎓
        </div>

    </section>


    <!-- LAYANAN -->
    <div class="container">

        <div class="section-title">

            <h2>
                Layanan CampusMart
            </h2>

            <p>
                Pilih layanan yang kamu butuhkan
            </p>

        </div>


        <div class="cards">

            <div class="card">

                <div class="card-icon">
                    👕
                </div>

                <h3>
                    Merchandise
                </h3>

                <p>
                    Temukan berbagai merchandise
                    kampus dengan harga terjangkau.
                </p>

                <a href="#" class="btn">
                    Lihat Produk
                </a>

            </div>


            <div class="card">

                <div class="card-icon">
                    🖨️
                </div>

                <h3>
                    Print & Jilid
                </h3>

                <p>
                    Cetak dokumen dan pilih layanan
                    jilid sesuai kebutuhan.
                </p>

                <a href="#" class="btn">
                    Pesan Sekarang
                </a>

            </div>


            <div class="card">

                <div class="card-icon">
                    📦
                </div>

                <h3>
                    Tracking Pesanan
                </h3>

                <p>
                    Pantau status pesanan kamu
                    dengan mudah.
                </p>

                <a href="#" class="btn">
                    Lacak Pesanan
                </a>

            </div>

        </div>

    </div>


    <!-- FOOTER -->
    <footer>

        <p>
            © 2026 CampusMart. All Rights Reserved.
        </p>

    </footer>

</body>
</html>