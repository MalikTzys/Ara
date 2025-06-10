<?php
// Debug mode - set to false in production
$debug_mode = true;

// Pastikan session dimulai dengan benar
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include database connection dengan error handling
$db_path = '';
if (file_exists(__DIR__ . '/../config/database.php')) {
    $db_path = __DIR__ . '/../config/database.php';
} elseif (file_exists('config/database.php')) {
    $db_path = 'config/database.php';
} elseif (file_exists('../config/database.php')) {
    $db_path = '../config/database.php';
}

if ($db_path && file_exists($db_path)) {
    require_once $db_path;
} else {
    if ($debug_mode) {
        die("Database config file not found! Current directory: " . __DIR__);
    } else {
        die("Database connection error!");
    }
}

// Test koneksi database
if (!isset($conn) || !$conn) {
    if ($debug_mode) {
        die("Database connection failed! Check your database configuration.");
    } else {
        die("Database error!");
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Alumni</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
        }
    </style>
</head>
<body class="bg-gray-50">
    <?php if ($debug_mode): ?>
    <!-- Debug info - hapus di production -->
    <div style="background: #f0f0f0; padding: 5px; font-size: 12px; border-bottom: 1px solid #ccc;">
        Debug: DB Connected ✅ | Current file: <?php echo basename($_SERVER['PHP_SELF']); ?> | Session: <?php echo isset($_SESSION['user_id']) ? 'Logged in as ' . $_SESSION['username'] : 'Not logged in'; ?>
    </div>
    <?php endif; ?>
    
    <nav class="bg-blue-600 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="index.php" class="flex items-center text-white font-bold text-xl">
                        <i class="fas fa-graduation-cap mr-2"></i>
                        Sistem Informasi Alumni
                    </a>
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="index.php" class="text-white hover:text-blue-200 transition duration-300">Beranda</a>
                    <a href="daftar-alumni.php" class="text-white hover:text-blue-200 transition duration-300">Daftar Alumni</a>
                    <a href="memori.php" class="text-white hover:text-blue-200 transition duration-300">Memori</a>
                    <a href="search.php" class="text-white hover:text-blue-200 transition duration-300">Pencarian</a>
                </div>

                <div class="flex items-center">
                    <?php if(isset($_SESSION['user_id'])): ?>
                        <div class="relative group">
                            <button class="flex items-center text-white hover:text-blue-200 focus:outline-none">
                                <div class="avatar-circle bg-blue-800 mr-2">
                                    <?php echo strtoupper(substr($_SESSION['username'], 0, 1)); ?>
                                </div>
                                <span><?php echo $_SESSION['username']; ?></span>
                                <i class="fas fa-chevron-down ml-1"></i>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50">
                                <div class="py-1">
                                    <a href="profil.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-user mr-2"></i>Profil
                                    </a>
                                    <a href="dashboard.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-tachometer-alt mr-2"></i>Dashboard
                                    </a>
                                    <?php if(isset($_SESSION['is_admin']) && $_SESSION['is_admin']): ?>
                                        <a href="admin/index.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-cogs mr-2"></i>Admin Panel
                                        </a>
                                    <?php endif; ?>
                                    <div class="border-t border-gray-100"></div>
                                    <a href="logout.php" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="flex space-x-4">
                            <a href="login.php" class="bg-white text-blue-600 px-4 py-2 rounded-md font-medium hover:bg-gray-100 transition duration-300">Login</a>
                            <a href="register.php" class="border border-white text-white px-4 py-2 rounded-md font-medium hover:bg-white hover:text-blue-600 transition duration-300">Register</a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button class="text-white hover:text-blue-200 focus:outline-none" onclick="toggleMobileMenu()">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="md:hidden hidden bg-blue-700">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="index.php" class="block px-3 py-2 text-white hover:bg-blue-800 rounded-md">Beranda</a>
                <a href="daftar-alumni.php" class="block px-3 py-2 text-white hover:bg-blue-800 rounded-md">Daftar Alumni</a>
                <a href="memori.php" class="block px-3 py-2 text-white hover:bg-blue-800 rounded-md">Memori</a>
                <a href="search.php" class="block px-3 py-2 text-white hover:bg-blue-800 rounded-md">Pencarian</a>
            </div>
        </div>
    </nav>

    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
    </script>
