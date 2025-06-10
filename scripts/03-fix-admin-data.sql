-- Perbaiki data admin dengan password yang benar
USE webalumni;

-- Hapus data admin lama
DELETE FROM admin;

-- Insert admin baru dengan password yang sudah di-hash
-- Password: "password" untuk semua admin
INSERT INTO admin (username, email, password) VALUES
('admin', 'admin@sekolah.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('admin1', 'admin1@sekolah.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
('admin2', 'admin2@sekolah.edu', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Atau bisa juga insert dengan password plain text untuk testing
INSERT INTO admin (username, email, password) VALUES
('test', 'test@sekolah.edu', 'password');