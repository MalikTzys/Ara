<?php 
include 'includes/header.php';

// Cek apakah ada parameter id
if (!isset($_GET['id'])) {
    header('Location: daftar-alumni.php');
    exit;
}

$id_alumni = (int)$_GET['id'];

// Ambil data alumni
$query = "SELECT a.*, j.nama_jurusan FROM alumni a 
          JOIN jurusan j ON a.id_jurusan = j.id_jurusan 
          WHERE a.id_alumni = $id_alumni";
$result = mysqli_query($conn, $query);

// Cek apakah alumni ditemukan
if (mysqli_num_rows($result) == 0) {
    header('Location: daftar-alumni.php');
    exit;
}

$alumni = mysqli_fetch_assoc($result);
?>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Profil Alumni</h1>
                    <p class="text-gray-600">Detail informasi alumni</p>
                </div>
                <a href="daftar-alumni.php" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Profile Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                    <?php if(!empty($alumni['foto']) && file_exists('assets/images/alumni/' . $alumni['foto'])): ?>
                        <img src="assets/images/alumni/<?php echo $alumni['foto']; ?>" 
                             alt="<?php echo $alumni['nama']; ?>" 
                             class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
                    <?php else: ?>
                        <div class="w-32 h-32 bg-blue-500 rounded-full mx-auto mb-4 flex items-center justify-center text-white text-4xl font-bold">
                            <?php echo strtoupper(substr($alumni['nama'], 0, 1)); ?>
                        </div>
                    <?php endif; ?>
                    
                    <h2 class="text-2xl font-bold text-gray-900 mb-2"><?php echo $alumni['nama']; ?></h2>
                    <p class="text-gray-600 mb-4"><?php echo $alumni['nama_jurusan']; ?></p>
                    
                    <div class="space-y-3">
                        <a href="mailto:<?php echo $alumni['email']; ?>" 
                           class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300 flex items-center justify-center">
                            <i class="fas fa-envelope mr-2"></i>Kirim Email
                        </a>
                        <button class="w-full bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition duration-300 flex items-center justify-center">
                            <i class="fab fa-whatsapp mr-2"></i>WhatsApp
                        </button>
                    </div>
                </div>
                
                <!-- Quick Stats -->
                <div class="bg-white rounded-xl shadow-lg p-6 mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistik</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status</span>
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">Alumni</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Bergabung</span>
                            <span class="text-gray-900 font-medium">2021</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Koneksi</span>
                            <span class="text-gray-900 font-medium">45</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Personal Information -->
                <div class="bg-white rounded-xl shadow-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Informasi Pribadi</h3>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                <p class="text-gray-900"><?php echo $alumni['nama']; ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                                <p class="text-gray-900"><?php echo ($alumni['jenis_kelamin'] == 'L') ? 'Laki-laki' : 'Perempuan'; ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <p class="text-gray-900"><?php echo $alumni['email']; ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jurusan</label>
                                <p class="text-gray-900"><?php echo $alumni['nama_jurusan']; ?></p>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                                <p class="text-gray-900"><?php echo $alumni['alamat']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Education History -->
                <div class="bg-white rounded-xl shadow-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Riwayat Pendidikan</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                        <i class="fas fa-graduation-cap text-white text-sm"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-gray-900">SMK Negeri 1</h4>
                                    <p class="text-gray-600"><?php echo $alumni['nama_jurusan']; ?></p>
                                    <p class="text-sm text-gray-500">2018 - 2021</p>
                                </div>
                            </div>
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                                        <i class="fas fa-university text-white text-sm"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium text-gray-900">Universitas Contoh</h4>
                                    <p class="text-gray-600">Fakultas <?php echo $alumni['nama_jurusan']; ?></p>
                                    <p class="text-sm text-gray-500">2021 - 2025</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Career Information -->
                <div class="bg-white rounded-xl shadow-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Informasi Karir</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div>
                                <h4 class="text-lg font-medium text-gray-900">Software Engineer</h4>
                                <p class="text-gray-600">PT. Teknologi Indonesia</p>
                                <p class="text-sm text-gray-500">2025 - Sekarang</p>
                                <p class="text-gray-700 mt-2">Mengembangkan aplikasi web dan mobile menggunakan teknologi terkini.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
