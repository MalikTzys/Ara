<?php
// File untuk testing login - hapus setelah selesai testing
include 'config/database.php';

echo "<h2>Test Database Connection</h2>";

// Test koneksi database
if ($conn) {
    echo "✅ Database connected successfully<br>";
} else {
    echo "❌ Database connection failed<br>";
    exit;
}

// Test query admin
$query = "SELECT * FROM admin";
$result = mysqli_query($conn, $query);

if ($result) {
    echo "✅ Admin table accessible<br>";
    echo "<h3>Admin Users:</h3>";
    while($row = mysqli_fetch_assoc($result)) {
        echo "Username: " . $row['username'] . " | Email: " . $row['email'] . "<br>";
    }
} else {
    echo "❌ Cannot access admin table: " . mysqli_error($conn) . "<br>";
}

// Test password hash
$test_password = "password";
$hash = password_hash($test_password, PASSWORD_DEFAULT);
echo "<h3>Password Hash Test:</h3>";
echo "Original: " . $test_password . "<br>";
echo "Hashed: " . $hash . "<br>";
echo "Verify: " . (password_verify($test_password, $hash) ? "✅ Valid" : "❌ Invalid") . "<br>";

// Test session
session_start();
echo "<h3>Session Test:</h3>";
echo "Session ID: " . session_id() . "<br>";
?>
