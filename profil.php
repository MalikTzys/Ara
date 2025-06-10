<?php 
include 'includes/header.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$admin_id = $_SESSION['user_id'];
$success = '';
$error = '';

// Ambil data admin
$query = "SELECT * FROM admin WHERE id_admin = $admin_id";
$result = mysqli_query($conn, $query);
$admin = mysqli_fetch_assoc($result);

// Update profil
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validasi username dan email
    if (empty($username) || empty($email)) {
        $error = 'Username dan email tidak boleh kosong!';
    } else {
        // Cek apakah username sudah digunakan oleh user lain
        $query = "SELECT * FROM admin WHERE username = '$username' AND id_admin != $admin_id";
        $result = mysqli_query($conn, $query);
        
        if (mysqli_num_rows($result) > 0) {
            $error = 'Username sudah digunakan!';
        } else {
            // Cek apakah email sudah digunakan oleh user lain
            $query = "SELECT * FROM admin WHERE email = '$email' AND id_admin != $admin_id";
            $result = mysqli_query($conn, $query);
            
            if (mysqli_num_rows($result) > 0) {
                $error = 'Email sudah digunakan!';
            } else {
                // Update username dan email
                $query = "UPDATE admin SET username = '$username', email = '$email' WHERE id_admin = $admin_id";
                
                if (mysqli_query($conn, $query)) {
                    $_SESSION['username'] = $username;
                    $success = 'Profil berhasil diperbarui!';
                    
                    // Update data admin
                    $query = "SELECT * FROM admin WHERE id_admin = $admin_id";
                    $result = mysqli_query($conn, $query);
                    $admin = mysqli_fetch_assoc($result);
                } else {
                    $error = 'Terjadi kesalahan: ' . mysqli_error($conn);
                }
                
                // Jika user ingin mengubah password
                if (!empty($current_password)) {
                    // Verifikasi password lama
                    if (password_verify($current_password, $admin['password'])) {
                        // Validasi password baru
                        if ($new_password === $confirm_password) {
                            // Hash password baru
                            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                            
                            // Update password
                            $query = "UPDATE admin SET password = '$hashed_password' WHERE id_admin = $admin_id";
                            
                            if (mysqli_query($conn, $query)) {
                                $success = 'Profil dan password berhasil diperbarui!';
                            } else {
                                $error = 'Terjadi kesalahan: ' . mysqli_error($conn);
                            }
                        } else {
                            $error = 'Password baru tidak cocok!';
                        }
                    } else {
                        $error = 'Password lama salah!';
                    }
                }
            }
        }
    }
}
?>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Profil Saya</h1>
                    <p class="text-gray-600">Kelola informasi profil Anda</p>
                </div>
                <a href="dashboard.php" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali ke Dashboard
                </a>
            </div>
        </div>
        
        <!-- Alerts -->
        <?php if($success): ?>
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center">
                    <i class="fas fa-check-circle mr-2"></i>
                    <?php echo $success; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <?php if($error): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                <div class="flex items-center">
                    <i class="fas fa-exclamation-circle mr-2"></i>
                    <?php echo $error; ?>
                </div>
            </div>
        <?php endif; ?>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Profile Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                    <div class="w-24 h-24 bg-blue-500 rounded-full mx-auto mb-4 flex items-center justify-center text-white text-3xl font-bold">
                        <?php echo strtoupper(substr($admin['username'], 0, 1)); ?>
                    </div>
                    <h2 class="text-xl font-bold text-gray-900 mb-1"><?php echo $admin['username']; ?></h2>
                    <p class="text-gray-600 mb-4"><?php echo $admin['email']; ?></p>
                    <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium inline-block">
                        Administrator
                    </div>
                </div>
                
                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-lg p-6 mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <a href="dashboard.php" class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300 flex items-center">
                            <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                        </a>
                        <a href="admin/index.php" class="w-full bg-gray-600 text-white py-2 px-4 rounded-lg hover:bg-gray-700 transition duration-300 flex items-center">
                            <i class="fas fa-cogs mr-2"></i>Admin Panel
                        </a>
                        <a href="logout.php" class="w-full bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition duration-300 flex items-center">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Edit Form -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Edit Profil</h3>
                    </div>
                    <div class="p-6">
                        <form method="POST" action="" class="space-y-6">
                            <!-- Basic Information -->
                            <div>
                                <h4 class="text-md font-semibold text-gray-900 mb-4">Informasi Dasar</h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="username" class="block text-sm font-medium text-gray-700 mb-2">Username</label>
                                        <input type="text" id="username" name="username" value="<?php echo $admin['username']; ?>" required
                                               class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                        <input type="email" id="email" name="email" value="<?php echo $admin['email']; ?>" required
                                               class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Password Change -->
                            <div class="border-t border-gray-200 pt-6">
                                <h4 class="text-md font-semibold text-gray-900 mb-4">Ubah Password</h4>
                                <div class="space-y-4">
                                    <div>
                                        <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Password Saat Ini</label>
                                        <input type="password" id="current_password" name="current_password"
                                               class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <p class="text-sm text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah password</p>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label for="new_password" class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                                            <input type="password" id="new_password" name="new_password"
                                                   class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                        <div>
                                            <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi Password Baru</label>
                                            <input type="password" id="confirm_password" name="confirm_password"
                                                   class="block w-full px-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Submit Button -->
                            <div class="flex justify-end pt-6">
                                <button type="submit" 
                                        class="bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition duration-300 font-medium">
                                    <i class="fas fa-save mr-2"></i>Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
