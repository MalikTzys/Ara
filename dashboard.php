<?php 
include 'includes/header.php';

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// Ambil data admin
$admin_id = $_SESSION['user_id'];
$query = "SELECT * FROM admin WHERE id_admin = $admin_id";
$result = mysqli_query($conn, $query);
$admin = mysqli_fetch_assoc($result);

// Hitung jumlah alumni
$query = "SELECT COUNT(*) as total FROM alumni";
$result = mysqli_query($conn, $query);
$alumni_count = mysqli_fetch_assoc($result)['total'];

// Hitung jumlah siswa
$query = "SELECT COUNT(*) as total FROM siswa";
$result = mysqli_query($conn, $query);
$siswa_count = mysqli_fetch_assoc($result)['total'];

// Hitung jumlah jurusan
$query = "SELECT COUNT(*) as total FROM jurusan";
$result = mysqli_query($conn, $query);
$jurusan_count = mysqli_fetch_assoc($result)['total'];

// Ambil data alumni terbaru
$query = "SELECT a.*, j.nama_jurusan FROM alumni a 
          JOIN jurusan j ON a.id_jurusan = j.id_jurusan 
          ORDER BY a.id_alumni DESC LIMIT 5";
$alumni_result = mysqli_query($conn, $query);

// Ambil data siswa terbaru
$query = "SELECT s.*, j.nama_jurusan FROM siswa s 
          JOIN jurusan j ON s.id_jurusan = j.id_jurusan 
          ORDER BY s.id_siswa DESC LIMIT 5";
$siswa_result = mysqli_query($conn, $query);
?>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
                    <p class="mt-2 text-gray-600">Selamat datang kembali, <?php echo $admin['username']; ?>!</p>
                </div>
                <div class="mt-4 md:mt-0">
                    <a href="profil.php" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                        <i class="fas fa-user-edit mr-2"></i>Edit Profil
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-100 text-sm font-medium">Total Alumni</p>
                        <p class="text-3xl font-bold"><?php echo $alumni_count; ?></p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-full p-3">
                        <i class="fas fa-graduation-cap text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="daftar-alumni.php" class="text-blue-100 hover:text-white text-sm">
                        Lihat detail <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-100 text-sm font-medium">Total Siswa</p>
                        <p class="text-3xl font-bold"><?php echo $siswa_count; ?></p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-full p-3">
                        <i class="fas fa-user-graduate text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="#" class="text-green-100 hover:text-white text-sm">
                        Lihat detail <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-purple-100 text-sm font-medium">Total Jurusan</p>
                        <p class="text-3xl font-bold"><?php echo $jurusan_count; ?></p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-full p-3">
                        <i class="fas fa-book text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="#" class="text-purple-100 hover:text-white text-sm">
                        Lihat detail <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-100 text-sm font-medium">Total Memori</p>
                        <p class="text-3xl font-bold">24</p>
                    </div>
                    <div class="bg-white bg-opacity-20 rounded-full p-3">
                        <i class="fas fa-camera text-2xl"></i>
                    </div>
                </div>
                <div class="mt-4">
                    <a href="memori.php" class="text-orange-100 hover:text-white text-sm">
                        Lihat detail <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- Recent Data -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Alumni Terbaru -->
            <div class="bg-white rounded-xl shadow-lg">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Alumni Terbaru</h3>
                        <a href="daftar-alumni.php" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <?php while($alumni = mysqli_fetch_assoc($alumni_result)): ?>
                        <div class="flex items-center space-x-4">
                            <div class="bg-blue-500 w-10 h-10 rounded-full flex items-center justify-center text-white font-semibold">
                                <?php echo strtoupper(substr($alumni['nama'], 0, 1)); ?>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900"><?php echo $alumni['nama']; ?></p>
                                <p class="text-sm text-gray-500"><?php echo $alumni['nama_jurusan']; ?></p>
                            </div>
                            <a href="profil-alumni.php?id=<?php echo $alumni['id_alumni']; ?>" 
                               class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
            
            <!-- Siswa Terbaru -->
            <div class="bg-white rounded-xl shadow-lg">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-900">Siswa Terbaru</h3>
                        <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <?php while($siswa = mysqli_fetch_assoc($siswa_result)): ?>
                        <div class="flex items-center space-x-4">
                            <div class="bg-green-500 w-10 h-10 rounded-full flex items-center justify-center text-white font-semibold">
                                <?php echo strtoupper(substr($siswa['nama'], 0, 1)); ?>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-900"><?php echo $siswa['nama']; ?></p>
                                <p class="text-sm text-gray-500"><?php echo $siswa['kelas']; ?> - <?php echo $siswa['nama_jurusan']; ?></p>
                            </div>
                            <a href="profil-siswa.php?id=<?php echo $siswa['id_siswa']; ?>" 
                               class="text-blue-600 hover:text-blue-800">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
