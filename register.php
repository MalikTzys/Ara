<?php 
include 'includes/header.php';

$error = '';
$success = '';
$debug_info = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $email = mysqli_real_escape_string($conn, trim($_POST['email']));
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    
    $debug_info .= "Form submitted with username: $username, email: $email<br>";
    
    // Validasi input
    if (empty($username) || empty($email) || empty($password)) {
        $error = 'Semua field harus diisi!';
    } elseif ($password !== $confirm_password) {
        $error = 'Password tidak cocok!';
    } elseif (strlen($password) < 6) {
        $error = 'Password minimal 6 karakter!';
    } else {
        // Cek apakah username sudah ada
        $query = "SELECT * FROM admin WHERE username = '$username'";
        $result = mysqli_query($conn, $query);
        
        $debug_info .= "Username check query: $query<br>";
        $debug_info .= "Username check result: " . mysqli_num_rows($result) . " rows<br>";
        
        if (!$result) {
            $error = 'Database error: ' . mysqli_error($conn);
            $debug_info .= "Query error: " . mysqli_error($conn) . "<br>";
        } elseif (mysqli_num_rows($result) > 0) {
            $error = 'Username sudah digunakan!';
        } else {
            // Cek apakah email sudah ada
            $query = "SELECT * FROM admin WHERE email = '$email'";
            $result = mysqli_query($conn, $query);
            
            $debug_info .= "Email check query: $query<br>";
            $debug_info .= "Email check result: " . mysqli_num_rows($result) . " rows<br>";
            
            if (!$result) {
                $error = 'Database error: ' . mysqli_error($conn);
                $debug_info .= "Query error: " . mysqli_error($conn) . "<br>";
            } elseif (mysqli_num_rows($result) > 0) {
                $error = 'Email sudah digunakan!';
            } else {
                // Hash password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                // Insert user baru
                $query = "INSERT INTO admin (username, email, password) VALUES ('$username', '$email', '$hashed_password')";
                $debug_info .= "Insert query: $query<br>";
                
                if (mysqli_query($conn, $query)) {
                    $success = 'Registrasi berhasil! Silakan login.';
                    $debug_info .= "Insert successful! New user ID: " . mysqli_insert_id($conn) . "<br>";
                    
                    // Auto redirect ke login setelah 3 detik
                    echo "<script>
                        setTimeout(function() {
                            window.location.href = 'login.php';
                        }, 3000);
                    </script>";
                } else {
                    $error = 'Terjadi kesalahan: ' . mysqli_error($conn);
                    $debug_info .= "Insert error: " . mysqli_error($conn) . "<br>";
                }
            }
        }
    }
}
?>

<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div class="text-center">
            <div class="mx-auto h-16 w-16 bg-green-600 rounded-full flex items-center justify-center">
                <i class="fas fa-user-plus text-white text-2xl"></i>
            </div>
            <h2 class="mt-6 text-3xl font-bold text-gray-900">Daftar Akun Baru</h2>
            <p class="mt-2 text-sm text-gray-600">Atau <a href="login.php" class="text-blue-600 hover:text-blue-500">masuk ke akun yang sudah ada</a></p>
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
            
            <?php if($success): ?>
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle mr-2"></i>
                        <?php echo $success; ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if($debug_info && isset($_GET['debug'])): ?>
                <div class="mb-4 bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg">
                    <strong>Debug Info:</strong><br>
                    <?php echo $debug_info; ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="register.php<?php echo isset($_GET['debug']) ? '?debug=1' : ''; ?>" class="space-y-6">
                <div>
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                        <input type="text" id="username" name="username" required 
                               value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                               class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                               placeholder="Pilih username">
                    </div>
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input type="email" id="email" name="email" required 
                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                               class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                               placeholder="Masukkan email">
                    </div>
                </div>
                
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" id="password" name="password" required 
                               class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                               placeholder="Buat password">
                    </div>
                </div>
                
                <div>
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" id="confirm_password" name="confirm_password" required 
                               class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                               placeholder="Ulangi password">
                    </div>
                </div>
                
                <div class="flex items-center">
                    <input id="terms" name="terms" type="checkbox" required
                           class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                    <label for="terms" class="ml-2 block text-sm text-gray-700">
                        Saya setuju dengan <a href="#" class="text-blue-600 hover:text-blue-500">syarat dan ketentuan</a>
                    </label>
                </div>
                
                <button type="submit" 
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-300">
                    <i class="fas fa-user-plus mr-2"></i>
                    Daftar
                </button>
            </form>
            
            <div class="mt-4 text-center">
                <a href="register.php?debug=1" class="text-xs text-gray-500">Debug Mode</a>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
