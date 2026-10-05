-- ============================================================
-- Database Export: aabw
-- Aplikasi Akuntansi Berbasis Web (AABW) - CodeIgniter 4
-- Tutorial: Slope Positif (Videos 1 - 20 Final)
-- Date: 2026-09-24 13:37:15
-- ============================================================

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

-- --------------------------------------------------------
-- Structure for table `akun1s`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `akun1s`;
CREATE TABLE `akun1s` (
  `id_akun1` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `kode_akun1` varchar(6) NOT NULL,
  `nama_akun1` varchar(20) NOT NULL,
  PRIMARY KEY (`id_akun1`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `akun1s`
INSERT INTO `akun1s` VALUES
('1', '1', 'Aktiva'),
('2', '2', 'Kewajiban'),
('3', '3', 'Modal'),
('4', '4', 'Pendapatan'),
('5', '5', 'Beban');

-- --------------------------------------------------------
-- Structure for table `akun2s`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `akun2s`;
CREATE TABLE `akun2s` (
  `id_akun2` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `kode_akun2` int(6) unsigned NOT NULL,
  `nama_akun2` varchar(40) NOT NULL,
  `kode_akun1` int(6) unsigned NOT NULL,
  PRIMARY KEY (`id_akun2`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `akun2s`
INSERT INTO `akun2s` VALUES
('1', '11', 'Aktiva Lancar', '1'),
('2', '12', 'Aktiva Tetap', '1'),
('3', '21', 'Utang Jangka Pendek', '2'),
('4', '22', 'Utang Jangka Panjang', '2'),
('5', '31', 'Modal Pemilik', '3'),
('6', '32', 'Prive Pemilik', '3'),
('7', '41', 'Pendapatan Usaha', '4'),
('8', '42', 'Pendapatan Diluar Usaha', '4'),
('9', '51', 'Beban Usaha', '5'),
('10', '52', 'Beban Diluar Usaha', '5');

-- --------------------------------------------------------
-- Structure for table `akun3s`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `akun3s`;
CREATE TABLE `akun3s` (
  `id_akun3` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `kode_akun3` int(6) unsigned NOT NULL,
  `nama_akun3` varchar(70) NOT NULL,
  `kode_akun2` int(6) unsigned NOT NULL,
  `kode_akun1` int(6) unsigned NOT NULL,
  PRIMARY KEY (`id_akun3`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `akun3s`
INSERT INTO `akun3s` VALUES
('1', '1101', 'Kas', '11', '1'),
('2', '1102', 'Piutang Usaha', '11', '1'),
('3', '1103', 'Perlengkapan Kantor', '11', '1'),
('4', '1104', 'Sewa Dibayar di muka', '11', '1'),
('5', '1105', 'Asuransi dibayar di muka', '11', '1'),
('6', '1201', 'Peralatan Kantor', '12', '1'),
('7', '1202', 'Akumulasi Penyusutan P.Kantor', '12', '1'),
('8', '1203', 'Tanah', '12', '1'),
('9', '2101', 'Utang Usaha', '21', '2'),
('10', '2102', 'Utang Gaji', '21', '2'),
('11', '2103', 'Pendapatan diterima di muka', '21', '2'),
('12', '2201', 'Utang Hipotek', '22', '2'),
('13', '2202', 'Utang Obligasi', '22', '2'),
('14', '3101', 'Modal Pemilik', '31', '3'),
('15', '3201', 'Prive Tuan Najwan', '32', '3'),
('16', '4101', 'Pendapatan Jasa', '41', '4'),
('17', '4102', 'Pendapatan diterima di muka', '41', '4'),
('18', '4201', 'Pendapatan diluar Usaha', '42', '4'),
('19', '5101', 'Beban Gaji Karyawan', '51', '5'),
('20', '5102', 'Beban Iklan', '51', '5'),
('21', '5103', 'Beban Asuransi', '51', '5'),
('22', '5104', 'Beban Telepon', '51', '5'),
('23', '5105', 'Beban Listrik', '51', '5'),
('24', '5106', 'Beban Sewa', '51', '5'),
('25', '5107', 'Beban Penyusutan Peralatan Kantor', '51', '5'),
('26', '5108', 'Beban Perlengkapan Kantor', '51', '5'),
('27', '5201', 'Beban Bunga', '52', '5'),
('29', '4202', 'Pembayaran Gaji Karyawan', '42', '4');

-- --------------------------------------------------------
-- Structure for table `auth_activation_attempts`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `auth_activation_attempts`;
CREATE TABLE `auth_activation_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Structure for table `auth_groups`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `auth_groups`;
CREATE TABLE `auth_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `auth_groups`
INSERT INTO `auth_groups` VALUES
('1', 'admin', 'Administrator'),
('2', 'user', 'Regular User');

-- --------------------------------------------------------
-- Structure for table `auth_groups_permissions`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `auth_groups_permissions`;
CREATE TABLE `auth_groups_permissions` (
  `group_id` int(11) unsigned NOT NULL DEFAULT 0,
  `permission_id` int(11) unsigned NOT NULL DEFAULT 0,
  KEY `auth_groups_permissions_permission_id_foreign` (`permission_id`),
  KEY `group_id_permission_id` (`group_id`,`permission_id`),
  CONSTRAINT `auth_groups_permissions_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  CONSTRAINT `auth_groups_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Structure for table `auth_groups_users`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `auth_groups_users`;
CREATE TABLE `auth_groups_users` (
  `group_id` int(11) unsigned NOT NULL DEFAULT 0,
  `user_id` int(11) unsigned NOT NULL DEFAULT 0,
  KEY `auth_groups_users_user_id_foreign` (`user_id`),
  KEY `group_id_user_id` (`group_id`,`user_id`),
  CONSTRAINT `auth_groups_users_group_id_foreign` FOREIGN KEY (`group_id`) REFERENCES `auth_groups` (`id`) ON DELETE CASCADE,
  CONSTRAINT `auth_groups_users_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `auth_groups_users`
INSERT INTO `auth_groups_users` VALUES
('1', '1'),
('1', '3'),
('2', '2');

-- --------------------------------------------------------
-- Structure for table `auth_logins`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `auth_logins`;
CREATE TABLE `auth_logins` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL,
  `date` datetime NOT NULL,
  `success` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `email` (`email`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `auth_logins`
INSERT INTO `auth_logins` VALUES
('1', '127.0.0.1', 'admin@gmail.com', '1', '2026-09-24 11:24:53', '1');

-- --------------------------------------------------------
-- Structure for table `auth_permissions`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `auth_permissions`;
CREATE TABLE `auth_permissions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Structure for table `auth_reset_attempts`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `auth_reset_attempts`;
CREATE TABLE `auth_reset_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `token` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Structure for table `auth_tokens`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `auth_tokens`;
CREATE TABLE `auth_tokens` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `selector` varchar(255) NOT NULL,
  `hashedValidator` varchar(255) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `expires` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `auth_tokens_user_id_foreign` (`user_id`),
  KEY `selector` (`selector`),
  CONSTRAINT `auth_tokens_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Structure for table `auth_users_permissions`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `auth_users_permissions`;
CREATE TABLE `auth_users_permissions` (
  `user_id` int(11) unsigned NOT NULL DEFAULT 0,
  `permission_id` int(11) unsigned NOT NULL DEFAULT 0,
  KEY `auth_users_permissions_permission_id_foreign` (`permission_id`),
  KEY `user_id_permission_id` (`user_id`,`permission_id`),
  CONSTRAINT `auth_users_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `auth_permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `auth_users_permissions_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------
-- Structure for table `migrations`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int(11) NOT NULL,
  `batch` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `migrations`
INSERT INTO `migrations` VALUES
('1', '2026-08-30-105943', 'App\\Database\\Migrations\\CreateAkun1', 'default', 'App', '1725015583', '1'),
('2', '2026-09-16-082757', 'App\\Database\\Migrations\\CreateAkun2', 'default', 'App', '1726475277', '1'),
('3', '2026-09-19-090404', 'App\\Database\\Migrations\\CreateAkun3', 'default', 'App', '1726736644', '1'),
('4', '2026-09-19-152319', 'App\\Database\\Migrations\\CreateTransaksi', 'default', 'App', '1726759399', '2'),
('5', '2026-09-19-162146', 'App\\Database\\Migrations\\CreateNilai', 'default', 'App', '1726762906', '3'),
('6', '2026-09-20-060801', 'App\\Database\\Migrations\\CreateStatus', 'default', 'App', '1726812481', '4'),
('7', '2026-09-20-101519', 'App\\Database\\Migrations\\AddColumnsToTbNilai', 'default', 'App', '1726827319', '5'),
('8', '2017-11-20-223112', 'Myth\\Auth\\Database\\Migrations\\CreateAuthTables', 'default', 'Myth\\Auth', '1790248355', '6');

-- --------------------------------------------------------
-- Structure for table `tbl_nilai`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `tbl_nilai`;
CREATE TABLE `tbl_nilai` (
  `id_nilai` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_transaksi` int(5) unsigned DEFAULT NULL,
  `kode_akun3` varchar(20) DEFAULT NULL,
  `debet` int(11) DEFAULT 0,
  `debit` float DEFAULT 0,
  `kredit` int(11) DEFAULT 0,
  `id_status` int(5) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_nilai`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `tbl_nilai`
INSERT INTO `tbl_nilai` VALUES
('46', '23', '1101', '30000000', '30000000', '0', '3', NULL, NULL, NULL),
('47', '23', '1103', '3000000', '3000000', '0', '5', NULL, NULL, NULL),
('48', '23', '1201', '35000000', '35000000', '0', '5', NULL, NULL, NULL),
('49', '23', '3101', '0', '0', '68000000', '5', NULL, NULL, NULL),
('50', '24', '1104', '15000000', '15000000', '0', '5', NULL, NULL, NULL),
('51', '24', '1101', '0', '0', '15000000', '2', NULL, NULL, NULL),
('52', '25', '1201', '5000000', '5000000', '0', '5', NULL, NULL, NULL),
('53', '25', '2101', '0', '0', '5000000', '5', NULL, NULL, NULL),
('54', '26', '1101', '2000000', '2000000', '0', '1', NULL, NULL, NULL),
('55', '26', '2103', '0', '0', '2000000', '5', NULL, NULL, NULL),
('56', '27', '1105', '4200000', '4200000', '0', '5', NULL, NULL, NULL),
('57', '27', '1101', '0', '0', '4200000', '2', NULL, NULL, NULL),
('58', '28', '5102', '300000', '300000', '0', '5', NULL, NULL, NULL),
('59', '28', '1101', '0', '0', '300000', '2', NULL, NULL, NULL),
('60', '29', '2101', '2500000', '2500000', '0', '5', NULL, NULL, NULL),
('61', '29', '1101', '0', '0', '2500000', '2', NULL, NULL, NULL),
('62', '30', '1102', '5800000', '5800000', '0', '5', NULL, NULL, NULL),
('63', '30', '4101', '0', '0', '5800000', '5', NULL, NULL, NULL),
('64', '31', '4202', '1250000', '1250000', '0', '5', NULL, NULL, NULL),
('65', '31', '1101', '0', '0', '1250000', '2', NULL, NULL, NULL),
('66', '32', '1101', '5800000', '5800000', '0', '1', NULL, NULL, NULL),
('67', '32', '1102', '0', '0', '5800000', '5', NULL, NULL, NULL),
('68', '33', '1102', '19400000', '19400000', '0', '5', NULL, NULL, NULL),
('69', '33', '4101', '0', '0', '19400000', '5', NULL, NULL, NULL),
('70', '34', '1103', '1200000', '1200000', '0', '5', NULL, NULL, NULL),
('71', '34', '1101', '0', '0', '1200000', '2', NULL, NULL, NULL),
('72', '35', '5104', '350000', '350000', '0', '5', NULL, NULL, NULL),
('73', '35', '1101', '0', '0', '350000', '2', NULL, NULL, NULL),
('74', '36', '5105', '170000', '170000', '0', '5', NULL, NULL, NULL),
('75', '36', '1101', '0', '0', '170000', '2', NULL, NULL, NULL),
('76', '37', '1101', '8000000', '8000000', '0', '1', NULL, NULL, NULL),
('77', '37', '1102', '0', '0', '8000000', '5', NULL, NULL, NULL),
('78', '38', '5101', '1250000', '1250000', '0', '5', NULL, NULL, NULL),
('79', '38', '1101', '0', '0', '1250000', '2', NULL, NULL, NULL),
('80', '39', '1101', '11400000', '11400000', '0', '1', NULL, NULL, NULL),
('81', '39', '1102', '0', '0', '11400000', '5', NULL, NULL, NULL),
('82', '40', '1102', '3000000', '3000000', '0', '5', NULL, NULL, NULL),
('83', '40', '4101', '0', '0', '3000000', '5', NULL, NULL, NULL),
('84', '41', '3201', '1200000', '1200000', '0', '5', NULL, NULL, NULL),
('85', '41', '1101', '0', '0', '1200000', '2', NULL, NULL, NULL),
('86', '42', '5106', '2500000', '2500000', '0', '5', NULL, NULL, NULL),
('87', '42', '1104', '0', '0', '2500000', '5', NULL, NULL, NULL),
('88', '43', '5103', '350000', '350000', '0', '5', NULL, NULL, NULL),
('89', '43', '1105', '0', '0', '350000', '5', NULL, NULL, NULL),
('90', '44', '5107', '600000', '600000', '0', '5', NULL, NULL, NULL),
('91', '44', '1202', '0', '0', '600000', '5', NULL, NULL, NULL),
('92', '45', '5108', '1000000', '1000000', '0', '5', NULL, NULL, NULL),
('93', '45', '1103', '0', '0', '1000000', '5', NULL, NULL, NULL),
('94', '46', '1102', '2500000', '2500000', '0', '5', NULL, NULL, NULL),
('95', '46', '4101', '0', '0', '2500000', '5', NULL, NULL, NULL);

-- --------------------------------------------------------
-- Structure for table `tbl_status`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `tbl_status`;
CREATE TABLE `tbl_status` (
  `id_status` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `status` varchar(50) NOT NULL,
  PRIMARY KEY (`id_status`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `tbl_status`
INSERT INTO `tbl_status` VALUES
('1', 'Penerimaan'),
('2', 'Pengeluaran'),
('3', 'Investasi Masuk'),
('4', 'Investasi Keluar'),
('5', 'Normal');

-- --------------------------------------------------------
-- Structure for table `tbl_transaksi`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `tbl_transaksi`;
CREATE TABLE `tbl_transaksi` (
  `id_transaksi` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `kwitansi` varchar(4) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `deskripsi` text NOT NULL,
  `ketjurnal` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id_transaksi`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `tbl_transaksi`
INSERT INTO `tbl_transaksi` VALUES
('23', '0001', '2025-12-01', 'Tanggal 1 Desember: Tuan Najwan menyetorkan modal  berupa uang tunai sebesar Rp30.000.000, perlengkapan kantor Rp3.000.000, dan peralatan kantor Rp35.000.000', 'Setoran Modal Pemilik', NULL, NULL, NULL),
('24', '0002', '2025-12-02', 'Tanggal 2 Desember: membayar sewa gedung untuk 6 bulan sebesar Rp 15.000.000', 'Pembayaran Sewa gedung untuk 6 bulan', NULL, NULL, NULL),
('25', '0003', '2025-12-03', 'Tanggal 3 Desember: Membeli peralatan kantor secara kredit dari Toko Sempurna sebesar Rp 5.000.000', 'Membeli peralatan kantor secara kredit ', NULL, NULL, NULL),
('26', '0004', '2025-12-03', 'Tanggal 3 Desember: Menerima uang tunai dari klien sebagai uang muka jasa yang akan diberikan oleh Perusahaan AKN-IPB sebesar Rp 2.000.000', 'Pendapatan diterima dimuka dari Perusahaan AKN-IPB', NULL, NULL, NULL),
('27', '0005', '2025-12-05', 'Tanggal 5 Desember: Membayar premi asuransi untuk kekayaan dan kecelakaan untuk 1 tahun sebesar Rp 4.200.000', 'Membayar premi asuransi untuk 1 tahun', NULL, NULL, NULL),
('28', '0006', '2025-12-07', 'Tanggal 7 Desember: Membayar iklan untuk sebuah surat kabar Radar Bogor sebesar Rp 300.000', 'Membayar iklan Radar Bogor', NULL, NULL, NULL),
('29', '0007', '2025-12-08', 'Tanggal 8 Desember: Membayar utang kepada Toko Makmur sebesar Rp 2.500.000', 'Membayar utang kepada Toko Makmur', NULL, NULL, NULL),
('30', '0008', '2025-12-10', 'Tanggal 10 Desember: Dilakukan jasa konsultasi untuk klien yang pembayaran jasanya akan dilakukan kemudian sebesar Rp 5.800.000', 'Piutang Jasa konsultasi', NULL, NULL, NULL),
('31', '0009', '2025-12-15', 'Tanggal 15 Desember: Membayar gaji resepsionis untuk setengah bulan pertama sebesar Rp 1.250.000', 'Membayar gaji resepsionis untuk setengah bulan', NULL, NULL, NULL),
('32', '0010', '2025-12-16', 'Tanggal 16 Desember: Menerima pembayaran dari klien atas jasa yang telah diberikan pada 10 Desember sebesar Rp 5.800.000', 'Pembayaran atas Piutang Tanggal 10 Desember', NULL, NULL, NULL),
('33', '0011', '2025-12-17', 'Tanggal 17 Desember: Dilakukan jasa konsultasi untuk klien yang pembayaran jasanya akan dilakukan kemudian sebesar Rp 19.400.000 (piutang jasa)', 'Piutang Jasa konsultasi', NULL, NULL, NULL),
('34', '0012', '2025-12-19', 'Tanggal 19 Desember: membeli perlengkapan kantor secara tunai sebesar Rp 1.200.000', 'membeli perlengkapan kantor', NULL, NULL, NULL),
('35', '0013', '2025-12-20', 'Tanggal 20 Desember: membayar rekening telepon bulan Desember sebesar Rp 350.000', 'membayar rekening telepon (beban telepon)', NULL, NULL, NULL),
('36', '0014', '2025-12-20', 'Tanggal 20 Desember: membayar rekening listrik bulan Desember sebesar Rp 170.000', 'membayar rekening listrik (beban listrik)', NULL, NULL, NULL),
('37', '0015', '2025-12-24', 'Tanggal 24 Desember: mencatat penerimaan kas dari klien atas tagihan jasa yang telah diberikan pada 17 Des sebesar Rp 8.000.000', 'Pembayaran piutang usaha tgl 17', NULL, NULL, NULL),
('38', '0016', '2025-12-30', 'Tanggal 30 Desember: membayar gaji resepsionis setengah bulan kedua sebesar Rp 1.250.000', 'Beban Gaji karyawan', NULL, NULL, NULL),
('39', '0017', '2025-12-30', 'Tanggal 30 Desember: mencatat penerimaan kas dari klien atas tagihan jasa yang telah diberikan 17 Desember sebesar Rp 11.400.000', 'Pembayaran piutang jasa', NULL, NULL, NULL),
('40', '0018', '2025-12-30', 'Tanggal 30 Desember: dilakukan jasa konsultasi untuk klien yang pembayaran jasanya akan dilakukan kemudian sebesar Rp 3.000.000 ', 'Piutang Jasa', NULL, NULL, NULL),
('41', '0019', '2025-12-30', 'Tanggal 30 Desember: Tuan Najwan mengambil uang kas dari perusahaan untuk keperluan pribadi sebesar Rp 1.200.000', 'Prive Tuan Najwan', NULL, NULL, NULL),
('42', '0020', '2025-12-31', 'Sewa gedung selama 6 bulan dibayar 2 Desember 2025 sebesar Rp 15.000.000', 'Penyesuaian', NULL, NULL, NULL),
('43', '0021', '2025-12-31', 'Asuransi untuk 1 tahun dibayar 5 Desember 2025 sebesar Rp 4.200.000', 'Penyesuaian', NULL, NULL, NULL),
('44', '0022', '2025-12-31', 'Peralatan kantor disusutkan sebesar Rp 7.200.000 setahun (per bulan Rp 600.000)', 'Penyesuaian', NULL, NULL, NULL),
('45', '0023', '2025-12-31', 'Perlengkapan yang masih tersisa sebesar Rp 3.200.000  (penyesuaian Rp 1.000.000)', 'Penyesuaian', NULL, NULL, NULL),
('46', '0024', '2025-12-31', 'Pendapatan jasa yang telah selesai dikerjakan tetapi pembayarannya akan dilakukan tanggal 7 Januari 2026 sebesar Rp 2.500.000', 'Penyesuaian', NULL, NULL, NULL);

-- --------------------------------------------------------
-- Structure for table `users`
-- --------------------------------------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `reset_hash` varchar(255) DEFAULT NULL,
  `reset_at` datetime DEFAULT NULL,
  `reset_expires` datetime DEFAULT NULL,
  `activate_hash` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `status_message` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 0,
  `force_pass_reset` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table `users`
INSERT INTO `users` VALUES
('1', 'admin@gmail.com', 'admin', '$2y$10$OEjmBuiqgZrFB4zEgHtlE.39TAZwBr2k3khRwt7yZqv0shV3gg8Di', NULL, NULL, NULL, NULL, NULL, NULL, '1', '0', '2026-09-24 18:20:32', '2026-09-24 18:20:32', NULL),
('2', 'user@gmail.com', 'user', '$2y$10$OfZAh6CWyJryRSk7ScqEweyowFmqoRsVk/Thg7j97aLOueU9Cq7u.', NULL, NULL, NULL, NULL, NULL, NULL, '1', '0', '2026-09-24 18:20:32', '2026-09-24 18:20:32', NULL),
('3', 'beyaaa@gmail.com', 'beyaaa', '$2y$10$FWH.ezuTpW6q79j00ztpm.V1G06vnxHdXlJBgy6W4Dpx8YJvKqD.u', NULL, NULL, NULL, NULL, NULL, NULL, '1', '0', '2026-09-24 18:20:32', '2026-09-24 18:20:32', NULL);

SET FOREIGN_KEY_CHECKS=1;
