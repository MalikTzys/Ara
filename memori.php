<?php include 'includes/header.php'; ?>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Memori & Kenangan</h1>
            <p class="text-gray-600">Koleksi foto dan momen berharga dari alumni</p>
        </div>
        
        <!-- Filter Tabs -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8">
            <div class="flex flex-wrap gap-2" id="filter-tabs">
                <button class="filter-btn active bg-blue-600 text-white px-4 py-2 rounded-lg font-medium transition duration-300" data-filter="all">
                    Semua
                </button>
                <button class="filter-btn bg-gray-100 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-200 transition duration-300" data-filter="reunion">
                    Reuni
                </button>
                <button class="filter-btn bg-gray-100 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-200 transition duration-300" data-filter="graduation">
                    Wisuda
                </button>
                <button class="filter-btn bg-gray-100 text-gray-700 px-4 py-2 rounded-lg font-medium hover:bg-gray-200 transition duration-300" data-filter="events">
                    Acara
                </button>
            </div>
        </div>
        
        <!-- Memory Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="memory-grid">
            <?php
            // Simulasi data memori
            $memories = [
                [
                    'title' => 'Reuni Angkatan 2020',
                    'date' => '15 Mei 2025',
                    'description' => 'Reuni akbar alumni angkatan 2020 yang dihadiri oleh lebih dari 100 alumni dari berbagai daerah.',
                    'category' => 'reunion',
                    'image' => 'reunion1.jpg'
                ],
                [
                    'title' => 'Wisuda Angkatan 2023',
                    'date' => '20 April 2025',
                    'description' => 'Prosesi wisuda angkatan 2023 yang berlangsung meriah di aula sekolah dengan kehadiran orang tua.',
                    'category' => 'graduation',
                    'image' => 'graduation1.jpg'
                ],
                [
                    'title' => 'Kunjungan Industri',
                    'date' => '10 Maret 2025',
                    'description' => 'Kunjungan industri ke PT. Teknologi Indonesia bersama siswa kelas XII jurusan TKJ.',
                    'category' => 'events',
                    'image' => 'industry1.jpg'
                ],
                [
                    'title' => 'Workshop Kewirausahaan',
                    'date' => '5 Februari 2025',
                    'description' => 'Workshop kewirausahaan yang diselenggarakan oleh alumni untuk siswa kelas XI dan XII.',
                    'category' => 'events',
                    'image' => 'workshop1.jpg'
                ],
                [
                    'title' => 'Reuni Angkatan 2018',
                    'date' => '25 Januari 2025',
                    'description' => 'Reuni angkatan 2018 yang diselenggarakan di Hotel Grand Palace dengan tema "Nostalgia Masa Sekolah".',
                    'category' => 'reunion',
                    'image' => 'reunion2.jpg'
                ],
                [
                    'title' => 'Wisuda Angkatan 2022',
                    'date' => '15 Desember 2024',
                    'description' => 'Prosesi wisuda angkatan 2022 yang dihadiri oleh orang tua dan wali siswa.',
                    'category' => 'graduation',
                    'image' => 'graduation2.jpg'
                ],
                [
                    'title' => 'Seminar Karir',
                    'date' => '5 November 2024',
                    'description' => 'Seminar karir yang diisi oleh alumni sukses dari berbagai bidang profesi.',
                    'category' => 'events',
                    'image' => 'seminar1.jpg'
                ],
                [
                    'title' => 'Perayaan Dies Natalis',
                    'date' => '20 Oktober 2024',
                    'description' => 'Perayaan dies natalis sekolah yang ke-25 dengan berbagai kegiatan menarik.',
                    'category' => 'events',
                    'image' => 'anniversary1.jpg'
                ],
                [
                    'title' => 'Reuni Akbar',
                    'date' => '10 September 2024',
                    'description' => 'Reuni akbar seluruh alumni yang diselenggarakan dalam rangka HUT sekolah.',
                    'category' => 'reunion',
                    'image' => 'reunion3.jpg'
                ]
            ];
            
            foreach($memories as $index => $memory) {
                $colors = ['from-blue-400 to-blue-600', 'from-green-400 to-green-600', 'from-purple-400 to-purple-600', 'from-red-400 to-red-600', 'from-yellow-400 to-yellow-600'];
                $color = $colors[$index % count($colors)];
            ?>
            <div class="memory-item bg-white rounded-xl shadow-lg overflow-hidden card-hover" data-category="<?php echo $memory['category']; ?>">
                <div class="h-48 bg-gradient-to-r <?php echo $color; ?> flex items-center justify-center relative">
                    <i class="fas fa-camera text-white text-4xl"></i>
                    <div class="absolute top-4 right-4">
                        <span class="bg-white bg-opacity-20 text-white px-2 py-1 rounded-full text-xs font-medium">
                            <?php echo ucfirst($memory['category']); ?>
                        </span>
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 mb-2"><?php echo $memory['title']; ?></h3>
                    <p class="text-gray-600 mb-4 line-clamp-3"><?php echo $memory['description']; ?></p>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500 flex items-center">
                            <i class="far fa-calendar-alt mr-2"></i>
                            <?php echo $memory['date']; ?>
                        </span>
                        <button class="text-blue-600 hover:text-blue-800 font-medium" onclick="openModal(<?php echo $index; ?>)">
                            Lihat Detail <i class="fas fa-arrow-right ml-1"></i>
                        </button>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        
        <!-- Load More Button -->
        <div class="text-center mt-12">
            <button class="bg-blue-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition duration-300">
                Muat Lebih Banyak
            </button>
        </div>
    </div>
</div>

<!-- Modal -->
<div id="memoryModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl max-w-2xl w-full max-h-screen overflow-y-auto">
        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 id="modalTitle" class="text-2xl font-bold text-gray-900"></h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <div id="modalImage" class="h-64 bg-gradient-to-r from-blue-400 to-blue-600 rounded-lg mb-4 flex items-center justify-center">
                <i class="fas fa-camera text-white text-4xl"></i>
            </div>
            <p id="modalDescription" class="text-gray-700 mb-4"></p>
            <p id="modalDate" class="text-sm text-gray-500"></p>
        </div>
    </div>
</div>

<script>
    const memories = <?php echo json_encode($memories); ?>;
    
    // Filter functionality
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const filter = this.dataset.filter;
            
            // Update active button
            document.querySelectorAll('.filter-btn').forEach(b => {
                b.classList.remove('active', 'bg-blue-600', 'text-white');
                b.classList.add('bg-gray-100', 'text-gray-700');
            });
            this.classList.add('active', 'bg-blue-600', 'text-white');
            this.classList.remove('bg-gray-100', 'text-gray-700');
            
            // Filter items
            document.querySelectorAll('.memory-item').forEach(item => {
                if (filter === 'all' || item.dataset.category === filter) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
    
    // Modal functionality
    function openModal(index) {
        const memory = memories[index];
        document.getElementById('modalTitle').textContent = memory.title;
        document.getElementById('modalDescription').textContent = memory.description;
        document.getElementById('modalDate').innerHTML = '<i class="far fa-calendar-alt mr-2"></i>' + memory.date;
        document.getElementById('memoryModal').classList.remove('hidden');
        document.getElementById('memoryModal').classList.add('flex');
    }
    
    function closeModal() {
        document.getElementById('memoryModal').classList.add('hidden');
        document.getElementById('memoryModal').classList.remove('flex');
    }
    
    // Close modal when clicking outside
    document.getElementById('memoryModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeModal();
        }
    });
</script>

<?php include 'includes/footer.php'; ?>
