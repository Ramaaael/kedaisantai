<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kedaikopi";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action'])) {
    $menu_id = $_POST['menu_id'];
    $quantity = $_POST['quantity'];

    if ($_POST['action'] == 'update_quantity') {
        if ($quantity > 0) {
            $stmt = $conn->prepare("UPDATE orders SET quantity = ? WHERE menu_id = ?");
            $stmt->bind_param("ii", $quantity, $menu_id);
            $stmt->execute();
            $stmt->close();
        } else {
            $stmt = $conn->prepare("DELETE FROM orders WHERE menu_id = ?");
            $stmt->bind_param("i", $menu_id);
            $stmt->execute();
            $stmt->close();
        }
    } elseif ($_POST['action'] == 'delete_item') {
        $stmt = $conn->prepare("DELETE FROM orders WHERE menu_id = ?");
        $stmt->bind_param("i", $menu_id);
        $stmt->execute();
        $stmt->close();
    }
}

$sql = "SELECT orders.menu_id, menu_items.name, menu_items.price, menu_items.image_url, orders.quantity, (menu_items.price * orders.quantity) AS total_price
        FROM orders
        JOIN menu_items ON orders.menu_id = menu_items.menu_id";
$result = $conn->query($sql);

$total_all = 0;

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kopi Santai</title>
    <link rel="stylesheet" href="CSS/keranjang.css">
</head>
<body>
<?php include "page/header.html"; ?>
   
<div class="container">
    <center><h1 class="head-ker">Keranjang Belanja</h1></center>
    <form action="" method="POST" class="form-pes">
        <table width="90%" style="text-align:center;">
            <tr class="list-ker">
                <th>Menu</th>
                <th>Nama</th>
                <th>Harga Satuan</th>
                <th>Quantity</th>
                <th>Harga Total</th>
                <th>Hapus Pesanan</th>
            </tr>

            <?php 
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $total_all += $row["total_price"];
                    ?>
                    <tr>
                        <td><img src="<?php echo $row["image_url"]; ?>" width="100" height="100"></td>
                        <td><?php echo $row["name"]; ?></td>
                        <td>Rp <?php echo number_format($row["price"], 2); ?></td>
                        <td>
                            <form action="" method="POST" style="display:inline-block;">
                                <input type="hidden" name="menu_id" value="<?php echo $row["menu_id"]; ?>">
                                <input type="hidden" name="quantity" value="<?php echo ($row["quantity"] - 1); ?>">
                                <input type="hidden" name="action" value="update_quantity">
                                <button type="submit" name="update_quantity">-</button>
                            </form>
                            <?php echo $row["quantity"]; ?>
                            <form action="" method="POST" style="display:inline-block;">
                                <input type="hidden" name="menu_id" value="<?php echo $row["menu_id"]; ?>">
                                <input type="hidden" name="quantity" value="<?php echo ($row["quantity"] + 1); ?>">
                                <input type="hidden" name="action" value="update_quantity">
                                <button type="submit" name="update_quantity">+</button>
                            </form>
                        </td>
                        <td>Rp <?php echo number_format($row["total_price"], 2); ?></td>
                        <td>
                            <form action="" method="POST">
                                <input type="hidden" name="menu_id" value="<?php echo $row["menu_id"]; ?>">
                                <input type="hidden" name="quantity" value="0">
                                <input type="hidden" name="action" value="delete_item">
                                <button type="submit" name="delete_item">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                <tr >
                    <td colspan="4" style="text-align:right;"><strong>Total Keseluruhan</strong></td>
                    <td ><strong>Rp <?php echo number_format($total_all, 2); ?></strong></td>
                    <td></td>
                </tr>
                <?php
            } else {
                echo "<tr><td colspan='6'>Keranjang belanja kosong.</td></tr>";
            }
            ?>
        </table>
    </form>
</div>
<center><a class="btn-pes" href="pesanan.php">Pesan Sekarang</a></center>

</body>
</html>