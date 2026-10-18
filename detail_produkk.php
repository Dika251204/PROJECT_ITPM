%%html

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <title>Detail Produk - CampusMart</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
        }

        /* NAVBAR */
        .navbar {
            background-color: white;
            padding: 20px 50px;

            display: flex;
            justify-content: space-between;
            align-items: center;

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

        /* CONTAINER */
        .container {
            width: 80%;
            margin: 50px auto;
        }

        /* PRODUK */
        .product {
            background-color: white;

            padding: 30px;

            display: flex;

            gap: 40px;

            border-radius: 10px;

            box-shadow: 0 3px 10px #ddd;
        }

        /* GAMBAR */
        .gambar {
            width: 40%;
            height: 350px;

            background-color: #eee;

            display: flex;

            justify-content: center;
            align-items: center;

            font-size: 120px;

            border-radius: 10px;
        }

        /* DETAIL */
        .detail {
            width: 60%;
        }

        .kategori {
            color: #4f46e5;
            font-weight: bold;
        }

        h1 {
            font-size: 35px;
        }

        .harga {
            font-size: 28px;
            font-weight: bold;
            color: #4f46e5;
        }

        .deskripsi {
            color: #666;
            line-height: 1.6;
        }

        .stok {
            margin: 20px 0;
        }

        input {
            width: 60px;
            padding: 10px;
            margin-bottom: 20px;
        }

        button {
            display: block;

            width: 100%;

            padding: 15px;

            background-color: #4f46e5;

            color: white;

            border: none;

            border-radius: 7px;

            font-size: 16px;

            cursor: pointer;
        }

        button:hover {
            background-color: #3730a3;
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


    <!-- DETAIL PRODUK -->

    <div class="container">

        <div class="product">


            <!-- GAMBAR -->

            <div class="gambar">
                🧥
            </div>


            <!-- INFORMASI PRODUK -->

            <div class="detail">

                <div class="kategori">
                    Hoodie
                </div>

                <h1>
                    Hoodie Campus
                </h1>

                <div class="harga">
                    Rp175.000
                </div>

                <p class="deskripsi">

                    Hoodie Campus dengan bahan yang nyaman
                    dan cocok digunakan untuk kegiatan
                    perkuliahan maupun kegiatan sehari-hari.

                </p>

                <div class="stok">

                    <b>Stok:</b> 15 produk

                </div>


                <label>

                    <b>Jumlah:</b>

                </label>

                <br>

                <input
                    type="number"
                    value="1"
                    min="1"
                    max="15"
                >


                <button
                    onclick="alert('Produk berhasil ditambahkan ke keranjang!')">

                    🛒 Tambah ke Keranjang

                </button>

            </div>

        </div>

    </div>


</body>

</html>