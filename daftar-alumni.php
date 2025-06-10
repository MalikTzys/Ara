<?php 
include 'includes/header.php';

$debug_info = '';

// Pagination
$limit = 12;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Search
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$jurusan_filter = isset($_GET['jurusan']) ? (int)$_GET['jurusan'] : 0;

// Base query
$query = "SELECT a.*, j.nama_jurusan FROM alumni a 
          JOIN jurusan j ON a.id_jurusan = j.id_jurusan";

// Add search condition
$where_conditions = [];
if (!empty($search)) {
    $where_conditions[] = "(a.nama LIKE '%$search%' OR a.email LIKE '%$search%' OR j.nama_jurusan LIKE '%$search%')";
}

// Add jurusan filter
if ($jurusan_filter > 0) {
    $where_conditions[] = "a.id_jurusan = $jurusan_filter";
}

// Combine conditions
if (!empty($where_conditions)) {
    $query .= " WHERE " . implode(' AND ', $where_conditions);
}

$debug_info .= "Main query: $query<br>";

// Count total records
$count_query = str_replace("a.*, j.nama_jurusan", "COUNT(*) as total", $query);
$count_result = mysqli_query($conn, $count_query);

if (!$count_result) {
    $debug_info .= "Count query error: " . mysqli_error($conn) . "<br>";
    $total_records = 0;
} else {
    $total_records = mysqli_fetch_assoc($count_result)['total'];
}

$total_pages = ceil($total_records / $limit);
$debug_info .= "Total records: $total_records, Total pages: $total_pages<br>";

// Add limit for pagination
$query .= " ORDER BY a.nama ASC LIMIT $start, $limit";
$result = mysqli_query($conn, $query);

if (!$result) {
    $debug_info .= "Main query error: " . mysqli_error($conn) . "<br>";
}

// Get jurusan for filter
$jurusan_query = "SELECT * FROM jurusan ORDER BY nama_jurusan ASC";
$jurusan_result = mysqli_query($conn, $jurusan_query);

if (!$jurusan_result) {
    $debug_info .= "Jurusan query error: " . mysqli_error($conn) . "<br>";
}
?>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Daftar Alumni</h1>
            <p class="text-gray-600">Temukan dan terhubung dengan alumni sekolah</p>
        </div>
        
        <?php if($debug_info && isset($_GET['debug'])): ?>
            <div class="mb-4 bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg">
                <strong>Debug Info:</strong><br>
                <?php echo $debug_info; ?>
            </div>
        <?php endif; ?>
        
        <!-- Search and Filter -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <form method="GET" action="">
                <?php if(isset($_GET['debug'])): ?>
                    <input type="hidden" name="debug" value="1">
                <?php endif; ?>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                            <input type="text" name="search" value="<?php echo htmlspecialchars($search); ?>" 
                                   placeholder="Cari alumni berdasarkan nama, email, atau jurusan..."
                                   class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                    </div>
                    <div>
                        <select name="jurusan" class="block w-full py-3 px-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="0">Semua Jurusan</option>
                            <?php if($jurusan_result): ?>
                                <?php while($jurusan = mysqli_fetch_assoc($jurusan_result)): ?>
                                    <option value="<?php echo $jurusan['id_jurusan']; ?>" <?php echo ($jurusan_filter == $jurusan['id_jurusan']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($jurusan['nama_jurusan']); ?>
                                    </option>
                                <?php endwhile; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="mt-4 flex justify-end">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                        <i class="fas fa-search mr-2"></i>Filter
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Results -->
        <div class="mb-6">
            <p class="text-gray-600">
                Menampilkan <?php echo $result ? mysqli_num_rows($result) : 0; ?> dari <?php echo $total_records; ?> alumni
                <?php if(isset($_GET['debug'])): ?>
                    | <a href="daftar-alumni.php?debug=1" class="text-blue-600">Debug Mode</a>
                <?php endif; ?>
            </p>
        </div>
        
        <!-- Alumni Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
            <?php if($result && mysqli_num_rows($result) > 0): ?>
                <?php while($alumni = mysqli_fetch_assoc($result)): ?>
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                        <div class="p-6">
                            <div class="flex items-center mb-4">
                                <div class="bg-blue-500 w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-lg">
                                    <?php echo strtoupper(substr($alumni['nama'], 0, 1)); ?>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-lg font-semibold text-gray-900"><?php echo htmlspecialchars($alumni['nama']); ?></h3>
                                    <p class="text-sm text-gray-500"><?php echo htmlspecialchars($alumni['nama_jurusan']); ?></p>
                                </div>
                            </div>
                            
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-envelope mr-2 text-gray-400"></i>
                                    <span class="truncate"><?php echo htmlspecialchars($alumni['email']); ?></span>
                                </div>
                                <div class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-map-marker-alt mr-2 text-gray-400"></i>
                                    <span class="truncate"><?php echo htmlspecialchars($alumni['alamat']); ?></span>
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
                                <a href="mailto:<?php echo htmlspecialchars($alumni['email']); ?>" 
                                   class="bg-gray-100 text-gray-700 p-2 rounded-lg hover:bg-gray-200 transition duration-300">
                                    <i class="fas fa-envelope"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-span-full">
                    <div class="text-center py-12">
                        <i class="fas fa-search text-gray-400 text-4xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada alumni yang ditemukan</h3>
                        <p class="text-gray-500">
                            <?php if($total_records == 0): ?>
                                Belum ada data alumni di database. 
                                <a href="config/database.php?test=1" class="text-blue-600">Test database connection</a>
                            <?php else: ?>
                                Coba ubah kata kunci pencarian atau filter yang digunakan
                            <?php endif; ?>
                        </p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Pagination -->
        <?php if($total_pages > 1): ?>
            <div class="flex justify-center">
                <nav class="flex items-center space-x-2">
                    <?php if($page > 1): ?>
                        <a href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>&jurusan=<?php echo $jurusan_filter; ?><?php echo isset($_GET['debug']) ? '&debug=1' : ''; ?>" 
                           class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    <?php endif; ?>
                    
                    <?php for($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                        <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&jurusan=<?php echo $jurusan_filter; ?><?php echo isset($_GET['debug']) ? '&debug=1' : ''; ?>" 
                           class="px-3 py-2 text-sm font-medium <?php echo ($page == $i) ? 'text-blue-600 bg-blue-50 border-blue-500' : 'text-gray-500 bg-white border-gray-300'; ?> border rounded-lg hover:bg-gray-50">
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
                    
                    <?php if($page < $total_pages): ?>
                        <a href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>&jurusan=<?php echo $jurusan_filter; ?><?php echo isset($_GET['debug']) ? '&debug=1' : ''; ?>" 
                           class="px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    <?php endif; ?>
                </nav>
            </div>
        <?php endif; ?>
        
        <div class="mt-8 text-center">
            <a href="daftar-alumni.php?debug=1" class="text-xs text-gray-500">Debug Mode</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
