-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Nov 2025 pada 09.03
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mie_ayam_suyatmi`
--

DELIMITER $$
--
-- Prosedur
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_recalculate_pendapatan` (IN `start_date` DATE, IN `end_date` DATE)   BEGIN
    -- Hapus data lama dalam range tanggal
    DELETE FROM rekap_pendapatan 
    WHERE tanggal BETWEEN start_date AND end_date;
    
    DELETE FROM detail_pendapatan 
    WHERE tanggal BETWEEN start_date AND end_date;
    
    -- Recalculate HARIAN dari riwayat_pemesanan
    INSERT INTO rekap_pendapatan (tanggal, periode_type, total_transaksi, total_item_terjual, total_pendapatan)
    SELECT 
        DATE(waktu) AS tanggal,
        'harian' AS periode_type,
        COUNT(*) AS total_transaksi,
        SUM(jumlah) AS total_item_terjual,
        SUM(subtotal) AS total_pendapatan
    FROM riwayat_pemesanan
    WHERE status_pesanan = 'selesai'
    AND DATE(waktu) BETWEEN start_date AND end_date
    GROUP BY DATE(waktu);
    
    -- Recalculate MINGGUAN
    INSERT INTO rekap_pendapatan (tanggal, periode_type, total_transaksi, total_item_terjual, total_pendapatan)
    SELECT 
        DATE_SUB(DATE(waktu), INTERVAL WEEKDAY(DATE(waktu)) DAY) AS minggu_mulai,
        'mingguan' AS periode_type,
        COUNT(*) AS total_transaksi,
        SUM(jumlah) AS total_item_terjual,
        SUM(subtotal) AS total_pendapatan
    FROM riwayat_pemesanan
    WHERE status_pesanan = 'selesai'
    AND DATE(waktu) BETWEEN start_date AND end_date
    GROUP BY DATE_SUB(DATE(waktu), INTERVAL WEEKDAY(DATE(waktu)) DAY);
    
    -- Recalculate BULANAN
    INSERT INTO rekap_pendapatan (tanggal, periode_type, total_transaksi, total_item_terjual, total_pendapatan)
    SELECT 
        DATE_FORMAT(waktu, '%Y-%m-01') AS bulan_mulai,
        'bulanan' AS periode_type,
        COUNT(*) AS total_transaksi,
        SUM(jumlah) AS total_item_terjual,
        SUM(subtotal) AS total_pendapatan
    FROM riwayat_pemesanan
    WHERE status_pesanan = 'selesai'
    AND DATE(waktu) BETWEEN start_date AND end_date
    GROUP BY DATE_FORMAT(waktu, '%Y-%m-01');
    
    -- Recalculate detail per menu
    INSERT INTO detail_pendapatan (id_menu, tanggal, jumlah_terjual, total_pendapatan)
    SELECT 
        id_menu,
        DATE(waktu) AS tanggal,
        SUM(jumlah) AS jumlah_terjual,
        SUM(subtotal) AS total_pendapatan
    FROM riwayat_pemesanan
    WHERE status_pesanan = 'selesai'
    AND DATE(waktu) BETWEEN start_date AND end_date
    GROUP BY id_menu, DATE(waktu);
    
    SELECT CONCAT('✅ Recalculate selesai untuk periode ', start_date, ' sampai ', end_date) AS message;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `level_akses` varchar(50) DEFAULT NULL,
  `id_pesanan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
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
-- Struktur dari tabel `bahan_baku`
--

CREATE TABLE `bahan_baku` (
  `id_bahan` int(11) NOT NULL,
  `nama_bahan` varchar(100) DEFAULT NULL,
  `jumlah_per_porsi` int(11) DEFAULT NULL,
  `stok_tersedia` int(11) DEFAULT NULL,
  `harga_beli` decimal(10,2) DEFAULT NULL,
  `stok_bahan_baku` varchar(100) DEFAULT NULL,
  `id_menu` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `belanja_harian`
--

CREATE TABLE `belanja_harian` (
  `id_belanja` int(11) NOT NULL,
  `tanggal_belanja` date DEFAULT NULL,
  `catatan_belanja` text DEFAULT NULL,
  `jam_belanja` time DEFAULT NULL,
  `total_belanja` decimal(10,2) DEFAULT NULL,
  `id_detail_belanja` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pendapatan`
