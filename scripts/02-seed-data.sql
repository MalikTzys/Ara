-- Insert sample data for Alumni Management System
USE webalumni;

-- Insert sample admin data (password: password123)
INSERT INTO admin (username, email, password) VALUES
('admin1', 'admin@sekolah.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('admin2', 'kepala@sekolah.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Insert sample jurusan data
INSERT INTO jurusan (nama_jurusan) VALUES
('Teknik Informatika'),
('Teknik Elektro'),
('Teknik Mesin'),
('Akuntansi'),
('Manajemen'),
('Desain Grafis'),
('Teknik Komputer dan Jaringan'),
('Multimedia'),
('Rekayasa Perangkat Lunak'),
('Administrasi Perkantoran');

-- Insert sample alumni data
INSERT INTO alumni (id_admin, id_jurusan, nama, jenis_kelamin, email, alamat, foto) VALUES
(1, 1, 'Ahmad Rizki', 'L', 'ahmad.rizki@email.com', 'Jl. Merdeka No. 123, Jakarta', 'ahmad.jpg'),
(1, 2, 'Siti Nurhaliza', 'P', 'siti.nurhaliza@email.com', 'Jl. Sudirman No. 456, Bandung', 'siti.jpg'),
(1, 3, 'Budi Santoso', 'L', 'budi.santoso@email.com', 'Jl. Gatot Subroto No. 789, Surabaya', 'budi.jpg'),
(2, 4, 'Maya Sari', 'P', 'maya.sari@email.com', 'Jl. Diponegoro No. 321, Yogyakarta', 'maya.jpg'),
(2, 5, 'Andi Wijaya', 'L', 'andi.wijaya@email.com', 'Jl. Ahmad Yani No. 654, Medan', 'andi.jpg'),
(1, 6, 'Dewi Sartika', 'P', 'dewi.sartika@email.com', 'Jl. Kemerdekaan No. 567, Semarang', 'dewi.jpg'),
(2, 7, 'Rizky Pratama', 'L', 'rizky.pratama@email.com', 'Jl. Pancasila No. 890, Malang', 'rizky.jpg'),
(1, 8, 'Sari Indah', 'P', 'sari.indah@email.com', 'Jl. Garuda No. 234, Denpasar', 'sari.jpg');

-- Insert sample siswa data
INSERT INTO siswa (id_admin, id_jurusan, nama, jenis_kelamin, email, kelas, alamat, foto) VALUES
(1, 1, 'Dina Marlina', 'P', 'dina.marlina@email.com', 'XII-A', 'Jl. Pahlawan No. 111, Jakarta', 'dina.jpg'),
(1, 2, 'Reza Pratama', 'L', 'reza.pratama@email.com', 'XII-B', 'Jl. Veteran No. 222, Bandung', 'reza.jpg'),
(2, 3, 'Lina Sari', 'P', 'lina.sari@email.com', 'XI-A', 'Jl. Kartini No. 333, Surabaya', 'lina.jpg'),
(2, 4, 'Fajar Nugroho', 'L', 'fajar.nugroho@email.com', 'XI-B', 'Jl. Soekarno No. 444, Yogyakarta', 'fajar.jpg'),
(1, 5, 'Andi Setiawan', 'L', 'andi.setiawan@email.com', 'XII-C', 'Jl. Pemuda No. 555, Jakarta', 'andi.jpg'),
(2, 6, 'Putri Maharani', 'P', 'putri.maharani@email.com', 'XI-C', 'Jl. Harapan No. 666, Bandung', 'putri.jpg');
