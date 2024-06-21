<?php
// Koneksi ke database MySQL
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kedaikopi";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$customer_id = 1; 

$sql_total = "SELECT SUM(menu_items.price * orders.quantity) AS total_harga
              FROM orders
              JOIN menu_items ON orders.menu_id = menu_items.menu_id
              WHERE orders.customers_id = $customer_id";
$result_total = $conn->query($sql_total);

$total_harga = 0;

if ($result_total->num_rows > 0) {
    $row_total = $result_total->fetch_assoc();
    $total_harga = $row_total["total_harga"];
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kedai Santai</title>
    <link rel="stylesheet" href="CSS/pesanan.css">
    <script>
        function showLoadingMessage() {
            alert("Pesanan sedang dibuat, mohon tunggu...");
        }
    </script>
</head>
<body>
    <?php include "page/header.html"; ?>
    <div class="form-pes">
     <h1 class="head-pes">Pesanan</h1>
    <form action="proses_pesanan.php" method="POST" class="form-pesanan">
        <div class="form-group">
            <label for="total_harga" class="label-pes">Total Harga yang Harus Dibayar:</label>
            <input type="text" id="total_harga" name="total_harga" class="form-control" value="Rp <?php echo $total_harga !== null ? number_format($total_harga, 2) : '0.00'; ?>" readonly>
        </div>
        <center> <button type="submit" class="btn-pes" onclick="showLoadingMessage()">Submit Pesanan</button>
        <a href="javascript:history.go(-1);" class="a-pes">Kembali</a></center>
    </form>
    </div>

    <!-- Tombol Kembali -->
</body>
</html>
