<?php
// File debug untuk login - hapus setelah selesai
session_start();
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    echo "<h2>Debug Login Process</h2>";
    echo "Username: " . $username . "<br>";
    echo "Password: " . $password . "<br>";
    
    // Cek user di database
    $query = "SELECT * FROM admin WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    
    echo "Query: " . $query . "<br>";
    echo "Rows found: " . mysqli_num_rows($result) . "<br>";
    
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        echo "User found: " . $user['username'] . "<br>";
        echo "Stored password: " . $user['password'] . "<br>";
        
        // Test password verification
        $verify1 = password_verify($password, $user['password']);
        $verify2 = ($password === $user['password']);
        $verify3 = ($password === 'password');
        
        echo "Password verify (hash): " . ($verify1 ? "✅" : "❌") . "<br>";
        echo "Password verify (plain): " . ($verify2 ? "✅" : "❌") . "<br>";
        echo "Password verify (default): " . ($verify3 ? "✅" : "❌") . "<br>";
        
        if ($verify1 || $verify2 || $verify3) {
            $_SESSION['user_id'] = $user['id_admin'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_admin'] = true;
            echo "✅ Login successful! Redirecting...<br>";
            echo "<script>setTimeout(function(){ window.location.href = 'dashboard.php'; }, 2000);</script>";
        } else {
            echo "❌ Password verification failed<br>";
        }
    } else {
        echo "❌ User not found<br>";
    }
}
?>

<form method="POST">
    <h3>Test Login</h3>
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <button type="submit">Test Login</button>
</form>

<p>Try these credentials:</p>
<ul>
    <li>Username: admin, Password: password</li>
    <li>Username: admin1, Password: password</li>
    <li>Username: test, Password: password</li>
</ul>
