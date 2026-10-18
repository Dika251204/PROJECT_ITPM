%%html

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Print & Jilid - CampusMart</title>

    <style>

        * {
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            margin: 0;
            background: #f5f7fb;
            color: #333;
        }


        /* =====================
           NAVBAR
        ===================== */

        .navbar {
            background: white;
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

        .menu a:hover {
            color: #4f46e5;
        }


        /* =====================
           CONTAINER
        ===================== */

        .container {
            width: 90%;
            max-width: 1000px;
            margin: auto;
        }


        /* =====================
           HEADER
        ===================== */

        .print-header {
            text-align: center;
            margin: 50px 0 35px;
        }

        .print-header h1 {
            font-size: 36px;
            margin-bottom: 10px;
        }

        .print-header p {
            color: #64748b;
        }


        /* =====================
           LAYANAN
        ===================== */

        .print-grid {
            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 20px;

            margin-bottom: 40px;
        }

        .print-card {
            background: white;

            padding: 25px;

            border-radius: 12px;

            text-align: center;

            box-shadow: 0 3px 10px #ddd;
        }

        .print-icon {
            font-size: 45px;
            margin-bottom: 15px;
        }

        .print-card h2 {
            font-size: 20px;
        }

        .print-card p {
            color: #64748b;
            line-height: 1.5;
        }

        .price {
            color: #2563eb;
            font-weight: bold;
            font-size: 18px;
        }


        /* =====================
           FORM
        ===================== */

        .order-box {
            background: white;

            padding: 30px;

            border-radius: 12px;

            box-shadow: 0 3px 10px #ddd;

            margin-bottom: 40px;
        }

        .order-box h2 {
            text-align: center;
        }

        .order-description {
            text-align: center;
            color: #64748b;
            margin-bottom: 25px;
        }

        .info-box {
            background: #eff6ff;

            color: #1d4ed8;

            padding: 15px;

            border-radius: 8px;

            margin-bottom: 25px;

            line-height: 1.6;
        }

        .form-row {
            display: grid;

            grid-template-columns: 1fr 1fr;

            gap: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;

            font-weight: bold;

            margin-bottom: 8px;
        }

        select,
        textarea {
            width: 100%;

            padding: 12px;

            border: 1px solid #ccc;

            border-radius: 7px;

            font-size: 14px;
        }

        textarea {
            resize: vertical;
        }


        /* =====================
           BUTTON
        ===================== */

        button {
            width: 100%;

            padding: 14px;

            background: #2563eb;

            color: white;

            border: none;

            border-radius: 8px;

            font-size: 16px;

            font-weight: bold;

            cursor: pointer;
        }

        button:hover {
            background: #1d4ed8;
        }


        /* =====================
           CARA PEMESANAN
        ===================== */

        .process-section {
            margin-bottom: 50px;
        }

        .process-section h2 {
            text-align: center;

            margin-bottom: 25px;
        }

        .process-grid {
            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 15px;
        }

        .process-item {
            background: white;

            padding: 20px;

            border-radius: 10px;

            text-align: center;

            box-shadow: 0 3px 10px #ddd;
        }

        .process-number {
            width: 45px;

            height: 45px;

            margin: auto;

            margin-bottom: 10px;

            background: #2563eb;

            color: white;

            border-radius: 50%;

            display: flex;

            align-items: center;

            justify-content: center;

            font-weight: bold;

            font-size: 18px;
        }

        .process-item p {
            color: #64748b;

            font-size: 14px;

            line-height: 1.5;
        }


        /* =====================
           FOOTER
        ===================== */

        footer {
            background: white;

            text-align: center;

            padding: 20px;

            color: #777;
        }


        /* =====================
           RESPONSIVE
        ===================== */

        @media (max-width: 700px) {

            .navbar {
                flex-direction: column;

                gap: 15px;

                padding: 20px;
            }

            .menu {
                display: flex;

                flex-wrap: wrap;

                justify-content: center;
            }

            .menu a {
                margin: 5px;
            }

            .print-grid {
                grid-template-columns: 1fr;
            }

            .process-grid {
                grid-template-columns: 1fr;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

        }

    </style>

</head>


<body>


<!-- =====================
     NAVBAR
===================== -->

<header class="navbar">

    <div class="logo">

        Campus<span>Mart</span>

    </div>


    <nav class="menu">

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
            Dashboard
        </a>

    </nav>

</header>



<!-- =====================
     CONTENT
===================== -->

<div class="container">


    <!-- JUDUL -->

    <div class="print-header">

        <h1>
            Print & Jilid
        </h1>

        <p>
            Cetak tugas, makalah, laporan,
            dan dokumen kuliah dengan mudah.
        </p>

    </div>



    <!-- =====================
         LAYANAN
    ===================== -->

    <div class="print-grid">


        <!-- PRINT HITAM PUTIH -->

        <div class="print-card">

            <div class="print-icon">
                🖨️
            </div>

            <h2>
                Print Hitam Putih
            </h2>

            <p>
                Layanan cetak dokumen
                hitam putih dengan hasil
                jelas dan rapi.
            </p>

            <div class="price">
                Rp 500 / halaman
            </div>

        </div>



        <!-- PRINT WARNA -->

        <div class="print-card">

            <div class="print-icon">
                🌈
            </div>

            <h2>
                Print Warna
            </h2>

            <p>
                Cetak dokumen berwarna
                untuk tugas, laporan,
                dan kebutuhan lainnya.
            </p>

            <div class="price">
                Rp 1.500 / halaman
            </div>

        </div>



        <!-- JILID -->

        <div class="print-card">

            <div class="print-icon">
                📚
            </div>

            <h2>
                Jilid Dokumen
            </h2>

            <p>
                Jilid dokumen agar lebih
                rapi, kuat, dan mudah
                digunakan.
            </p>

            <div class="price">
                Mulai Rp 5.000
            </div>

        </div>

    </div>



    <!-- =====================
         FORM PESANAN
    ===================== -->

    <div class="order-box">

        <h2>
            Pesan Print & Jilid
        </h2>

        <p class="order-description">

            Pilih jenis dokumen dan ukuran
            kertas yang ingin digunakan.

        </p>


        <!-- INFORMASI -->

        <div class="info-box">

            <b>Informasi:</b>

            <br>

            Format dokumen yang diterima:
            PDF, DOC, dan DOCX.

            <br>

            Ukuran maksimal file:
            5 MB.

        </div>


        <form>


            <!-- JENIS + UKURAN -->

            <div class="form-row">


                <div class="form-group">

                    <label>
                        Jenis Dokumen
                    </label>

                    <select>

                        <option>
                            Makalah
                        </option>

                        <option>
                            Tugas Kuliah
                        </option>

                        <option>
                            Skripsi
                        </option>

                        <option>
                            Laporan
                        </option>

                        <option>
                            Materi
                        </option>

                        <option>
                            Dokumen Lainnya
                        </option>

                    </select>

                </div>



                <div class="form-group">

                    <label>
                        Ukuran Kertas
                    </label>

                    <select>

                        <option>
                            A4
                        </option>

                        <option>
                            A5
                        </option>

                        <option>
                            F4
                        </option>

                    </select>

                </div>

            </div>



            <!-- CATATAN -->

            <div class="form-group">

                <label>
                    Catatan Pesanan
                </label>

                <textarea
                    rows="4"
                    placeholder="Contoh: Print warna, bolak-balik, jilid, dll.">
                </textarea>

            </div>



            <!-- BUTTON -->

            <button
                type="button"
                onclick="pesan()">

                📤 Upload Dokumen & Lanjutkan

            </button>


        </form>

    </div>



    <!-- =====================
         CARA PEMESANAN
    ===================== -->

    <div class="process-section">

        <h2>
            Cara Menggunakan Layanan
        </h2>


        <div class="process-grid">


            <div class="process-item">

                <div class="process-number">
                    1
                </div>

                <h3>
                    Login
                </h3>

                <p>
                    Login menggunakan akun
                    mahasiswa CampusMart.
                </p>

            </div>



            <div class="process-item">

                <div class="process-number">
                    2
                </div>

                <h3>
                    Upload
                </h3>

                <p>
                    Upload file dokumen
                    yang ingin dicetak.
                </p>

            </div>



            <div class="process-item">

                <div class="process-number">
                    3
                </div>

                <h3>
                    Pilih Layanan
                </h3>

                <p>
                    Tentukan jenis print,
                    ukuran kertas, dan jilid.
                </p>

            </div>



            <div class="process-item">

                <div class="process-number">
                    4
                </div>

                <h3>
                    Selesai
                </h3>

                <p>
                    Tunggu pesanan diproses
                    dan ambil hasil cetakan.
                </p>

            </div>


        </div>

    </div>

</div>



<!-- FOOTER -->

<footer>

    © 2026 CampusMart

</footer>



<script>

function pesan() {

    alert(
        "Silakan pilih dokumen dan lanjutkan proses pemesanan."
    );

}

</script>


</body>

</html>