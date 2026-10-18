%%html

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Upload Dokumen - CampusMart</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f5f7fb;
            margin: 0;
            color: #333;
        }

        /* NAVBAR */

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

        /* CONTAINER */

        .container {
            width: 80%;
            max-width: 700px;
            margin: 40px auto;
        }

        /* CARD */

        .card {
            background: white;
            padding: 30px;

            border-radius: 10px;

            box-shadow: 0 3px 10px #ddd;
        }

        h1 {
            margin-bottom: 10px;
        }

        .description {
            color: #666;
            margin-bottom: 25px;
        }

        /* INFORMASI FILE */

        .file-info {
            background: #eff6ff;
            color: #1d4ed8;

            padding: 15px;

            border-radius: 8px;

            margin-bottom: 25px;
        }

        /* FORM */

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;

            font-weight: bold;

            margin-bottom: 8px;
        }

        input,
        select,
        textarea {
            width: 100%;

            padding: 12px;

            border: 1px solid #ccc;

            border-radius: 7px;

            box-sizing: border-box;

            font-size: 14px;
        }

        textarea {
            resize: vertical;
        }

        /* BUTTON */

        button {
            width: 100%;

            padding: 14px;

            background: #4f46e5;

            color: white;

            border: none;

            border-radius: 7px;

            font-size: 16px;

            cursor: pointer;
        }

        button:hover {
            background: #3730a3;
        }

        .back {
            display: inline-block;

            margin-top: 20px;

            text-decoration: none;

            color: #4f46e5;

            font-weight: bold;
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

        <a href="#">Merchandise</a>

        <a href="#">Print & Jilid</a>

        <a href="#">Keranjang</a>

        <a href="#">Dashboard</a>

    </div>

</div>



<!-- UPLOAD DOKUMEN -->

<div class="container">

    <div class="card">

        <h1>
            Upload Dokumen
        </h1>

        <p class="description">

            Upload dokumen yang ingin dicetak
            melalui layanan CampusMart.

        </p>


        <!-- INFORMASI -->

        <div class="file-info">

            <b>Format yang diperbolehkan:</b>
            PDF, DOC, DOCX

            <br><br>

            <b>Ukuran maksimal:</b>
            5 MB

        </div>


        <!-- FORM -->

        <form>


            <!-- JENIS DOKUMEN -->

            <div class="form-group">

                <label>
                    Jenis Dokumen
                </label>

                <select required>

                    <option value="">
                        -- Pilih Jenis Dokumen --
                    </option>

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


            <!-- UKURAN KERTAS -->

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


            <!-- JUMLAH HALAMAN -->

            <div class="form-group">

                <label>
                    Jumlah Halaman
                </label>

                <input
                    type="number"
                    min="1"
                    placeholder="Masukkan jumlah halaman"
                    required>

            </div>


            <!-- FILE -->

            <div class="form-group">

                <label>
                    Pilih Dokumen
                </label>

                <input
                    type="file"
                    accept=".pdf,.doc,.docx"
                    required>

            </div>


            <!-- CATATAN -->

            <div class="form-group">

                <label>
                    Catatan
                </label>

                <textarea
                    rows="4"
                    placeholder="Contoh: Cetak bolak-balik, warna, jilid, dll."></textarea>

            </div>


            <!-- BUTTON -->

            <button
                type="button"
                onclick="uploadDokumen()">

                📤 Upload Dokumen

            </button>


        </form>


        <a href="#"
           class="back">

            ← Kembali ke Dashboard

        </a>

    </div>

</div>



<script>

function uploadDokumen() {

    alert("Dokumen berhasil dipilih dan siap untuk diproses!");

}

</script>


</body>

</html>