<?php
// Konfigurasi database
$host = "localhost";
$username = "root";
$password = "arch";
$database = "webalumni";

// Membuat koneksi
$conn = mysqli_connect($host, $username, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Set charset untuk menghindari masalah encoding
mysqli_set_charset($conn, "utf8");

// Test koneksi (hapus setelah testing)
if (isset($_GET['test'])) {
    echo "Database connected successfully!<br>";
    echo "Host: " . $host . "<br>";
    echo "Database: " . $database . "<br>";
    
    // Test query
    $test_query = "SHOW TABLES";
    $result = mysqli_query($conn, $test_query);
    echo "Tables in database:<br>";
    while($row = mysqli_fetch_array($result)) {
        echo "- " . $row[0] . "<br>";
    }
}
?>
