%%html

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Profile - CampusMart</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: #f5f5f5;
        }

        /* NAVBAR */
        .navbar {
            background: white;
            padding: 18px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
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

        .menu a {
            text-decoration: none;
            color: #333;
            margin-left: 20px;
        }

        .menu a:hover {
            color: #4f46e5;
        }

        .logout {
            color: red !important;
        }

        /* CONTAINER */
        .container {
            width: 90%;
            max-width: 700px;
            margin: 50px auto;
        }

        /* PROFILE CARD */
        .profile-card {
            background: white;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 3px 15px rgba(0,0,0,0.08);
        }

        .profile-card h1 {
            text-align: center;
            margin-bottom: 25px;
        }

        /* AVATAR */
        .avatar {
            width: 90px;
            height: 90px;
            background: #4f46e5;
            color: white;
            border-radius: 50%;
            margin: 0 auto 25px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 35px;
            font-weight: bold;
        }

        /* DATA PROFILE */
        .profile-data {
            margin-bottom: 20px;
        }

        .profile-data label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .profile-data input {
            width: 100%;
            padding: 13px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #f9f9f9;
        }

        /* BUTTON */
        .btn {
            display: block;
            width: 100%;
            padding: 13px;
            background: #4f46e5;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 8px;
            border: none;
            margin-top: 10px;
            cursor: pointer;
        }

        .btn:hover {
            background: #3730a3;
        }

        /* RESPONSIVE */
        @media(max-width: 700px) {

            .navbar {
                flex-direction: column;
                gap: 15px;
            }

            .menu {
                display: flex;
                flex-wrap: wrap;
                justify-content: center;
            }

            .menu a {
                margin: 5px;
            }
        }
    </style>

</head>

<body>

<!-- NAVBAR -->

<div class="navbar">

    <a href="#" class="logo">
        Campus<span>Mart</span>
    </a>

    <div class="menu">

        <a href="#">Home</a>

        <a href="#">Merchandise</a>

        <a href="#">Print & Jilid</a>

        <a href="#">Keranjang</a>

        <a href="#">Dashboard</a>

        <a href="#">Profile</a>

        <a href="#" class="logout" onclick="logout()">
            Logout
        </a>

    </div>

</div>


<!-- PROFILE -->

<div class="container">

    <div class="profile-card">

        <h1>Profile Saya</h1>


        <!-- AVATAR -->

        <div class="avatar">
            R
        </div>


        <!-- NAMA -->

        <div class="profile-data">

            <label>Nama Lengkap</label>

            <input
                type="text"
                value="Rizma Rahmadani"
                readonly
            >

        </div>


        <!-- NIM -->

        <div class="profile-data">

            <label>NIM</label>

            <input
                type="text"
                value="123456789"
                readonly
            >

        </div>


        <!-- EMAIL -->

        <div class="profile-data">

            <label>Email</label>

            <input
                type="email"
                value="rizma@email.com"
                readonly
            >

        </div>


        <!-- BUTTON -->

        <a href="#" class="btn" onclick="dashboard()">
            Kembali ke Dashboard
        </a>

    </div>

</div>


<script>

function dashboard() {
    alert("Kembali ke Dashboard");
}

function logout() {
    alert("Anda berhasil logout");
}

</script>

</body>

</html>