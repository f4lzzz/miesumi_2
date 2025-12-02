-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2025 at 03:13 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mie_sumi_update`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `level_akses` varchar(50) DEFAULT NULL,
  `id_pesanan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `level_akses`, `id_pesanan`) VALUES
(1, 'Suyatmi', '$2y$10$kGjvr2NMxBKl796FuHTQx.XB15KQpwilIfwNvGjANknEMYlzJmxOm', '', NULL),
(2, 'Falzz', '$2y$10$pmFsXjPL/nRqMt677QN9YuE3zSgo2nxpCZtTIPLkzeu7w/f.bplZ2', 'kasir', NULL),
(3, 'Faul', '$2y$10$gXiUdJ9lHipoMGEP9ZCZQOHs2abwS7ecvRNz/d3lFHltB0Drg8l9C', 'admin', NULL),
(4, 'Linda', '$2y$10$GBEUQRNvuZ/U2kq8B9CqrOPp0NJ0uk3SH903ha/A7qKPS4eA2qeP2', 'admin', NULL),
(5, 'Aulia', '$2y$10$Na5UFjnKr8G9.ya5LLKyRuI4OHDO4H3PgEddGIiFRxBiRynEiRtuy', 'admin', NULL),
(6, 'adminfaul', '$2y$10$C1Njr1cChuyXd/bKqhgi2OO5oO9Hyonj/XL1mHRJ1IW0F9tJ/NuSy', 'kasir', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `detail_pendapatan`
--

CREATE TABLE `detail_pendapatan` (
  `id_detail` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah_terjual` int(11) DEFAULT 0,
  `total_pendapatan` decimal(15,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_admin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_pendapatan`
--

INSERT INTO `detail_pendapatan` (`id_detail`, `id_menu`, `tanggal`, `jumlah_terjual`, `total_pendapatan`, `created_at`, `updated_at`, `id_admin`) VALUES
(38, 74, '2025-11-29', 14, 98000.00, '2025-11-28 17:48:14', '2025-11-29 12:56:16', NULL),
(39, 75, '2025-11-29', 8, 64000.00, '2025-11-28 17:48:14', '2025-11-29 12:53:15', NULL),
(41, 76, '2025-11-29', 3, 33000.00, '2025-11-29 12:53:15', '2025-11-29 12:53:15', NULL),
(44, 79, '2025-11-30', 17, 68000.00, '2025-11-30 14:43:42', '2025-11-30 14:43:42', NULL),
(45, 77, '2025-11-30', 2, 24000.00, '2025-11-30 14:43:42', '2025-11-30 14:43:42', NULL),
(46, 76, '2025-11-30', 2, 22000.00, '2025-11-30 14:43:42', '2025-11-30 14:43:42', NULL),
(47, 75, '2025-11-30', 13, 104000.00, '2025-11-30 14:43:42', '2025-11-30 14:43:42', NULL),
(48, 74, '2025-12-01', 4, 28000.00, '2025-12-01 06:37:41', '2025-12-01 06:37:41', NULL),
(49, 75, '2025-12-01', 3, 24000.00, '2025-12-01 06:37:41', '2025-12-01 06:37:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_detail` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `id_admin` int(11) DEFAULT NULL,
  `nama_pemesan` varchar(100) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `status_pesanan` enum('pending','selesai','batal') DEFAULT 'pending',
  `waktu` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_pesanan`
--

INSERT INTO `detail_pesanan` (`id_detail`, `id_menu`, `id_pelanggan`, `id_admin`, `nama_pemesan`, `jumlah`, `subtotal`, `status_pesanan`, `waktu`) VALUES
(109, 78, NULL, NULL, 'Aulia', 2, 8000, 'pending', '2025-11-30 12:55:20'),
(110, 74, NULL, NULL, 'Aulia', 2, 14000, 'pending', '2025-11-30 12:55:21'),
(111, 75, NULL, NULL, 'Alex', 1, 8000, 'pending', '2025-11-30 12:55:44'),
(112, 78, NULL, NULL, 'Alex', 2, 8000, 'pending', '2025-11-30 12:55:44'),
(113, 79, NULL, NULL, 'Linda', 4, 16000, 'pending', '2025-11-30 12:56:13'),
(114, 77, NULL, NULL, 'Linda', 3, 36000, 'pending', '2025-11-30 12:56:13'),
(124, 75, NULL, NULL, 'Putra Ahmudal', 1, 8000, 'pending', '2025-12-01 07:37:21'),
(125, 74, NULL, NULL, 'Putra Ahmudal', 3, 21000, 'pending', '2025-12-01 07:37:21'),
(126, 79, NULL, NULL, 'Putra Ahmudal', 2, 8000, 'pending', '2025-12-01 07:37:21'),
(127, 78, NULL, NULL, 'Putra Ahmudal', 1, 4000, 'pending', '2025-12-01 07:37:21'),
(128, 82, NULL, NULL, 'Widyaa', 4, 16000, 'pending', '2025-12-02 02:12:33'),
(129, 81, NULL, NULL, 'Widyaa', 2, 10000, 'pending', '2025-12-02 02:12:33'),
(130, 77, NULL, NULL, 'Widyaa', 2, 24000, 'pending', '2025-12-02 02:12:33'),
(131, 74, NULL, NULL, 'Widyaa', 4, 28000, 'pending', '2025-12-02 02:12:33');

--
-- Triggers `detail_pesanan`
--
DELIMITER $$
CREATE TRIGGER `trg_adjust_stock_after_update` AFTER UPDATE ON `detail_pesanan` FOR EACH ROW BEGIN
    -- Jika status berubah menjadi 'selesai', kurangi stok
    IF NEW.status_pesanan = 'selesai' AND OLD.status_pesanan <> 'selesai' THEN
        UPDATE menu 
        SET stok_menu = stok_menu - NEW.jumlah
        WHERE id_menu = NEW.id_menu;
    END IF;

    -- Jika status berubah menjadi 'batal' dari sebelumnya bukan 'batal', kembalikan stok
    IF NEW.status_pesanan = 'batal' AND OLD.status_pesanan <> 'batal' THEN
        UPDATE menu 
        SET stok_menu = stok_menu + NEW.jumlah
        WHERE id_menu = NEW.id_menu;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_hitung_subtotal_before_insert` BEFORE INSERT ON `detail_pesanan` FOR EACH ROW BEGIN
  DECLARE v_harga DECIMAL(10,2) DEFAULT 0;
  SELECT harga INTO v_harga FROM menu WHERE id_menu = NEW.id_menu LIMIT 1;
  SET NEW.subtotal = COALESCE(v_harga,0) * NEW.jumlah;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_hitung_subtotal_before_update` BEFORE UPDATE ON `detail_pesanan` FOR EACH ROW BEGIN
  DECLARE v_harga DECIMAL(10,2) DEFAULT 0;
  SELECT harga INTO v_harga FROM menu WHERE id_menu = NEW.id_menu LIMIT 1;
  SET NEW.subtotal = COALESCE(v_harga,0) * NEW.jumlah;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `trg_restore_stock_after_delete` AFTER DELETE ON `detail_pesanan` FOR EACH ROW BEGIN
  IF OLD.status_pesanan = 'selesai' THEN
    UPDATE menu
    SET stok_menu = stok_menu + OLD.jumlah
    WHERE id_menu = OLD.id_menu;
  END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `membutuhkan`
--

CREATE TABLE `membutuhkan` (
  `id_membutuhkan` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `id_bahan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(100) DEFAULT NULL,
  `kategori_menu` varchar(100) DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `stok_menu` int(11) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `id_detail` int(11) DEFAULT NULL,
  `id_stok` int(11) DEFAULT NULL,
  `id_admin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id_menu`, `nama_menu`, `kategori_menu`, `harga`, `stok_menu`, `gambar`, `id_detail`, `id_stok`, `id_admin`) VALUES
(74, 'Mie Ayam', 'Makanan', 7000.00, 64, '1764205560_IMG_20251114_154946_289.jpg', NULL, 1, NULL),
(75, 'Mie Ayam Ceker', 'Makanan', 8000.00, 66, '1764205597_IMG_20251114_154818_148.jpg', NULL, 2, NULL),
(76, 'Mie Ayam Bakso', 'Makanan', 11000.00, 92, '1764205647_IMG_20251114_155103_316.jpg', NULL, 3, NULL),
(77, 'Mie Ayam Spesial', 'Makanan', 12000.00, 90, '1764205676_IMG_20251114_155227_008.jpg', NULL, 4, NULL),
(78, 'Es Teh', 'Minuman', 4000.00, 95, '1764235335_Gemini_Generated_Image_plz4jpplz4jpplz4.png', NULL, 5, NULL),
(79, 'Es Jeruk', 'Minuman', 4000.00, 77, '1764235404_Gemini_Generated_Image_b7hj9xb7hj9xb7hj.png', NULL, 7, NULL),
(80, 'Kopi ', 'Minuman', 4000.00, 100, '1764317326_kopi panas.png', NULL, 6, NULL),
(81, 'Kopi Susu', 'Minuman', 5000.00, 98, '1764317385_kopi susu.png', NULL, 10, NULL),
(82, 'Es Susu', 'Makanan', 4000.00, 96, '1764317413_es susu.png', NULL, 9, NULL);

--
-- Triggers `menu`
--
DELIMITER $$
CREATE TRIGGER `trg_kurangi_bahan_after_insert_menu` AFTER INSERT ON `menu` FOR EACH ROW BEGIN
    UPDATE stok_bahan_baku
    SET jumlah = jumlah - 0
    WHERE id_stok = NEW.id_stok;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rekap_pendapatan`
--

CREATE TABLE `rekap_pendapatan` (
  `id_rekap` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `periode_type` enum('harian','mingguan','bulanan') NOT NULL,
  `total_transaksi` int(11) DEFAULT 0,
  `total_item_terjual` int(11) DEFAULT 0,
  `total_pendapatan` decimal(15,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_admin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rekap_pendapatan`
--

INSERT INTO `rekap_pendapatan` (`id_rekap`, `tanggal`, `periode_type`, `total_transaksi`, `total_item_terjual`, `total_pendapatan`, `created_at`, `updated_at`, `id_admin`) VALUES
(112, '2025-11-29', 'harian', 6, 25, 195000.00, '2025-11-28 17:48:14', '2025-11-29 12:56:16', NULL),
(113, '2025-11-24', 'mingguan', 10, 59, 413000.00, '2025-11-28 17:48:14', '2025-11-30 14:43:42', NULL),
(114, '2025-11-01', 'bulanan', 10, 59, 413000.00, '2025-11-28 17:48:14', '2025-11-30 14:43:42', NULL),
(130, '2025-11-30', 'harian', 4, 34, 218000.00, '2025-11-30 14:43:42', '2025-11-30 14:43:42', NULL),
(142, '2025-12-01', 'harian', 2, 7, 52000.00, '2025-12-01 06:37:41', '2025-12-01 06:37:41', NULL),
(143, '2025-12-01', 'mingguan', 2, 7, 52000.00, '2025-12-01 06:37:41', '2025-12-01 06:37:41', NULL),
(144, '2025-12-01', 'bulanan', 2, 7, 52000.00, '2025-12-01 06:37:41', '2025-12-01 06:37:41', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_pemesanan`
--

CREATE TABLE `riwayat_pemesanan` (
  `id_riwayat` int(11) NOT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `nama_pemesan` varchar(100) NOT NULL,
  `rincian_menu` text DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `subtotal` int(11) DEFAULT NULL,
  `status_pesanan` enum('pending','selesai','batal') DEFAULT 'pending',
  `waktu` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_menu` int(11) DEFAULT NULL,
  `id_admin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `riwayat_pemesanan`
--

INSERT INTO `riwayat_pemesanan` (`id_riwayat`, `id_pelanggan`, `nama_pemesan`, `rincian_menu`, `jumlah`, `subtotal`, `status_pesanan`, `waktu`, `id_menu`, `id_admin`) VALUES
(91, NULL, 'ahmadia', 'Mie Ayam', 5, 35000, 'selesai', '2025-11-28 17:48:14', 74, NULL),
(92, NULL, 'ahmadia', 'Mie Ayam Ceker', 2, 16000, 'selesai', '2025-11-28 17:48:14', 75, NULL),
(93, NULL, 'ahmudal', 'Mie Ayam Ceker', 3, 24000, 'selesai', '2025-11-29 12:05:02', 75, NULL),
(94, NULL, 'ahmudalz', 'Mie Ayam Bakso', 3, 33000, 'selesai', '2025-11-29 12:53:15', 76, NULL),
(95, NULL, 'ahmudalz', 'Mie Ayam Ceker', 3, 24000, 'selesai', '2025-11-29 12:53:15', 75, NULL),
(97, NULL, 'aleeeexyx', 'Es Jeruk', 17, 68000, 'selesai', '2025-11-30 14:43:42', 79, NULL),
(98, NULL, 'aleeeexyx', 'Mie Ayam Spesial', 2, 24000, 'selesai', '2025-11-30 14:43:42', 77, NULL),
(99, NULL, 'aleeeexyx', 'Mie Ayam Bakso', 2, 22000, 'selesai', '2025-11-30 14:43:42', 76, NULL),
(100, NULL, 'aleeeexyx', 'Mie Ayam Ceker', 13, 104000, 'selesai', '2025-11-30 14:43:42', 75, NULL),
(101, NULL, 'nizam', 'Es Jeruk', 47, 188000, 'batal', '2025-12-01 03:03:04', 79, NULL),
(102, NULL, 'coba', 'Es Jeruk', 32, 128000, 'batal', '2025-12-01 03:03:06', 79, NULL),
(103, NULL, 'zawursio', 'Mie Ayam', 4, 28000, 'selesai', '2025-12-01 06:37:41', 74, NULL),
(104, NULL, 'zawursio', 'Mie Ayam Ceker', 3, 24000, 'selesai', '2025-12-01 06:37:41', 75, NULL),
(105, NULL, 'ababil', 'Mie Ayam', 2, 14000, 'batal', '2025-12-01 06:44:58', 74, NULL);

--
-- Triggers `riwayat_pemesanan`
--
DELIMITER $$
CREATE TRIGGER `after_pesanan_batal` AFTER UPDATE ON `riwayat_pemesanan` FOR EACH ROW BEGIN
    DECLARE tanggal_pesanan DATE;
    DECLARE minggu_mulai DATE;
    DECLARE bulan_pesanan DATE;
    
    -- Jika status berubah dari selesai ke batal
    IF OLD.status_pesanan = 'selesai' AND NEW.status_pesanan = 'batal' THEN
        
        SET tanggal_pesanan = DATE(OLD.waktu);
        SET minggu_mulai = DATE_SUB(tanggal_pesanan, INTERVAL WEEKDAY(tanggal_pesanan) DAY);
        SET bulan_pesanan = DATE_FORMAT(OLD.waktu, '%Y-%m-01');
        
        -- 1. ROLLBACK REKAP HARIAN
        UPDATE rekap_pendapatan
        SET total_transaksi = GREATEST(total_transaksi - 1, 0),
            total_item_terjual = GREATEST(total_item_terjual - OLD.jumlah, 0),
            total_pendapatan = GREATEST(total_pendapatan - OLD.subtotal, 0)
        WHERE tanggal = tanggal_pesanan AND periode_type = 'harian';
        
        -- 2. ROLLBACK REKAP MINGGUAN
        UPDATE rekap_pendapatan
        SET total_transaksi = GREATEST(total_transaksi - 1, 0),
            total_item_terjual = GREATEST(total_item_terjual - OLD.jumlah, 0),
            total_pendapatan = GREATEST(total_pendapatan - OLD.subtotal, 0)
        WHERE tanggal = minggu_mulai AND periode_type = 'mingguan';
        
        -- 3. ROLLBACK REKAP BULANAN
        UPDATE rekap_pendapatan
        SET total_transaksi = GREATEST(total_transaksi - 1, 0),
            total_item_terjual = GREATEST(total_item_terjual - OLD.jumlah, 0),
            total_pendapatan = GREATEST(total_pendapatan - OLD.subtotal, 0)
        WHERE tanggal = bulan_pesanan AND periode_type = 'bulanan';
        
        -- 4. ROLLBACK DETAIL PENDAPATAN PER MENU
        UPDATE detail_pendapatan
        SET jumlah_terjual = GREATEST(jumlah_terjual - OLD.jumlah, 0),
            total_pendapatan = GREATEST(total_pendapatan - OLD.subtotal, 0)
        WHERE id_menu = OLD.id_menu AND tanggal = tanggal_pesanan;
        
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_pesanan_selesai` AFTER INSERT ON `riwayat_pemesanan` FOR EACH ROW BEGIN
    DECLARE tanggal_pesanan DATE;
    DECLARE minggu_mulai DATE;
    DECLARE bulan_pesanan DATE;
    
    -- Ambil tanggal dari waktu pesanan
    SET tanggal_pesanan = DATE(NEW.waktu);
    -- Hitung Senin di minggu tersebut
    SET minggu_mulai = DATE_SUB(tanggal_pesanan, INTERVAL WEEKDAY(tanggal_pesanan) DAY);
    -- Ambil tanggal 1 di bulan tersebut
    SET bulan_pesanan = DATE_FORMAT(NEW.waktu, '%Y-%m-01');
    
    -- Hanya proses jika status selesai
    IF NEW.status_pesanan = 'selesai' THEN
        
        -- 1. UPDATE REKAP HARIAN
        INSERT INTO rekap_pendapatan (tanggal, periode_type, total_transaksi, total_item_terjual, total_pendapatan)
        VALUES (tanggal_pesanan, 'harian', 1, NEW.jumlah, NEW.subtotal)
        ON DUPLICATE KEY UPDATE
            total_transaksi = total_transaksi + 1,
            total_item_terjual = total_item_terjual + NEW.jumlah,
            total_pendapatan = total_pendapatan + NEW.subtotal;
        
        -- 2. UPDATE REKAP MINGGUAN (berdasarkan Senin di minggu tersebut)
        INSERT INTO rekap_pendapatan (tanggal, periode_type, total_transaksi, total_item_terjual, total_pendapatan)
        VALUES (minggu_mulai, 'mingguan', 1, NEW.jumlah, NEW.subtotal)
        ON DUPLICATE KEY UPDATE
            total_transaksi = total_transaksi + 1,
            total_item_terjual = total_item_terjual + NEW.jumlah,
            total_pendapatan = total_pendapatan + NEW.subtotal;
        
        -- 3. UPDATE REKAP BULANAN (tanggal 1 setiap bulan)
        INSERT INTO rekap_pendapatan (tanggal, periode_type, total_transaksi, total_item_terjual, total_pendapatan)
        VALUES (bulan_pesanan, 'bulanan', 1, NEW.jumlah, NEW.subtotal)
        ON DUPLICATE KEY UPDATE
            total_transaksi = total_transaksi + 1,
            total_item_terjual = total_item_terjual + NEW.jumlah,
            total_pendapatan = total_pendapatan + NEW.subtotal;
        
        -- 4. UPDATE DETAIL PENDAPATAN PER MENU
        INSERT INTO detail_pendapatan (id_menu, tanggal, jumlah_terjual, total_pendapatan)
        VALUES (NEW.id_menu, tanggal_pesanan, NEW.jumlah, NEW.subtotal)
        ON DUPLICATE KEY UPDATE
            jumlah_terjual = jumlah_terjual + NEW.jumlah,
            total_pendapatan = total_pendapatan + NEW.subtotal;
            
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `stok_bahan_baku`
--

CREATE TABLE `stok_bahan_baku` (
  `id_stok` int(11) NOT NULL,
  `nama_bahan` varchar(100) NOT NULL,
  `jumlah` int(11) NOT NULL DEFAULT 500,
  `id_supplier` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stok_bahan_baku`
--

INSERT INTO `stok_bahan_baku` (`id_stok`, `nama_bahan`, `jumlah`, `id_supplier`) VALUES
(1, 'Mie Ayam', 219, 1),
(2, 'Mie Ayam Ceker', 389, 1),
(3, 'Mie Ayam Bakso', 387, 1),
(4, 'Mie Ayam Spesial', 400, 1),
(5, 'Es Teh', 299, 1),
(6, 'Kopi', 400, 1),
(7, 'Es Jeruk', 400, 1),
(8, 'Teh Panas', 500, 1),
(9, 'Es Susu', 400, 1),
(10, 'Kopi Susu', 400, 1),
(11, 'Nutrisari', 500, 1),
(12, 'Es Kopi Susu', 490, 1);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama_supplier` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`) VALUES
(1, 'pasar_baru');

-- --------------------------------------------------------

--
-- Table structure for table `ulasan`
--

CREATE TABLE `ulasan` (
  `id_ulasan` int(11) NOT NULL,
  `id_pelanggan` int(11) DEFAULT NULL,
  `nama_pengguna` varchar(100) NOT NULL,
  `pesan` text NOT NULL,
  `tanggal_ulasan` datetime DEFAULT current_timestamp(),
  `id_admin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ulasan`
--

INSERT INTO `ulasan` (`id_ulasan`, `id_pelanggan`, `nama_pengguna`, `pesan`, `tanggal_ulasan`, `id_admin`) VALUES
(2, NULL, 'Linda', 'Mie Ayamnya Kurang kenyal', '2025-11-14 07:43:43', NULL),
(3, NULL, 'Dinda & Sheryn', 'enak bgt mi ayamnya :) btw free es teh 1 dong tiap jumat hehehe', '2025-11-14 09:27:28', NULL),
(4, NULL, 'LUTFI AQ', 'Mie ayammya sedap banget njir', '2025-11-16 18:40:26', NULL),
(8, NULL, 'Faul', 'Mie AYAM SEDAPPZZ', '2025-11-26 08:16:42', NULL),
(9, NULL, 'Linda', 'mir ayam sedapp', '2025-11-27 08:29:02', NULL),
(10, NULL, 'Haii', 'halo', '2025-11-29 00:07:32', NULL),
(11, NULL, 'alek', 'gelot', '2025-11-30 22:10:56', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD KEY `id_pesanan` (`id_pesanan`);

--
-- Indexes for table `detail_pendapatan`
--
ALTER TABLE `detail_pendapatan`
  ADD PRIMARY KEY (`id_detail`),
  ADD UNIQUE KEY `unique_menu_tanggal` (`id_menu`,`tanggal`),
  ADD KEY `idx_detail_menu_tanggal` (`id_menu`,`tanggal`),
  ADD KEY `fk_detail_pendapatan_admin` (`id_admin`);

--
-- Indexes for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_menu` (`id_menu`),
  ADD KEY `fk_detail_pesanan_pelanggan` (`id_pelanggan`),
  ADD KEY `fk_detail_pesanan_admin` (`id_admin`);

--
-- Indexes for table `membutuhkan`
--
ALTER TABLE `membutuhkan`
  ADD PRIMARY KEY (`id_membutuhkan`),
  ADD KEY `id_menu` (`id_menu`),
  ADD KEY `id_bahan` (`id_bahan`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`),
  ADD KEY `id_detail` (`id_detail`),
  ADD KEY `fk_menu_stok` (`id_stok`),
  ADD KEY `fk_menu_admin` (`id_admin`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `rekap_pendapatan`
--
ALTER TABLE `rekap_pendapatan`
  ADD PRIMARY KEY (`id_rekap`),
  ADD UNIQUE KEY `unique_periode` (`tanggal`,`periode_type`),
  ADD KEY `idx_rekap_tanggal_periode` (`tanggal`,`periode_type`),
  ADD KEY `fk_rekap_admin` (`id_admin`);

--
-- Indexes for table `riwayat_pemesanan`
--
ALTER TABLE `riwayat_pemesanan`
  ADD PRIMARY KEY (`id_riwayat`),
  ADD KEY `idx_riwayat_waktu_status` (`waktu`,`status_pesanan`),
  ADD KEY `fk_riwayat_admin` (`id_admin`),
  ADD KEY `fk_riwayat_pemesanan_pelanggan` (`id_pelanggan`);

--
-- Indexes for table `stok_bahan_baku`
--
ALTER TABLE `stok_bahan_baku`
  ADD PRIMARY KEY (`id_stok`),
  ADD KEY `id_supplier` (`id_supplier`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD PRIMARY KEY (`id_ulasan`),
  ADD KEY `fk_ulasan_admin` (`id_admin`),
  ADD KEY `fk_ulasan_pelanggan` (`id_pelanggan`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `detail_pendapatan`
--
ALTER TABLE `detail_pendapatan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50;

--
-- AUTO_INCREMENT for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT for table `membutuhkan`
--
ALTER TABLE `membutuhkan`
  MODIFY `id_membutuhkan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rekap_pendapatan`
--
ALTER TABLE `rekap_pendapatan`
  MODIFY `id_rekap` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=148;

--
-- AUTO_INCREMENT for table `riwayat_pemesanan`
--
ALTER TABLE `riwayat_pemesanan`
  MODIFY `id_riwayat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=106;

--
-- AUTO_INCREMENT for table `stok_bahan_baku`
--
ALTER TABLE `stok_bahan_baku`
  MODIFY `id_stok` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `id_ulasan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`);

--
-- Constraints for table `detail_pendapatan`
--
ALTER TABLE `detail_pendapatan`
  ADD CONSTRAINT `detail_pendapatan_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_detail_pendapatan_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detail_pesanan_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_detail_pesanan_pelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `membutuhkan`
--
ALTER TABLE `membutuhkan`
  ADD CONSTRAINT `membutuhkan_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `membutuhkan_ibfk_2` FOREIGN KEY (`id_bahan`) REFERENCES `stok_bahan_baku` (`id_stok`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `fk_menu_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_menu_stok` FOREIGN KEY (`id_stok`) REFERENCES `stok_bahan_baku` (`id_stok`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`id_detail`) REFERENCES `detail_pesanan` (`id_detail`);

--
-- Constraints for table `rekap_pendapatan`
--
ALTER TABLE `rekap_pendapatan`
  ADD CONSTRAINT `fk_rekap_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `riwayat_pemesanan`
--
ALTER TABLE `riwayat_pemesanan`
  ADD CONSTRAINT `fk_riwayat_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_riwayat_pemesanan_pelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `stok_bahan_baku`
--
ALTER TABLE `stok_bahan_baku`
  ADD CONSTRAINT `stok_bahan_baku_ibfk_1` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `ulasan`
--
ALTER TABLE `ulasan`
  ADD CONSTRAINT `fk_ulasan_admin` FOREIGN KEY (`id_admin`) REFERENCES `admin` (`id_admin`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_ulasan_pelanggan` FOREIGN KEY (`id_pelanggan`) REFERENCES `pelanggan` (`id_pelanggan`) ON DELETE SET NULL ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
