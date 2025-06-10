-- Complete database setup with proper data
USE webalumni;

-- Clear existing data
DELETE FROM siswa;
DELETE FROM alumni;
DELETE FROM admin;
DELETE FROM jurusan;

-- Reset auto increment
ALTER TABLE admin AUTO_INCREMENT = 1;
ALTER TABLE jurusan AUTO_INCREMENT = 1;
ALTER TABLE alumni AUTO_INCREMENT = 1;
ALTER TABLE siswa AUTO_INCREMENT = 1;

-- Insert jurusan data
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

-- Insert admin data with proper passwords
INSERT INTO admin (username, email, password) VALUES
('admin', 'admin@sekolah.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('admin1', 'admin1@sekolah.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('test', 'test@sekolah.edu', 'password');

-- Insert alumni data
INSERT INTO alumni (id_admin, id_jurusan, nama, jenis_kelamin, email, alamat, foto) VALUES
(1, 1, 'Ahmad Rizki Pratama', 'L', 'ahmad.rizki@email.com', 'Jl. Merdeka No. 123, Jakarta Pusat', 'ahmad.jpg'),
(1, 2, 'Siti Nurhaliza Dewi', 'P', 'siti.nurhaliza@email.com', 'Jl. Sudirman No. 456, Bandung', 'siti.jpg'),
(1, 3, 'Budi Santoso Wijaya', 'L', 'budi.santoso@email.com', 'Jl. Gatot Subroto No. 789, Surabaya', 'budi.jpg'),
(2, 4, 'Maya Sari Indah', 'P', 'maya.sari@email.com', 'Jl. Diponegoro No. 321, Yogyakarta', 'maya.jpg'),
(2, 5, 'Andi Wijaya Kusuma', 'L', 'andi.wijaya@email.com', 'Jl. Ahmad Yani No. 654, Medan', 'andi.jpg'),
(1, 6, 'Dewi Sartika Putri', 'P', 'dewi.sartika@email.com', 'Jl. Kemerdekaan No. 567, Semarang', 'dewi.jpg'),
(2, 7, 'Rizky Pratama Jaya', 'L', 'rizky.pratama@email.com', 'Jl. Pancasila No. 890, Malang', 'rizky.jpg'),
(1, 8, 'Sari Indah Permata', 'P', 'sari.indah@email.com', 'Jl. Garuda No. 234, Denpasar', 'sari.jpg'),
(2, 9, 'Budi Hartono Saputra', 'L', 'budi.hartono@email.com', 'Jl. Nusantara No. 456, Makassar', 'budi2.jpg'),
(1, 10, 'Lestari Wulan Sari', 'P', 'lestari.wulan@email.com', 'Jl. Indonesia No. 678, Palembang', 'lestari.jpg'),
(2, 1, 'Fajar Nugroho Adi', 'L', 'fajar.nugroho@email.com', 'Jl. Pahlawan No. 111, Jakarta Selatan', 'fajar.jpg'),
(1, 2, 'Rina Maharani Putri', 'P', 'rina.maharani@email.com', 'Jl. Veteran No. 222, Bandung Barat', 'rina.jpg'),
(2, 3, 'Agus Salim Hakim', 'L', 'agus.salim@email.com', 'Jl. Kartini No. 333, Surabaya Timur', 'agus.jpg'),
(1, 4, 'Ratna Sari Dewi', 'P', 'ratna.sari@email.com', 'Jl. Soekarno No. 444, Yogyakarta Utara', 'ratna.jpg'),
(2, 5, 'Hendra Wijaya Putra', 'L', 'hendra.wijaya@email.com', 'Jl. Mawar No. 999, Medan Barat', 'hendra.jpg');

-- Insert siswa data
INSERT INTO siswa (id_admin, id_jurusan, nama, jenis_kelamin, email, kelas, alamat, foto) VALUES
(1, 1, 'Dina Marlina Sari', 'P', 'dina.marlina@email.com', 'XII-A', 'Jl. Pahlawan No. 111, Jakarta', 'dina.jpg'),
(1, 2, 'Reza Pratama Jaya', 'L', 'reza.pratama@email.com', 'XII-B', 'Jl. Veteran No. 222, Bandung', 'reza.jpg'),
(2, 3, 'Lina Sari Putri', 'P', 'lina.sari@email.com', 'XI-A', 'Jl. Kartini No. 333, Surabaya', 'lina.jpg'),
(2, 4, 'Fajar Nugroho Adi', 'L', 'fajar.nugroho2@email.com', 'XI-B', 'Jl. Soekarno No. 444, Yogyakarta', 'fajar2.jpg'),
(1, 5, 'Andi Setiawan Putra', 'L', 'andi.setiawan@email.com', 'XII-C', 'Jl. Pemuda No. 555, Jakarta', 'andi2.jpg'),
(2, 6, 'Putri Maharani Dewi', 'P', 'putri.maharani@email.com', 'XI-C', 'Jl. Harapan No. 666, Bandung', 'putri.jpg'),
(1, 7, 'Agus Salim Hakim', 'L', 'agus.salim2@email.com', 'XII-D', 'Jl. Cendana No. 777, Surabaya', 'agus2.jpg'),
(2, 8, 'Ratna Sari Dewi', 'P', 'ratna.sari2@email.com', 'XI-D', 'Jl. Melati No. 888, Yogyakarta', 'ratna2.jpg'),
(1, 9, 'Hendra Wijaya Putra', 'L', 'hendra.wijaya2@email.com', 'X-A', 'Jl. Mawar No. 999, Medan', 'hendra2.jpg'),
(2, 10, 'Sinta Dewi Permata', 'P', 'sinta.dewi@email.com', 'X-B', 'Jl. Anggrek No. 101, Palembang', 'sinta.jpg');
