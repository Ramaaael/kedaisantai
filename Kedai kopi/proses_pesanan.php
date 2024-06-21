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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $total_harga_raw = $_POST["total_harga"];
    
    $total_harga_numeric = (float) str_replace('Rp ', '', $total_harga_raw);
    
    $customer_id = 1; // Misalnya ID pelanggan yang sedang login atau sedang memesan
    $sql_order_details = "SELECT menu_items.name AS nama_barang, orders.quantity, (menu_items.price * orders.quantity) AS subtotal
                          FROM orders
                          JOIN menu_items ON orders.menu_id = menu_items.menu_id
                          WHERE orders.customers_id = $customer_id";

    $result_order_details = $conn->query($sql_order_details);


    if ($result_order_details->num_rows > 0) {
        echo '<div class="container">';
        echo '<center><h1 class="title">Struk Pesanan</h1></center>';
        
        while ($row = $result_order_details->fetch_assoc()) {
            echo '<div class="item">';
            echo '<span>' . $row["nama_barang"] . ' - ' . $row["quantity"] . ' pcs</span>';
            echo '<span style="float: right;">Rp ' . number_format($row["subtotal"], 2) . '</span>';
            echo '</div>';
        }
        
        echo '<div style="text-align: right; margin-top: 20px; font-weight: bold;">';
        echo 'Total Harga: Rp ' . number_format($total_harga_numeric, 3);
        echo '</div>';
        
        echo '</div>'; 
    } else {
        echo "Tidak ada pesanan yang ditemukan.";
    }
} else {
    echo "Akses tidak sah.";
}
echo '<center><a href="index.php" class="a-back">Kembali</a></center>';

// Menutup koneksi database
$conn->close();
?>
<link rel="stylesheet" href="CSS/proses_pesanan.css">