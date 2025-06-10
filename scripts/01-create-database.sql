-- Create database and tables for Alumni Management System
CREATE DATABASE IF NOT EXISTS webalumni;
USE webalumni;

-- Create admin table
CREATE TABLE IF NOT EXISTS admin (
  id_admin INT(5) NOT NULL AUTO_INCREMENT,
  username VARCHAR(50) NOT NULL,
  email VARCHAR(50) NOT NULL,
  password VARCHAR(255) NOT NULL,
  PRIMARY KEY (id_admin)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create jurusan table
CREATE TABLE IF NOT EXISTS jurusan (
  id_jurusan INT(5) NOT NULL AUTO_INCREMENT,
  nama_jurusan VARCHAR(50) NOT NULL,
  PRIMARY KEY (id_jurusan)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create alumni table
CREATE TABLE IF NOT EXISTS alumni (
  id_alumni INT(5) NOT NULL AUTO_INCREMENT,
  id_admin INT(5) NOT NULL,
  id_jurusan INT(5) NOT NULL,
  nama VARCHAR(50) NOT NULL,
  jenis_kelamin ENUM('L','P') NOT NULL,
  email VARCHAR(50) NOT NULL,
  alamat TEXT NOT NULL,
  foto VARCHAR(50) NOT NULL,
  PRIMARY KEY (id_alumni),
  KEY id_admin (id_admin),
  KEY id_jurusan (id_jurusan),
  CONSTRAINT alumni_ibfk_1 FOREIGN KEY (id_admin) REFERENCES admin (id_admin),
  CONSTRAINT alumni_ibfk_2 FOREIGN KEY (id_jurusan) REFERENCES jurusan (id_jurusan)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Create siswa table
CREATE TABLE IF NOT EXISTS siswa (
  id_siswa INT(11) NOT NULL AUTO_INCREMENT,
  id_admin INT(5) NOT NULL,
  id_jurusan INT(5) NOT NULL,
  nama VARCHAR(50) NOT NULL,
  jenis_kelamin ENUM('L','P') NOT NULL,
  email VARCHAR(50) NOT NULL,
  kelas VARCHAR(6) NOT NULL,
  alamat TEXT NOT NULL,
  foto VARCHAR(50) NOT NULL,
  PRIMARY KEY (id_siswa),
  KEY id_admin (id_admin),
  KEY id_jurusan (id_jurusan),
  CONSTRAINT siswa_ibfk_1 FOREIGN KEY (id_admin) REFERENCES admin (id_admin),
  CONSTRAINT siswa_ibfk_2 FOREIGN KEY (id_jurusan) REFERENCES jurusan (id_jurusan)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
