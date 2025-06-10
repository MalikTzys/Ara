<?php 
include 'includes/header.php';

$search_query = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : '';
$search_type = isset($_GET['type']) ? $_GET['type'] : 'all';

$alumni_results = [];
$siswa_results = [];

if (!empty($search_query)) {
    // Search alumni
    if ($search_type == 'all' || $search_type == 'alumni') {
        $query = "SELECT a.*, j.nama_jurusan FROM alumni a 
                  JOIN jurusan j ON a.id_jurusan = j.id_jurusan 
                  WHERE a.nama LIKE '%$search_query%' 
                     OR a.email LIKE '%$search_query%' 
                     OR j.nama_jurusan LIKE '%$search_query%'
                  ORDER BY a.nama ASC";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)) {
            $alumni_results[] = $row;
        }
    }
    
    // Search siswa
    if ($search_type == 'all' || $search_type == 'siswa') {
        $query = "SELECT s.*, j.nama_jurusan FROM siswa s 
                  JOIN jurusan j ON s.id_jurusan = j.id_jurusan 
                  WHERE s.nama LIKE '%$search_query%' 
                     OR s.email LIKE '%$search_query%' 
                     OR s.kelas LIKE '%$search_query%'
                     OR j.nama_jurusan LIKE '%$search_query%'
                  ORDER BY s.nama ASC";
        $result = mysqli_query($conn, $query);
        while($row = mysqli_fetch_assoc($result)) {
            $siswa_results[] = $row;
        }
    }
}
?>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Pencarian</h1>
            <p class="text-gray-600">Cari alumni dan siswa berdasarkan nama, email, atau jurusan</p>
        </div>
        
        <!-- Search Form -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <form method="GET" action="">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="md:col-span-2">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" name="q" value="<?php echo $search_query; ?>" 
                                   placeholder="Masukkan kata kunci pencarian..."
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    <div>
                        <select name="type" class="block w-full py-3 px-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="all" <?php echo ($search_type == 'all') ? 'selected' : ''; ?>>Semua</option>
                            <option value="alumni" <?php echo ($search_type == 'alumni') ? 'selected' : ''; ?>>Alumni</option>
                            <option value="siswa" <?php echo ($search_type == 'siswa') ? 'selected' : ''; ?>>Siswa</option>
                        </select>
                    </div>
                    <div>
                        <button type="submit" class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 transition duration-300 font-medium">
                            <i class="fas fa-search mr-2"></i>Cari
                        </button>
                    </div>
                </div>
            </form>
        </div>
        
        <?php if (!empty($search_query)): ?>
            <!-- Search Results -->
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Hasil pencarian untuk: "<?php echo $search_query; ?>"</h2>
                <p class="text-gray-600">
                    Ditemukan <?php echo count($alumni_results); ?> alumni dan <?php echo count($siswa_results); ?> siswa
                </p>
            </div>
            
            <?php if (!empty($alumni_results)): ?>
                <!-- Alumni Results -->
                <div class="mb-12">
                    <div class="flex items-center mb-6">
                        <div class="bg-blue-500 w-8 h-8 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-graduation-cap text-white"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900">Alumni (<?php echo count($alumni_results); ?>)</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach($alumni_results as $alumni): ?>
                            <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                                <div class="flex items-center mb-4">
                                    <div class="bg-blue-500 w-12 h-12 rounded-full flex items-center justify-center text-white font-bold">
                                        <?php echo strtoupper(substr($alumni['nama'], 0, 1)); ?>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-lg font-semibold text-gray-900"><?php echo $alumni['nama']; ?></h4>
                                        <p class="text-gray-600"><?php echo $alumni['nama_jurusan']; ?></p>
                                    </div>
                                </div>
                                <div class="space-y-2 mb-4">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-envelope mr-2 text-gray-400"></i>
                                        <span class="truncate"><?php echo $alumni['email']; ?></span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-venus-mars mr-2 text-gray-400"></i>
                                        <span><?php echo ($alumni['jenis_kelamin'] == 'L') ? 'Laki-laki' : 'Perempuan'; ?></span>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="profil-alumni.php?id=<?php echo $alumni['id_alumni']; ?>" 
                                       class="flex-1 bg-blue-600 text-white text-center py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-300 text-sm">
                                        <i class="fas fa-user mr-1"></i>Lihat Profil
                                    </a>
                                    <a href="mailto:<?php echo $alumni['email']; ?>" 
                                       class="bg-gray-100 text-gray-700 p-2 rounded-lg hover:bg-gray-200 transition duration-300">
                                        <i class="fas fa-envelope"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if (!empty($siswa_results)): ?>
                <!-- Siswa Results -->
                <div class="mb-12">
                    <div class="flex items-center mb-6">
                        <div class="bg-green-500 w-8 h-8 rounded-full flex items-center justify-center mr-3">
                            <i class="fas fa-user-graduate text-white"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900">Siswa (<?php echo count($siswa_results); ?>)</h3>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php foreach($siswa_results as $siswa): ?>
                            <div class="bg-white rounded-xl shadow-lg p-6 card-hover">
                                <div class="flex items-center mb-4">
                                    <div class="bg-green-500 w-12 h-12 rounded-full flex items-center justify-center text-white font-bold">
                                        <?php echo strtoupper(substr($siswa['nama'], 0, 1)); ?>
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-lg font-semibold text-gray-900"><?php echo $siswa['nama']; ?></h4>
                                        <p class="text-gray-600"><?php echo $siswa['kelas']; ?> - <?php echo $siswa['nama_jurusan']; ?></p>
                                    </div>
                                </div>
                                <div class="space-y-2 mb-4">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-envelope mr-2 text-gray-400"></i>
                                        <span class="truncate"><?php echo $siswa['email']; ?></span>
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-venus-mars mr-2 text-gray-400"></i>
                                        <span><?php echo ($siswa['jenis_kelamin'] == 'L') ? 'Laki-laki' : 'Perempuan'; ?></span>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <a href="profil-siswa.php?id=<?php echo $siswa['id_siswa']; ?>" 
                                       class="flex-1 bg-green-600 text-white text-center py-2 px-4 rounded-lg hover:bg-green-700 transition duration-300 text-sm">
                                        <i class="fas fa-user mr-1"></i>Lihat Profil
                                    </a>
                                    <a href="mailto:<?php echo $siswa['email']; ?>" 
                                       class="bg-gray-100 text-gray-700 p-2 rounded-lg hover:bg-gray-200 transition duration-300">
                                        <i class="fas fa-envelope"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if (empty($alumni_results) && empty($siswa_results)): ?>
                <!-- No Results -->
                <div class="text-center py-12">
                    <div class="bg-gray-100 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-search text-gray-400 text-3xl"></i>
                    </div>
                    <h3 class="text-xl font-medium text-gray-900 mb-2">Tidak ada hasil yang ditemukan</h3>
                    <p class="text-gray-500 mb-6">Coba ubah kata kunci pencarian atau gunakan filter yang berbeda</p>
                    <a href="search.php" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                        Coba Pencarian Baru
                    </a>
                </div>
            <?php endif; ?>
            
        <?php else: ?>
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="bg-blue-50 w-32 h-32 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-search text-blue-500 text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Mulai Pencarian</h3>
                <p class="text-gray-600 max-w-md mx-auto mb-8">Masukkan kata kunci untuk mencari alumni atau siswa berdasarkan nama, email, atau jurusan</p>
                
                <!-- Quick Search Suggestions -->
                <div class="max-w-2xl mx-auto">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Pencarian Populer:</h4>
                    <div class="flex flex-wrap justify-center gap-2">
                        <a href="?q=Teknik Informatika&type=all" class="bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm hover:bg-blue-200 transition duration-300">
                            Teknik Informatika
                        </a>
                        <a href="?q=Akuntansi&type=all" class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm hover:bg-green-200 transition duration-300">
                            Akuntansi
                        </a>
                        <a href="?q=XII&type=siswa" class="bg-purple-100 text-purple-800 px-4 py-2 rounded-full text-sm hover:bg-purple-200 transition duration-300">
                            Kelas XII
                        </a>
                        <a href="?q=2023&type=alumni" class="bg-orange-100 text-orange-800 px-4 py-2 rounded-full text-sm hover:bg-orange-200 transition duration-300">
                            Alumni 2023
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
