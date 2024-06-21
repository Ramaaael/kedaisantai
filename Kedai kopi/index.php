<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kedaikopi";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents('php://input'), true);
    
    if (isset($data['itemId']) && isset($data['quantity'])) {
        $menu_id = $data['itemId'];
        $quantity = $data['quantity'];
        
        $customers_id = 1; 

        $sql = "INSERT INTO orders (customers_id, menu_id, quantity) VALUES (?, ?, ?)";
        
        $stmt = $conn->prepare($sql);
        
        $stmt->bind_param("iii", $customers_id, $menu_id, $quantity);
        
        if ($stmt->execute()) {
            header('Location: keranjang.php');
            exit();
        } else {
            echo "Gagal menambahkan pesanan ke keranjang: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Data yang diperlukan tidak lengkap.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- FONT FAMILY -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link
    href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css"
    rel="stylesheet"
/>
    <!-- FEATHER ICONS -->
    <script src="https://unpkg.com/feather-icons"></script>


    <!-- MY STYLE -->
        <link rel="stylesheet" href="css/style.css">
<title>Kopi Santai</title>

</head>


<body>
    <!-- NAVBAR START -->
   <?php include "page/header.html"; ?>
    <!-- NAVBAR END -->

    <!-- Hero Section Start -->
    <section class="hero" id="home">
        <main class="content">
            <h1 style="margin-right: 70%; margin-bottom: 15%; font-size: 3rem;">Kopiku <span>Inspirasiku</span></h1>
            <center><a href="#" class="cta">Beli Sekarang</a></center>
        </main>
    </section>
    <!-- Hero Section End -->

    <!-- About Section Start -->
    <section id="about" class="about">
        <h2><span>Tentang</span> Kami</h2>

        <div class="row">
            <div class="about-img">
                <img src="img/tentang-kami.jpg.jpg" alt="Tentang Kami">
            </div>
            <div class="content">
                <h3>Kenapa memilih kopi kami?</h3>
                <p>Jika hadirmu sekedar ada, tapi tak memberikan rasa sepertinya kopi ini lebih baik darimu. Walaupun Pahit, hangatnya lebih terasa dimalam dingin. </p>
                <p>Hitam seperti Hilmy, Murni seperti Putra, Manis seperti senyuman Ipul</p>
            </div>
        </div>
    </section>
    <!-- About Section End -->

    <!-- Menu Section Start -->
    <section id="menu" class="menu">
        <h2><span>Menu</span> Kami</h2>
        <center>
        <ul class="list-nav-menu">
        <li>
            <a href="#minuman" class="name-nav-list">Minuman</a>
        </li>
        <li>
            <a href="#makanan" class="name-nav-list">Makanan</a>
        </li>
        </ul>
        </center>
        
    <?php include "page/menu.html"; ?>
    
</section>
    <!-- Menu Section End -->
<hr>
    <!-- Contact Section Start -->
    
    <!-- Contact Section End -->

    <!-- Footer Start -->
    <footer>
        <div class="socials">
            <a href="#"><i data-feather="instagram"></i></a>
            <a href="#"><i data-feather="twitter"></i></a>
            <a href="#"><i data-feather="facebook"></i></a>
        </div>

        <div class="links">
            <a href="#home">Home</a>
            <a href="#about">Tentang Kami</a>
            <a href="#menu">Menu</a>
            <a href="#order">pesanan</a>
        </div>

        <div class="credit">
            <p>Created By <a href= >Rafka AlFazri</a> | &copy;2024</p>
        </div>
    </footer>
    <!-- Footer End -->

    <!-- FEATHER ICONS -->
    <script>
        feather.replace();
    </script>

    <!-- My Javascript -->
    <script src="js/script.js"></script>
</body>


</html>