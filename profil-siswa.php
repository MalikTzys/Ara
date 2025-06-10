<?php 
include 'includes/header.php';

// Cek apakah ada parameter id
if (!isset($_GET['id'])) {
    header('Location: dashboard.php');
    exit;
}

$id_siswa = (int)$_GET['id'];

// Ambil data siswa
$query = "SELECT s.*, j.nama_jurusan FROM siswa s 
          JOIN jurusan j ON s.id_jurusan = j.id_jurusan 
          WHERE s.id_siswa = $id_siswa";
$result = mysqli_query($conn, $query);

// Cek apakah siswa ditemukan
if (mysqli_num_rows($result) == 0) {
    header('Location: dashboard.php');
    exit;
}

$siswa = mysqli_fetch_assoc($result);
?>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Profil Siswa</h1>
                    <p class="text-gray-600">Detail informasi siswa</p>
                </div>
                <a href="dashboard.php" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali
                </a>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Profile Card -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-lg p-6 text-center">
                    <?php if(!empty($siswa['foto']) && file_exists('assets/images/siswa/' . $siswa['foto'])): ?>
                        <img src="assets/images/siswa/<?php echo $siswa['foto']; ?>" 
                             alt="<?php echo $siswa['nama']; ?>" 
                             class="w-32 h-32 rounded-full mx-auto mb-4 object-cover">
                    <?php else: ?>
                        <div class="w-32 h-32 bg-green-500 rounded-full mx-auto mb-4 flex items-center justify-center text-white text-4xl font-bold">
                            <?php echo strtoupper(substr($siswa['nama'], 0, 1)); ?>
                        </div>
                    <?php endif; ?>
                    
                    <h2 class="text-2xl font-bold text-gray-900 mb-2"><?php echo $siswa['nama']; ?></h2>
                    <p class="text-gray-600 mb-1"><?php echo $siswa['kelas']; ?></p>
                    <p class="text-gray-500 mb-4"><?php echo $siswa['nama_jurusan']; ?></p>
                    
                    <div class="space-y-3">
                        <a href="mailto:<?php echo $siswa['email']; ?>" 
                           class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300 flex items-center justify-center">
                            <i class="fas fa-envelope mr-2"></i>Kirim Email
                        </a>
                    </div>
                </div>
                
                <!-- Quick Stats -->
                <div class="bg-white rounded-xl shadow-lg p-6 mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Akademik</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status</span>
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-medium">Siswa Aktif</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Kelas</span>
                            <span class="text-gray-900 font-medium"><?php echo $siswa['kelas']; ?></span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tahun Masuk</span>
                            <span class="text-gray-900 font-medium">2022</span>
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
                                <p class="text-gray-900"><?php echo $siswa['nama']; ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                                <p class="text-gray-900"><?php echo ($siswa['jenis_kelamin'] == 'L') ? 'Laki-laki' : 'Perempuan'; ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <p class="text-gray-900"><?php echo $siswa['email']; ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                                <p class="text-gray-900"><?php echo $siswa['kelas']; ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jurusan</label>
                                <p class="text-gray-900"><?php echo $siswa['nama_jurusan']; ?></p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                                <p class="text-gray-900"><?php echo $siswa['alamat']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Academic Progress -->
                <div class="bg-white rounded-xl shadow-lg">
                    <div class="p-6 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Progress Akademik</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            <div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-sm font-medium text-gray-700">Semester 1</span>
                                    <span class="text-sm text-gray-500">85%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: 85%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-sm font-medium text-gray-700">Semester 2</span>
                                    <span class="text-sm text-gray-500">88%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: 88%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-sm font-medium text-gray-700">Semester 3</span>
                                    <span class="text-sm text-gray-500">90%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-green-500 h-2 rounded-full" style="width: 90%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
