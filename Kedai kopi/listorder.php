<!DOCTYPE html>
<html>
<head>
    <title>Login Kasir Kopi</title>
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body class="body">
    <nav>
        <a href="index.php">Kembali</a>
    </nav>
    <center>
        <form action="" name="form" method="POST" class="login">
        <h1 class="taglogin">Login Kasir</h1>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="submit" name="submit">
    </form>

<?php
if(isset($_POST['submit'])){
    // Informasi koneksi database
    $servername = "localhost";
    $username = "root";
    $password = ""; // Isi dengan password MySQL Anda jika ada
    $dbname = "kedaikopi";

    // Buat koneksi ke database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Periksa koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Lakukan query untuk memeriksa keberadaan pengguna di tabel
    $sql = "SELECT * FROM loginkasir WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<p>Login berhasil!</p>";
        // Redirect ke halaman dashboard jika login berhasil
        header("Location: dasboard.php");
        exit();
    } else {
        echo "<p>Login gagal. Silakan coba lagi.</p>";
    }

    // Tutup koneksi
    $conn->close();
}
?>
</center>
</body>
</html>
