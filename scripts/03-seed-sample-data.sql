-- Insert additional sample data for testing
USE webalumni;

-- Insert more sample jurusan
INSERT INTO jurusan (nama_jurusan) VALUES
('Teknik Komputer dan Jaringan'),
('Multimedia'),
('Rekayasa Perangkat Lunak'),
('Administrasi Perkantoran'),
('Pemasaran');

-- Insert more sample admin
INSERT INTO admin (username, email, password) VALUES
('superadmin', 'super@alumni.sch.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('operator', 'operator@alumni.sch.id', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Insert more sample alumni
INSERT INTO alumni (id_admin, id_jurusan, nama, jenis_kelamin, email, alamat, foto) VALUES
(1, 7, 'Dewi Sartika', 'P', 'dewi.sartika@email.com', 'Jl. Kemerdekaan No. 567, Semarang', 'dewi.jpg'),
(2, 8, 'Rizky Pratama', 'L', 'rizky.pratama@email.com', 'Jl. Pancasila No. 890, Malang', 'rizky.jpg'),
(1, 9, 'Sari Indah', 'P', 'sari.indah@email.com', 'Jl. Garuda No. 234, Denpasar', 'sari.jpg'),
(2, 10, 'Budi Hartono', 'L', 'budi.hartono@email.com', 'Jl. Nusantara No. 456, Makassar', 'budi.jpg'),
(1, 11, 'Lestari Wulan', 'P', 'lestari.wulan@email.com', 'Jl. Indonesia No. 678, Palembang', 'lestari.jpg');

-- Insert more sample siswa
INSERT INTO siswa (id_admin, id_jurusan, nama, jenis_kelamin, email, kelas, alamat, foto) VALUES
(1, 7, 'Andi Setiawan', 'L', 'andi.setiawan@email.com', 'XII-C', 'Jl. Pemuda No. 555, Jakarta', 'andi.jpg'),
(2, 8, 'Putri Maharani', 'P', 'putri.maharani@email.com', 'XI-C', 'Jl. Harapan No. 666, Bandung', 'putri.jpg'),
(1, 9, 'Agus Salim', 'L', 'agus.salim@email.com', 'XII-D', 'Jl. Cendana No. 777, Surabaya', 'agus.jpg'),
(2, 10, 'Ratna Sari', 'P', 'ratna.sari@email.com', 'XI-D', 'Jl. Melati No. 888, Yogyakarta', 'ratna.jpg'),
(1, 11, 'Hendra Wijaya', 'L', 'hendra.wijaya@email.com', 'X-A', 'Jl. Mawar No. 999, Medan', 'hendra.jpg');
