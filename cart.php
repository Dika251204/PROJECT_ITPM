%%html

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Keranjang - CampusMart</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f5f5f5;
            color: #333;
        }

        /* NAVBAR */

        .navbar {
            background: white;
            padding: 18px 8%;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .nav-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            text-decoration: none;
            font-size: 24px;
            font-weight: bold;
            color: #222;
        }

        .logo span {
            color: #4f46e5;
        }

        nav a {
            text-decoration: none;
            color: #333;
            margin-left: 20px;
        }

        nav a:hover {
            color: #4f46e5;
        }

        /* SECTION */

        .section {
            padding: 50px 8%;
        }

        .container {
            max-width: 900px;
            margin: auto;
        }

        .page-title {
            text-align: center;
            margin-bottom: 30px;
            font-size: 32px;
        }

        /* CART ITEM */

        .cart-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .cart-item {
            background: white;
            padding: 20px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }

        .cart-icon {
            width: 70px;
            height: 70px;
            background: #f0f0ff;
            border-radius: 10px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 35px;
        }

        .cart-info {
            flex: 1;
        }

        .cart-info h3 {
            margin-bottom: 8px;
        }

        .cart-info p {
            margin: 4px 0;
            color: #666;
        }

        .cart-subtotal {
            font-size: 18px;
            font-weight: bold;
            color: #4f46e5;
        }

        /* SUMMARY */

        .cart-summary {
            background: white;
            margin-top: 25px;
            padding: 25px;
            border-radius: 12px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }

        .cart-summary h2 {
            color: #222;
        }

        /* BUTTON */

        .btn {
            display: inline-block;
            padding: 13px 22px;
            border-radius: 8px;
            text-decoration: none;
            cursor: pointer;
            border: none;
            font-weight: bold;
        }

        .btn-primary {
            background: #4f46e5;
            color: white;
        }

        .btn-primary:hover {
            background: #3730a3;
        }

        /* EMPTY CART */

        .empty-cart {
            background: white;
            text-align: center;
            padding: 50px 20px;
            border-radius: 15px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.08);
        }

        .empty-cart h2 {
            margin-bottom: 10px;
        }

        .empty-cart p {
            color: #666;
            margin-bottom: 25px;
        }

        /* FOOTER */

        footer {
            background: #222;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 50px;
        }

        /* RESPONSIVE */

        @media(max-width: 700px) {

            .nav-content {
                flex-direction: column;
                gap: 15px;
            }

            nav {
                text-align: center;
            }

            nav a {
                display: inline-block;
                margin: 5px;
            }

            .cart-item {
                flex-direction: column;
                text-align: center;
            }

            .cart-summary {
                flex-direction: column;
                gap: 20px;
                text-align: center;
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

    </div>

</header>


<!-- KERANJANG -->

<section class="section">

    <div class="container">

        <h1 class="page-title">
            Keranjang Belanja
        </h1>


        <!-- PRODUK 1 -->

        <div class="cart-list">

            <div class="cart-item">

                <div class="cart-icon">
                    🧥
                </div>

                <div class="cart-info">

                    <h3>
                        Hoodie Campus
                    </h3>

                    <p>
                        Rp 175.000
                    </p>

                    <p>
                        Jumlah: 1
                    </p>

                </div>

                <div class="cart-subtotal">

                    Rp 175.000

                </div>

            </div>


            <!-- PRODUK 2 -->

            <div class="cart-item">

                <div class="cart-icon">
                    👕
                </div>

                <div class="cart-info">

                    <h3>
                        T-Shirt Kampus
                    </h3>

                    <p>
                        Rp 85.000
                    </p>

                    <p>
                        Jumlah: 2
                    </p>

                </div>

                <div class="cart-subtotal">

                    Rp 170.000

                </div>

            </div>

        </div>


        <!-- TOTAL -->

        <div class="cart-summary">

            <h2>
                Total: Rp 345.000
            </h2>

            <button
                class="btn btn-primary"
                onclick="checkout()">

                Checkout

            </button>

        </div>

    </div>

</section>


<!-- FOOTER -->

<footer>

    © 2026 CampusMart

</footer>


<script>

function checkout() {

    alert("Melanjutkan ke halaman Checkout...");

}

</script>


</body>

</html>