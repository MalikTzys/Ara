<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<div class="gradient-bg text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h1 class="text-4xl md:text-6xl font-bold mb-6">Selamat Datang di Portal Alumni</h1>
                <p class="text-xl mb-8 text-blue-100">Menghubungkan alumni dan siswa untuk membangun jaringan yang kuat dan berbagi pengalaman berharga.</p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="daftar-alumni.php" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300 text-center">
                        Lihat Alumni
                    </a>
                    <a href="register.php" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition duration-300 text-center">
                        Daftar Sekarang
                    </a>
                </div>
            </div>
            <div class="text-center">
                <div class="w-full max-w-md mx-auto">
                    <div class="bg-white bg-opacity-10 rounded-full p-8">
                        <i class="fas fa-graduation-cap text-8xl text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Section -->
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Statistik Alumni</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Data alumni berdasarkan jurusan dan pencapaian mereka di berbagai bidang</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            // Mengambil data jurusan
            $query = "SELECT j.*, 
                     (SELECT COUNT(*) FROM alumni a WHERE a.id_jurusan = j.id_jurusan) as jumlah_alumni
                     FROM jurusan j ORDER BY jumlah_alumni DESC LIMIT 6";
            $result = mysqli_query($conn, $query);
            
            $colors = ['bg-blue-500', 'bg-green-500', 'bg-purple-500', 'bg-red-500', 'bg-yellow-500', 'bg-indigo-500'];
            $index = 0;
            
            while($row = mysqli_fetch_assoc($result)) {
                $color = $colors[$index % count($colors)];
            ?>
            <div class="bg-white rounded-xl shadow-lg p-6 card-hover border border-gray-100">
                <div class="flex items-center justify-between mb-4">
                    <div class="<?php echo $color; ?> w-12 h-12 rounded-lg flex items-center justify-center">
                        <i class="fas fa-book text-white text-xl"></i>
                    </div>
                    <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-sm font-medium">
                        <?php echo $row['jumlah_alumni']; ?> Alumni
                    </span>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2"><?php echo $row['nama_jurusan']; ?></h3>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="<?php echo $color; ?> h-2 rounded-full" style="width: <?php echo min($row['jumlah_alumni'] * 10, 100); ?>%"></div>
                </div>
            </div>
            <?php 
                $index++;
            } 
            ?>
        </div>
    </div>
</div>

<!-- Recent Memories Section -->
<div class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Memori Terbaru</h2>
            <p class="text-gray-600 max-w-2xl mx-auto">Kenangan dan momen berharga dari perjalanan alumni</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            // Simulasi data memori
            $memories = [
                ['title' => 'Reuni Angkatan 2020', 'date' => '15 Mei 2025', 'description' => 'Reuni akbar alumni angkatan 2020'],
                ['title' => 'Wisuda Angkatan 2023', 'date' => '20 April 2025', 'description' => 'Prosesi wisuda yang meriah'],
                ['title' => 'Kunjungan Industri', 'date' => '10 Maret 2025', 'description' => 'Kunjungan ke perusahaan teknologi']
            ];
            
            foreach($memories as $memory) {
            ?>
            <div class="bg-white rounded-xl shadow-lg overflow-hidden card-hover">
                <div class="h-48 bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                    <i class="fas fa-camera text-white text-4xl"></i>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2"><?php echo $memory['title']; ?></h3>
                    <p class="text-gray-600 mb-4"><?php echo $memory['description']; ?></p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500">
                            <i class="far fa-calendar-alt mr-1"></i>
                            <?php echo $memory['date']; ?>
                        </span>
                        <a href="memori.php" class="text-blue-600 hover:text-blue-800 font-medium">
                            Lihat Detail <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        
        <div class="text-center mt-12">
            <a href="memori.php" class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                Lihat Semua Memori
            </a>
        </div>
    </div>
</div>

<!-- CTA Section -->
<div class="bg-blue-600 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-white mb-4">Bergabunglah dengan Komunitas Alumni</h2>
        <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">Terhubung dengan ribuan alumni lainnya dan bangun jaringan profesional yang kuat</p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="register.php" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition duration-300">
                Daftar Sekarang
            </a>
            <a href="daftar-alumni.php" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition duration-300">
                Jelajahi Alumni
            </a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
