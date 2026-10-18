%%html

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Katalog - CampusMart</title>

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
            padding: 18px 8%;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .nav-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            text-decoration: none;
            font-size: 24px;
            font-weight: bold;
            color: #222;
        }

        .logo span {
            color: #2563eb;
        }

        nav {
            display: flex;
            gap: 25px;
        }

        nav a {
            text-decoration: none;
            color: #333;
            font-size: 15px;
        }

        nav a:hover {
            color: #2563eb;
        }

        .btn {
            display: inline-block;
            padding: 10px 18px;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-outline {
            border: 1px solid #2563eb;
            color: #2563eb;
        }

        .btn-outline:hover {
            background: #2563eb;
            color: white;
        }

        /* SECTION */
        .section {
            padding: 50px 8%;
        }

        .page-title {
            text-align: center;
            font-size: 32px;
            margin-bottom: 10px;
        }

        .page-subtitle {
            text-align: center;
            color: #777;
            margin-bottom: 40px;
        }

        /* PRODUCT GRID */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 25px;
        }

        /* PRODUCT CARD */
        .product-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
            transition: 0.3s;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 18px rgba(0,0,0,0.12);
        }

        .product-image {
            height: 180px;
            background: #eef2ff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 70px;
        }

        .product-content {
            padding: 20px;
        }

        .product-category {
            font-size: 13px;
            color: #2563eb;
            margin-bottom: 8px;
        }

        .product-content h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .product-price {
            font-size: 19px;
            font-weight: bold;
            color: #16a34a;
            margin-bottom: 8px;
        }

        .stock {
            font-size: 14px;
            color: #777;
            margin-bottom: 15px;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
            width: 100%;
            text-align: center;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        /* FOOTER */
        footer {
            margin-top: 50px;
            padding: 25px;
            background: #222;
            color: white;
            text-align: center;
        }

        /* RESPONSIVE */
        @media (max-width: 700px) {

            .nav-content {
                flex-direction: column;
                gap: 15px;
            }

            nav {
                flex-wrap: wrap;
                justify-content: center;
            }

            .page-title {
                font-size: 26px;
            }

        }

    </style>

</head>

<body>

<!-- NAVBAR -->
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

        </nav>

        <a href="#" class="btn btn-outline"
           onclick="login()">
            Login
        </a>

    </div>

</header>


<!-- KATALOG -->
<section class="section">

    <h1 class="page-title">
        Katalog Merchandise
    </h1>

    <p class="page-subtitle">
        Pilih merchandise kampus yang kamu inginkan.
    </p>


    <div class="product-grid">


        <!-- PRODUK 1 -->
        <div class="product-card">

            <div class="product-image">
                🧥
            </div>

            <div class="product-content">

                <div class="product-category">
                    Fashion
                </div>

                <h3>
                    Hoodie Campus
                </h3>

                <div class="product-price">
                    Rp 175.000
                </div>

                <p class="stock">
                    Stok: 15
                </p>

                <a href="#" 
                   class="btn btn-primary"
                   onclick="detail('Hoodie Campus')">

                    Lihat Detail

                </a>

            </div>

        </div>


        <!-- PRODUK 2 -->
        <div class="product-card">

            <div class="product-image">
                👕
            </div>

            <div class="product-content">

                <div class="product-category">
                    Fashion
                </div>

                <h3>
                    T-Shirt Kampus
                </h3>

                <div class="product-price">
                    Rp 85.000
                </div>

                <p class="stock">
                    Stok: 25
                </p>

                <a href="#" 
                   class="btn btn-primary"
                   onclick="detail('T-Shirt Kampus')">

                    Lihat Detail

                </a>

            </div>

        </div>


        <!-- PRODUK 3 -->
        <div class="product-card">

            <div class="product-image">
                🎒
            </div>

            <div class="product-content">

                <div class="product-category">
                    Aksesoris
                </div>

                <h3>
                    Tas Kampus
                </h3>

                <div class="product-price">
                    Rp 120.000
                </div>

                <p class="stock">
                    Stok: 10
                </p>

                <a href="#" 
                   class="btn btn-primary"
                   onclick="detail('Tas Kampus')">

                    Lihat Detail

                </a>

            </div>

        </div>


        <!-- PRODUK 4 -->
        <div class="product-card">

            <div class="product-image">
                🧢
            </div>

            <div class="product-content">

                <div class="product-category">
                    Aksesoris
                </div>

                <h3>
                    Topi Campus
                </h3>

                <div class="product-price">
                    Rp 60.000
                </div>

                <p class="stock">
                    Stok: 20
                </p>

                <a href="#" 
                   class="btn btn-primary"
                   onclick="detail('Topi Campus')">

                    Lihat Detail

                </a>

            </div>

        </div>


        <!-- PRODUK 5 -->
        <div class="product-card">

            <div class="product-image">
                📓
            </div>

            <div class="product-content">

                <div class="product-category">
                    Alat Tulis
                </div>

                <h3>
                    Notebook Campus
                </h3>

                <div class="product-price">
                    Rp 35.000
                </div>

                <p class="stock">
                    Stok: 30
                </p>

                <a href="#" 
                   class="btn btn-primary"
                   onclick="detail('Notebook Campus')">

                    Lihat Detail

                </a>

            </div>

        </div>


        <!-- PRODUK 6 -->
        <div class="product-card">

            <div class="product-image">
                🖊️
            </div>

            <div class="product-content">

                <div class="product-category">
                    Alat Tulis
                </div>

                <h3>
                    Pulpen Campus
                </h3>

                <div class="product-price">
                    Rp 15.000
                </div>

                <p class="stock">
                    Stok: 50
                </p>

                <a href="#" 
                   class="btn btn-primary"
                   onclick="detail('Pulpen Campus')">

                    Lihat Detail

                </a>

            </div>

        </div>


    </div>

</section>


<!-- FOOTER -->
<footer>

    © 2026 CampusMart

</footer>


<script>

function login() {

    alert("Silakan login untuk melanjutkan.");

}

function detail(namaProduk) {

    alert(
        "Detail Produk: " + namaProduk
    );

}

</script>

</body>
</html>