--

CREATE TABLE `detail_pendapatan` (
  `id_detail` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jumlah_terjual` int(11) DEFAULT 0,
  `total_pendapatan` decimal(15,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `detail_pendapatan`
--

INSERT INTO `detail_pendapatan` (`id_detail`, `id_menu`, `tanggal`, `jumlah_terjual`, `total_pendapatan`, `created_at`, `updated_at`) VALUES
(5, 51, '2025-11-16', 4, 28000.00, '2025-11-16 11:47:40', '2025-11-16 11:47:40'),
(6, 52, '2025-11-16', 3, 24000.00, '2025-11-16 13:07:01', '2025-11-16 16:10:39'),
(8, 62, '2025-11-16', 1, 4000.00, '2025-11-16 16:10:39', '2025-11-16 16:10:39'),
(9, 52, '2025-11-17', 5, 40000.00, '2025-11-17 00:57:00', '2025-11-17 06:27:34'),
(10, 57, '2025-11-17', 1, 4000.00, '2025-11-17 00:57:00', '2025-11-17 00:57:00'),
(11, 51, '2025-11-17', 6, 42000.00, '2025-11-17 03:11:52', '2025-11-17 03:15:27'),
(13, 56, '2025-11-17', 7, 21000.00, '2025-11-17 03:11:52', '2025-11-17 06:27:34'),
(18, 62, '2025-11-18', 3, 12000.00, '2025-11-18 01:53:13', '2025-11-18 01:53:13'),
(19, 51, '2025-11-18', 4, 28000.00, '2025-11-18 06:18:12', '2025-11-18 13:34:22'),
(20, 52, '2025-11-18', 6, 48000.00, '2025-11-18 06:18:12', '2025-11-18 13:34:22'),
(21, 53, '2025-11-18', 2, 22000.00, '2025-11-18 07:40:36', '2025-11-18 07:40:36'),
(25, 58, '2025-11-18', 1, 4000.00, '2025-11-18 13:34:22', '2025-11-18 13:34:22'),
(26, 60, '2025-11-18', 1, 4000.00, '2025-11-18 13:34:22', '2025-11-18 13:34:22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id_detail` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `nama_pemesan` varchar(100) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `status_pesanan` enum('pending','selesai','batal') DEFAULT 'pending',
  `waktu` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Trigger `detail_pesanan`
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
-- Struktur dari tabel `membutuhkan`
--

CREATE TABLE `membutuhkan` (
  `id_menu` int(11) NOT NULL,
  `id_bahan` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `menu`
--

CREATE TABLE `menu` (
  `id_menu` int(11) NOT NULL,
  `nama_menu` varchar(100) DEFAULT NULL,
  `kategori_menu` varchar(100) DEFAULT NULL,
  `harga` decimal(10,2) DEFAULT NULL,
  `stok_menu` int(11) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `id_detail` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `menu`
--

INSERT INTO `menu` (`id_menu`, `nama_menu`, `kategori_menu`, `harga`, `stok_menu`, `gambar`, `id_detail`) VALUES
(51, 'Mie Ayam', 'Makanan', 7000.00, 88, '1763114495_IMG_20251114_154946_289.jpg', NULL),
(52, 'Mie Ayam Ceker', 'Makanan', 8000.00, 86, '1763185328_IMG_20251114_154818_148.jpg', NULL),
(53, 'Mie Ayam Bakso', 'Makanan', 11000.00, 98, '1763114814_IMG_20251114_155103_316.jpg', NULL),
(54, 'Mie Ayam Spesial', 'Makanan', 12000.00, 100, '1763114859_IMG_20251114_155227_008.jpg', NULL),
(56, 'Es Teh', 'Minuman', 3000.00, 93, '1763308641_Gemini_Generated_Image_plz4jpplz4jpplz4.png', NULL),
(57, 'Kopi ', 'Minuman', 4000.00, 99, '1763308690_Gemini_Generated_Image_2xmaxq2xmaxq2xma.png', NULL),
(58, 'Es Jeruk', 'Minuman', 4000.00, 99, '1763308745_Gemini_Generated_Image_b7hj9xb7hj9xb7hj.png', NULL),
(59, 'Teh Panas', 'Minuman', 3000.00, 100, '1763308774_Gemini_Generated_Image_pds3qrpds3qrpds3.png', NULL),
(60, 'Es Susu', 'Minuman', 4000.00, 99, '1763308836_Gemini_Generated_Image_qfkbfuqfkbfuqfkb.png', NULL),
(61, 'Kopi Susu', 'Minuman', 4000.00, 100, '1763308873_Gemini_Generated_Image_c2kta6c2kta6c2kt.png', NULL),
(62, 'Nutrisari ', 'Minuman', 4000.00, 96, '1763309175_Gemini_Generated_Image_omw1x9omw1x9omw1.png', NULL),
(63, 'Es Kopi Susu', 'Minuman', 5000.00, 100, '1763309368_Gemini_Generated_Image_y9k69ay9k69ay9k6 (1).png', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_pelanggan` varchar(100) DEFAULT NULL,
  `no_telepon` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `metode_bayar` varchar(50) DEFAULT NULL,
  `status_bayar` varchar(50) DEFAULT NULL,
  `id_pesanan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `nama_pemesan` varchar(100) NOT NULL,
  `items` text NOT NULL,
  `total_harga` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('pending','diproses','selesai') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rekap_pendapatan`
--

CREATE TABLE `rekap_pendapatan` (
  `id_rekap` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `periode_type` enum('harian','mingguan','bulanan') NOT NULL,
  `total_transaksi` int(11) DEFAULT 0,
  `total_item_terjual` int(11) DEFAULT 0,
  `total_pendapatan` decimal(15,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rekap_pendapatan`
--

INSERT INTO `rekap_pendapatan` (`id_rekap`, `tanggal`, `periode_type`, `total_transaksi`, `total_item_terjual`, `total_pendapatan`, `created_at`, `updated_at`) VALUES
(1, '2025-11-13', 'harian', 4, 49, 376000.00, '2025-11-13 05:52:18', '2025-11-13 08:39:27'),
(2, '2025-11-10', 'mingguan', 8, 57, 432000.00, '2025-11-13 05:52:18', '2025-11-16 16:10:39'),
(3, '2025-11-01', 'bulanan', 26, 93, 657000.00, '2025-11-13 05:52:18', '2025-11-18 13:34:22'),
(13, '2025-11-16', 'harian', 4, 8, 56000.00, '2025-11-16 11:47:40', '2025-11-16 16:10:39'),
(25, '2025-11-17', 'harian', 9, 19, 107000.00, '2025-11-17 00:57:00', '2025-11-17 06:27:34'),
(26, '2025-11-17', 'mingguan', 18, 36, 225000.00, '2025-11-17 00:57:00', '2025-11-18 13:34:22'),
(52, '2025-11-18', 'harian', 9, 17, 118000.00, '2025-11-18 01:53:13', '2025-11-18 13:34:22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_pemesanan`
--

CREATE TABLE `riwayat_pemesanan` (
  `id_riwayat` int(11) NOT NULL,
  `nama_pemesan` varchar(100) NOT NULL,
  `rincian_menu` text DEFAULT NULL,
  `jumlah` int(11) DEFAULT NULL,
  `subtotal` int(11) DEFAULT NULL,
  `status_pesanan` enum('pending','selesai','batal') DEFAULT 'pending',
  `waktu` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_menu` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `riwayat_pemesanan`
--

INSERT INTO `riwayat_pemesanan` (`id_riwayat`, `nama_pemesan`, `rincian_menu`, `jumlah`, `subtotal`, `status_pesanan`, `waktu`, `id_menu`) VALUES
(48, 'Sheryn', 'Mie Ayam Ceker', 2, 16000, 'selesai', '2025-11-13 05:52:18', 45),
(49, 'Sheryn', 'Es Jeruk', 2, 8000, 'selesai', '2025-11-13 05:52:18', 48),
(51, 'Falzz', 'Mie Ayam Ceker', 43, 344000, 'selesai', '2025-11-13 08:39:27', 45),
(52, 'Alexsys', 'Mie Ayam', 4, 28000, 'selesai', '2025-11-16 11:47:40', 51),
(53, 'ahmad', 'Mie Ayam Ceker', 2, 16000, 'selesai', '2025-11-16 13:07:01', 52),
(54, 'Faul MOchamad', 'Mie Ayam Ceker', 1, 8000, 'selesai', '2025-11-16 16:10:39', 52),
(55, 'Faul MOchamad', 'Nutrisari ', 1, 4000, 'selesai', '2025-11-16 16:10:39', 62),
(56, 'linda', 'Mie Ayam Ceker', 1, 8000, 'selesai', '2025-11-17 00:57:00', 52),
(57, 'linda', 'Kopi ', 1, 4000, 'selesai', '2025-11-17 00:57:00', 57),
(58, 'mozza', 'Mie Ayam', 2, 14000, 'selesai', '2025-11-17 03:11:52', 51),
(59, 'mozza', 'Mie Ayam', 2, 14000, 'selesai', '2025-11-17 03:11:52', 51),
(60, 'mozza', 'Es Teh', 2, 6000, 'selesai', '2025-11-17 03:11:52', 56),
(61, 'dimas aldi', 'Mie Ayam Bakso', 100, 1100000, 'batal', '2025-11-17 03:14:23', 53),
(66, 'ahmad', 'Mie Ayam Spesial', 2, 24000, 'batal', '2025-11-18 01:39:05', 54),
(67, 'faul', 'Mie Ayam', 2, 14000, 'batal', '2025-11-18 01:39:20', 51),
(68, 'faul', 'Mie Ayam Ceker', 2, 16000, 'batal', '2025-11-18 01:39:20', 52),
(69, 'widya', 'Nutrisari ', 3, 12000, 'selesai', '2025-11-18 01:53:13', 62),
(70, 'ahmad', 'Mie Ayam', 2, 14000, 'selesai', '2025-11-18 06:18:12', 51),
(71, 'ahmad', 'Mie Ayam Ceker', 2, 16000, 'selesai', '2025-11-18 06:18:12', 52),
(72, 'Michelle', 'Mie Ayam Ceker', 2, 16000, 'batal', '2025-11-18 07:39:37', 52),
(73, 'Michelle', 'Es Teh', 2, 6000, 'batal', '2025-11-18 07:39:38', 56),
(76, 'Linda', 'Mie Ayam', 2, 14000, 'selesai', '2025-11-18 13:34:22', 51),
(77, 'Linda', 'Mie Ayam Ceker', 2, 16000, 'selesai', '2025-11-18 13:34:22', 52),
(78, 'Linda', 'Es Jeruk', 1, 4000, 'selesai', '2025-11-18 13:34:22', 58),
(79, 'Linda', 'Es Susu', 1, 4000, 'selesai', '2025-11-18 13:34:22', 60);

--
-- Trigger `riwayat_pemesanan`
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
-- Struktur dari tabel `ulasan`
--

CREATE TABLE `ulasan` (
  `id_ulasan` int(11) NOT NULL,
  `nama_pengguna` varchar(100) NOT NULL,
  `pesan` text NOT NULL,
  `tanggal_ulasan` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ulasan`
--

INSERT INTO `ulasan` (`id_ulasan`, `nama_pengguna`, `pesan`, `tanggal_ulasan`) VALUES
(2, 'Linda', 'Mie Ayamnya Kurang kenyal', '2025-11-14 07:43:43'),
(3, 'Dinda & Sheryn', 'enak bgt mi ayamnya :) btw free es teh 1 dong tiap jumat hehehe', '2025-11-14 09:27:28'),
(4, 'LUTFI AQ', 'Mie ayammya sedap banget njir', '2025-11-16 18:40:26');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD KEY `id_pesanan` (`id_pesanan`);

--
-- Indeks untuk tabel `bahan_baku`
--
ALTER TABLE `bahan_baku`
  ADD PRIMARY KEY (`id_bahan`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indeks untuk tabel `belanja_harian`
--
ALTER TABLE `belanja_harian`
  ADD PRIMARY KEY (`id_belanja`),
  ADD KEY `id_detail_belanja` (`id_detail_belanja`);

--
-- Indeks untuk tabel `detail_pendapatan`
--
ALTER TABLE `detail_pendapatan`
  ADD PRIMARY KEY (`id_detail`),
  ADD UNIQUE KEY `unique_menu_tanggal` (`id_menu`,`tanggal`),
  ADD KEY `idx_detail_menu_tanggal` (`id_menu`,`tanggal`);

--
-- Indeks untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_menu` (`id_menu`);

--
-- Indeks untuk tabel `membutuhkan`
--
ALTER TABLE `membutuhkan`
  ADD PRIMARY KEY (`id_menu`,`id_bahan`),
  ADD KEY `id_bahan` (`id_bahan`);

--
-- Indeks untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id_menu`),
  ADD KEY `id_detail` (`id_detail`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_pesanan` (`id_pesanan`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`);

--
-- Indeks untuk tabel `rekap_pendapatan`
--
ALTER TABLE `rekap_pendapatan`
  ADD PRIMARY KEY (`id_rekap`),
  ADD UNIQUE KEY `unique_periode` (`tanggal`,`periode_type`),
  ADD KEY `idx_rekap_tanggal_periode` (`tanggal`,`periode_type`);

--
-- Indeks untuk tabel `riwayat_pemesanan`
--
ALTER TABLE `riwayat_pemesanan`
  ADD PRIMARY KEY (`id_riwayat`),
  ADD KEY `idx_riwayat_waktu_status` (`waktu`,`status_pesanan`);

--
-- Indeks untuk tabel `ulasan`
--
ALTER TABLE `ulasan`
  ADD PRIMARY KEY (`id_ulasan`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `bahan_baku`
--
ALTER TABLE `bahan_baku`
  MODIFY `id_bahan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `belanja_harian`
--
ALTER TABLE `belanja_harian`
  MODIFY `id_belanja` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `detail_pendapatan`
--
ALTER TABLE `detail_pendapatan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT untuk tabel `menu`
--
ALTER TABLE `menu`
  MODIFY `id_menu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `rekap_pendapatan`
--
ALTER TABLE `rekap_pendapatan`
  MODIFY `id_rekap` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT untuk tabel `riwayat_pemesanan`
--
ALTER TABLE `riwayat_pemesanan`
  MODIFY `id_riwayat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;

--
-- AUTO_INCREMENT untuk tabel `ulasan`
--
ALTER TABLE `ulasan`
  MODIFY `id_ulasan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`);

--
-- Ketidakleluasaan untuk tabel `bahan_baku`
--
ALTER TABLE `bahan_baku`
  ADD CONSTRAINT `bahan_baku_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`);

--
-- Ketidakleluasaan untuk tabel `detail_pendapatan`
--
ALTER TABLE `detail_pendapatan`
  ADD CONSTRAINT `detail_pendapatan_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `membutuhkan`
--
ALTER TABLE `membutuhkan`
  ADD CONSTRAINT `membutuhkan_ibfk_1` FOREIGN KEY (`id_menu`) REFERENCES `menu` (`id_menu`),
  ADD CONSTRAINT `membutuhkan_ibfk_2` FOREIGN KEY (`id_bahan`) REFERENCES `bahan_baku` (`id_bahan`);

--
-- Ketidakleluasaan untuk tabel `menu`
--
ALTER TABLE `menu`
  ADD CONSTRAINT `menu_ibfk_1` FOREIGN KEY (`id_detail`) REFERENCES `detail_pesanan` (`id_detail`);

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`id_pesanan`) REFERENCES `pesanan` (`id_pesanan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
