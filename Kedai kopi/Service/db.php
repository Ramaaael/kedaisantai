<?php 
$servername ="localhost";
$username ="root";
$password ="";
$dbname ="kedaikopi";

$conn = new mysqli($servername, $username, $password, $dbname);
if (!$conn){
    die ('Gagal Terhubung:' . mysqli_connect_error());
}
$sql = 'SELECT * FROM tabelpesanan';

$query = mysqli_query($conn, $sql);


if (!$query) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>