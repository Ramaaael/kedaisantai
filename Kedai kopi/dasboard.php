<?php
$servername ="localhost";
$username ="root";
$password ="";
$dbname ="kedaikopi";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$sql = "SELECT orders.menu_id, menu_items.name AS menu_name, menu_items.price, menu_items.image_url, orders.quantity, (menu_items.price * orders.quantity) AS total_price
        FROM orders
        JOIN menu_items ON orders.menu_id = menu_items.menu_id";
$result = $conn->query($sql);

if (!$result) {
    die("Query error: " . $conn->error);
}
?>
<html>
<head>
<title>Login Kasir Kopi Santai</title>
<link rel="stylesheet" type="text/css" href="CSS/style.css">

<style>
    .button {
        background-color: #b6895b;
        border: none;
        color: white;
        padding: 8px 16px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 4px;
    }
</style>

</head>
<body>
    <nav>
        <a href="listorder.php">Logout</a>
    </nav>
    <center>
        <h1>Kasir Pemesanan</h1>
        <table class="data-table">
            <caption class="title">Data Pembeli</caption>
            <thead class="head">
                <tr >
                    <th>NO</th>
                    <th>NAMA MENU</th>
                    <th>QUANTITY</th>
                    <th>PESANAN</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $no = 1;
                    while($row = $result->fetch_assoc()) {
                        // Initialize status text
                        $status_text = "";

                        // Check if status is set (if already updated)
                        if (isset($row["status"])) {
                            $status_text = $row["status"];
                        }

                        echo "<tr>
                                <td>".$no."</td>
                                <td>".$row["menu_name"]."</td>
                                <td>".$row["quantity"]."</td>
                                <td>
                                    <button class='button' onclick='selesaiDibuat(".$row["menu_id"].", \"Sudah Selesai\")'>Sudah Selesai</button>
                                    <button class='button' onclick='selesaiDibuat(".$row["menu_id"].", \"Pesanan dalam Proses\")'>Pesanan dalam Proses</button>
                                    <span id='status".$row["menu_id"]."'>".$status_text."</span>
                                </td>
                              </tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='4'>Tidak ada data</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </center>

    <script>
        function selesaiDibuat(menuId, status) {
            // Update status text
            document.getElementById("status" + menuId).innerHTML = status;
      
            // Optional: You can also send an AJAX request here to update the status in the database
            // Example using fetch API (modern approach)
            /*
            fetch('update_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ menuId: menuId, status: status }),
            })
            .then(response => response.json())
            .then(data => console.log(data))
            .catch(error => console.error('Error:', error));
            */
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
