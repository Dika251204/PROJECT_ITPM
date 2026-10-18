%%html

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tracking Pesanan - CampusMart</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fb;
            margin: 0;
            color: #333;
        }

        .navbar {
            background: white;
            padding: 20px 50px;
            display: flex;
            justify-content: space-between;
            box-shadow: 0 2px 5px #ddd;
        }

        .logo {
            font-size: 24px;
            font-weight: bold;
        }

        .logo span {
            color: #4f46e5;
        }

        .menu a {
            text-decoration: none;
            color: #333;
            margin-left: 20px;
        }

        .container {
            width: 80%;
            max-width: 800px;
            margin: 40px auto;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 3px 10px #ddd;
        }

        .header {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #ddd;
            padding-bottom: 20px;
        }

        .status {
            background: #dbeafe;
            color: #2563eb;
            padding: 8px 15px;
            border-radius: 20px;
            font-weight: bold;
        }

        .info {
            margin-top: 25px;
        }

        .info p {
            margin: 10px 0;
        }

        .product {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }

        .tracking {
            margin-top: 30px;
        }

        .tracking-item {
            padding: 15px;
            border-left: 4px solid #ddd;
            margin-left: 10px;
        }

        .tracking-item.active {
            border-left-color: #4f46e5;
        }

        .tracking-item h3 {
            margin: 0 0 5px;
            color: #777;
        }

        .tracking-item.active h3 {
            color: #4f46e5;
        }

        .resi {
            color: #4f46e5;
            font-weight: bold;
        }

        .btn {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 20px;
            background: #4f46e5;
            color: white;
            text-decoration: none;
            border-radius: 7px;
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->

    <div class="navbar">

        <div class="logo">
            Campus<span>Mart</span>
        </div>

        <div class="menu">
            <a href="#">Home</a>
            <a href="#">Produk</a>
            <a href="#">Keranjang</a>
            <a href="#">Profile</a>
        </div>

    </div>


    <!-- CONTENT -->

    <div class="container">

        <div class="card">

            <div class="header">

                <div>
                    <h2>Tracking Pesanan</h2>
                    <p>Pesanan #CM001</p>
                </div>

                <div class="status">
                    Dikirim
                </div>

            </div>


            <!-- INFORMASI PESANAN -->

            <div class="info">

                <p>
                    <b>Tanggal Pesanan:</b>
                    01 Oktober 2026
                </p>

                <p>
                    <b>Total Pembayaran:</b>
                    Rp175.000
                </p>

            </div>


            <!-- PRODUK -->

            <div class="product">

                <h3>Hoodie Campus</h3>

                <p>Jumlah: 1 produk</p>

                <p>Harga: Rp175.000</p>

            </div>


            <!-- TRACKING -->

            <div class="tracking">

                <h2>Status Pesanan</h2>

                <div class="tracking-item active">

                    <h3>✓ Pesanan Diterima</h3>

                    <p>
                        Pesanan berhasil diterima oleh CampusMart.
                    </p>

                </div>


                <div class="tracking-item active">

                    <h3>✓ Diproses</h3>

                    <p>
                        Pesanan sedang diproses oleh penjual.
                    </p>

                </div>


                <div class="tracking-item active">

                    <h3>✓ Dikemas</h3>

                    <p>
                        Pesanan sedang disiapkan dan dikemas.
                    </p>

                </div>


                <div class="tracking-item active">

                    <h3>✓ Dikirim</h3>

                    <p>
                        Pesanan sedang dalam perjalanan.
                    </p>

                </div>


                <div class="tracking-item">

                    <h3>5. Selesai</h3>

                    <p>
                        Pesanan telah sampai kepada pelanggan.
                    </p>

                </div>

            </div>


            <!-- KURIR -->

            <div class="product">

                <h3>Informasi Pengiriman</h3>

                <p>
                    Kurir: <b>JNE</b>
                </p>

                <p>
                    Nomor Resi:
                    <span class="resi">
                        JNE123456789
                    </span>
                </p>

            </div>


            <a href="#" class="btn">
                ← Kembali ke Dashboard
            </a>

        </div>

    </div>

</body>

</html>