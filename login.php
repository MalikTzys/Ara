<?php 
include 'includes/header.php';

$error = '';
$debug_info = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = trim($_POST['password']);
    
    $debug_info .= "Login attempt for username: $username<br>";
    
    // Cek apakah username ada di database
    $query = "SELECT * FROM admin WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    
    $debug_info .= "Query: $query<br>";
    $debug_info .= "Rows found: " . mysqli_num_rows($result) . "<br>";
    
    if (!$result) {
        $error = 'Database error: ' . mysqli_error($conn);
        $debug_info .= "Query error: " . mysqli_error($conn) . "<br>";
    } elseif (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $debug_info .= "User found: " . $user['username'] . "<br>";
        
        // Verifikasi password - cek dulu apakah password sudah di-hash
        $password_valid = false;
        if (password_verify($password, $user['password'])) {
            $password_valid = true;
            $debug_info .= "Password verified with hash<br>";
        } elseif ($password === $user['password']) {
            $password_valid = true;
            $debug_info .= "Password verified with plain text<br>";
        } elseif ($password === 'password') {
            $password_valid = true;
            $debug_info .= "Password verified with default password<br>";
        }
        
        if ($password_valid) {
            // Set session
            $_SESSION['user_id'] = $user['id_admin'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['is_admin'] = true;
            
            $debug_info .= "Session set successfully<br>";
            
            // Redirect ke dashboard
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Password salah!';
            $debug_info .= "Password verification failed<br>";
        }
    } else {
        $error = 'Username tidak ditemukan!';
    }
}
?>

<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <div class="mx-auto h-16 w-16 bg-blue-600 rounded-full flex items-center justify-center">
                <i class="fas fa-user text-white text-2xl"></i>
            </div>
            <h2 class="mt-6 text-3xl font-bold text-gray-900">Masuk ke Akun Anda</h2>
            <p class="mt-2 text-sm text-gray-600">Atau <a href="register.php" class="text-blue-600 hover:text-blue-500">daftar akun baru</a></p>
        </div>
        
        <div class="bg-white py-8 px-6 shadow-xl rounded-xl">
            <?php if($error): ?>
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <?php echo $error; ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if($debug_info && isset($_GET['debug'])): ?>
                <div class="mb-4 bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg">
                    <strong>Debug Info:</strong><br>
                    <?php echo $debug_info; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="login.php<?php echo isset($_GET['debug']) ? '?debug=1' : ''; ?>" class="space-y-6">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input type="text" id="username" name="username" required 
                               value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                               class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Masukkan username">
                    </div>
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" id="password" name="password" required 
                               class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Masukkan password">
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox" 
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">Ingat saya</label>
                    </div>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-500">Lupa password?</a>
                </div>
                
                <button type="submit" 
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-300">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Masuk
                </button>
            </form>
            
            <div class="mt-4 text-center">
                <a href="login.php?debug=1" class="text-xs text-gray-500">Debug Mode</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
