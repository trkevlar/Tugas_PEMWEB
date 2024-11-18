CREATE DATABASE spikoe_resto;
USE spikoe_resto;

-- Tabel untuk manajemen pengguna
CREATE TABLE pengguna (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    no_telepon VARCHAR(15),
    role ENUM('admin', 'pelanggan') DEFAULT 'pelanggan',
    dibuat_pada TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel untuk manajemen pesanan
CREATE TABLE pesanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nomor_pesanan VARCHAR(20) NOT NULL UNIQUE,
    nama_pelanggan VARCHAR(100),
    total_harga DECIMAL(10, 2),
    status ENUM('baru', 'proses', 'selesai') DEFAULT 'baru',
    metode_pembayaran ENUM('tunai', 'kartu_kredit', 'gopay', 'transfer_bank') DEFAULT 'tunai',
    dibuat_pada TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel untuk detail pesanan
CREATE TABLE detail_pesanan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pesanan_id INT,
    nama_item VARCHAR(100),
    jumlah INT DEFAULT 1,
    harga DECIMAL(10, 2),
    FOREIGN KEY (pesanan_id) REFERENCES pesanan(id) ON DELETE CASCADE
);

-- Tabel untuk manajemen reservasi
CREATE TABLE reservasi (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nomor_reservasi VARCHAR(20) NOT NULL UNIQUE,
    nama_pelanggan VARCHAR(100),
    waktu_reservasi TIME,
    tanggal_reservasi DATE,
    jumlah_kursi INT,
    catatan TEXT,
    status ENUM('menunggu', 'dikonfirmasi', 'dibatalkan') DEFAULT 'menunggu',
    dibuat_pada TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel untuk menu
CREATE TABLE menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_item VARCHAR(100) NOT NULL UNIQUE,
    deskripsi TEXT,
    harga DECIMAL(10, 2),
    dibuat_pada TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel untuk manajemen konten
CREATE TABLE konten (
    id INT AUTO_INCREMENT PRIMARY KEY,
    halaman ENUM('beranda', 'menu', 'blog', 'faq', 'tentang_kami') NOT NULL,
    font VARCHAR(100),
    judul_halaman VARCHAR(255),
    deskripsi_seo VARCHAR(255),
    isi_konten TEXT,
    dibuat_pada TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel untuk pengaturan operasional
CREATE TABLE jam_operasional (
    id INT AUTO_INCREMENT PRIMARY KEY,
    hari ENUM('senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu') NOT NULL,
    waktu_buka TIME,
    waktu_tutup TIME
);

-- Tabel untuk laporan keuangan
CREATE TABLE laporan_keuangan (
    id INT AUTO_INCREMENT PRIMARY KEY,
    jumlah_transaksi INT,
    total_pendapatan DECIMAL(15, 2),
    rata_pendapatan DECIMAL(15, 2),
    total_pengeluaran DECIMAL(15, 2),
    periode_mulai DATE,
    periode_akhir DATE,
    dibuat_pada TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel untuk manajemen pembayaran
CREATE TABLE pembayaran (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pesanan_id INT,
    metode_pembayaran ENUM('tunai', 'kartu_kredit', 'gopay', 'transfer_bank') DEFAULT 'tunai',
    jumlah DECIMAL(10, 2),
    status ENUM('menunggu', 'selesai') DEFAULT 'menunggu',
    tanggal_pembayaran TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pesanan_id) REFERENCES pesanan(id) ON DELETE SET NULL
);

-- Tabel untuk log aktivitas pengguna
CREATE TABLE log_aktivitas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pengguna_id INT,
    aktivitas VARCHAR(255),
    waktu_aktivitas TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pengguna_id) REFERENCES pengguna(id) ON DELETE CASCADE
);

INSERT INTO pengguna (username, password, email, no_telepon, role) 
VALUES ('adminspikoeresto', '1q2w3e4r5t', 'adminspikoeresto@gmail.com', '081255259452', 'admin')
ON DUPLICATE KEY UPDATE 
password='1q2w3e4r5t', email='adminspikoeresto@gmail.com', no_telepon='081255259452', role='admin';