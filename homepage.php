%%html

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Navbar CampusMart</title>

    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f3f6fb;
        }

        .navbar {
            background: white;
            padding: 18px 40px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .nav-content {
            max-width: 1200px;
            margin: auto;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 30px;
        }

        .logo {
            font-size: 26px;
            font-weight: bold;
            color: #2563eb;
            text-decoration: none;
        }

        .logo span {
            color: #111827;
        }

        nav {
            display: flex;
            gap: 25px;
        }

        nav a {
            color: #374151;
            text-decoration: none;
            font-size: 15px;
            font-weight: 500;
        }

        nav a:hover {
            color: #2563eb;
        }

        @media (max-width: 700px) {

            .nav-content {
                flex-direction: column;
            }

            nav {
                flex-wrap: wrap;
                justify-content: center;
            }

        }

    </style>

</head>

<body>


<header class="navbar">

    <div class="nav-content">


        <!-- LOGO -->

        <a href="#" class="logo">
            Campus<span>Mart</span>
        </a>


        <!-- MENU -->

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
                Dashboard
            </a>

        </nav>


    </div>

</header>


</body>

</html>