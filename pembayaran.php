%%html

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Pembayaran - CampusMart</title>

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

            padding: 18px 8%;

            box-shadow:
                0 2px 10px rgba(0,0,0,0.08);
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

            color: #2563eb;
        }

        .logo span {
            color: #111827;
        }

        nav {
            display: flex;

            gap: 25px;
        }

        nav a {
            text-decoration: none;

            color: #374151;

            font-size: 14px;
        }

        nav a:hover {
            color: #2563eb;
        }


        /* =========================
           SECTION
        ========================= */

        .section {
            min-height: 75vh;

            padding: 50px 20px;

            display: flex;

            justify-content: center;

            align-items: flex-start;
        }


        /* =========================
           PAYMENT CARD
        ========================= */

        .payment-card {
            width: 100%;

            max-width: 500px;

            background: white;

            padding: 35px;

            border-radius: 18px;

            box-shadow:
                0 10px 30px rgba(0,0,0,0.08);
        }

        .payment-card h1 {
            font-size: 28px;

            margin-bottom: 8px;

            text-align: center;
        }

        .order-number {
            text-align: center;

            color: #64748b;

            font-size: 14px;

            margin-bottom: 25px;
        }


        /* =========================
           TOTAL
        ========================= */

        .payment-total {
            background: #eff6ff;

            border: 1px solid #dbeafe;

            padding: 20px;

            border-radius: 12px;

            margin-bottom: 25px;

            color: #475569;

            font-size: 14px;
        }

        .payment-total strong {
            display: block;

            margin-top: 8px;

            font-size: 25px;

            color: #2563eb;
        }


        /* =========================
           FORM
        ========================= */

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;

            margin-bottom: 8px;

            font-size: 14px;

            font-weight: bold;

            color: #374151;
        }

        .form-group select {
            width: 100%;

            padding: 13px;

            border: 1px solid #cbd5e1;

            border-radius: 9px;

            background: white;

            font-size: 14px;

            outline: none;

            cursor: pointer;
        }

        .form-group select:focus {
            border-color: #2563eb;

            box-shadow:
                0 0 0 3px rgba(37,99,235,0.10);
        }


        /* =========================
           BUTTON
        ========================= */

        .btn-primary {
            width: 100%;

            padding: 14px;

            border: none;

            border-radius: 9px;

            background: #2563eb;

            color: white;

            font-size: 15px;

            font-weight: bold;

            cursor: pointer;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }


        /* =========================
           SUCCESS
        ========================= */

        .success-message {
            display: none;

            margin-top: 20px;

            padding: 15px;

            border-radius: 9px;

            background: #dcfce7;

            color: #15803d;

            font-size: 14px;

            text-align: center;
        }


        /* =========================
           FOOTER
        ========================= */

        footer {
            background: #111827;

            color: white;

            text-align: center;

            padding: 25px;

            font-size: 14px;
        }


        /* =========================
           RESPONSIVE
        ========================= */

        @media (max-width: 600px) {

            .nav-content {
                flex-direction: column;

                gap: 15px;
            }

            nav {
                gap: 15px;

                flex-wrap: wrap;

                justify-content: center;
            }

            .payment-card {
                padding: 25px 20px;
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
                Tracking
            </a>

            <a href="#">
                Profile
            </a>

        </nav>

    </div>

</header>


<!-- =========================
     PEMBAYARAN
========================= -->

<section class="section">

    <div class="payment-card">

        <h1>
            Pembayaran
        </h1>

        <p class="order-number">
            Pesanan #CM001
        </p>


        <!-- TOTAL PEMBAYARAN -->

        <div class="payment-total">

            Total Pembayaran

            <strong>
                Rp 345.000
            </strong>

        </div>


        <!-- FORM PEMBAYARAN -->

        <form id="paymentForm">


            <div class="form-group">

                <label for="metode">
                    Pilih Metode Pembayaran
                </label>

                <select
                    id="metode"
                    required>

                    <option value="">
                        -- Pilih Pembayaran --
                    </option>

                    <option value="Transfer Bank">
                        Transfer Bank
                    </option>

                    <option value="QRIS">
                        QRIS
                    </option>

                    <option value="E-Wallet">
                        E-Wallet
                    </option>

                    <option value="COD">
                        COD
                    </option>

                </select>

            </div>


            <button
                type="submit"
                class="btn-primary">

                Konfirmasi Pembayaran

            </button>


        </form>


        <!-- PESAN BERHASIL -->

        <div
            id="successMessage"
            class="success-message">

        </div>


    </div>

</section>


<!-- =========================
     FOOTER
========================= -->

<footer>

    © 2026 CampusMart

</footer>


<script>

    document.getElementById("paymentForm")
        .addEventListener("submit", function(event) {

            event.preventDefault();


            let metode =
                document.getElementById("metode").value;


            let success =
                document.getElementById("successMessage");


            if (metode === "") {

                alert(
                    "Silakan pilih metode pembayaran."
                );

                return;

            }


            success.innerHTML =
                "Pembayaran berhasil dikonfirmasi menggunakan <b>"
                + metode +
                "</b>.";


            success.style.display = "block";


            document.getElementById("paymentForm")
                .reset();

        });

</script>


</body>

</html>