-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2017 at 11:26 AM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_operasional-kantor`
--

-- --------------------------------------------------------

--
-- Table structure for table `jabatan_anggota`
--

CREATE TABLE `jabatan_anggota` (
  `id_anggota` varchar(5) NOT NULL,
  `id_jabatan` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_absen`
--

CREATE TABLE `tb_absen` (
  `status_id` int(11) NOT NULL,
  `status` varchar(30) NOT NULL,
  `warna` varchar(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_absen`
--

INSERT INTO `tb_absen` (`status_id`, `status`, `warna`) VALUES
(1, 'Hadir', '#00c0ef'),
(2, 'Hadir Diluar', '#0073b7'),
(3, 'Sakit', '#f56954'),
(4, 'Izin', '#f39c12'),
(5, 'Cuti', '#00a65a'),
(6, 'Alpha', '#c0c0c0'),
(7, 'Kerja Remote', '#c0c0c0');

-- --------------------------------------------------------

--
-- Table structure for table `tb_anggota`
--

CREATE TABLE `tb_anggota` (
  `id_anggota` varchar(15) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `alamat` varchar(200) NOT NULL,
  `tempat_lahir` varchar(100) NOT NULL,
  `tgl_lahir` date NOT NULL,
  `jenis_kelamin` varchar(1) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto_profile` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_buktipembayaran`
--

CREATE TABLE `tb_buktipembayaran` (
  `id` int(11) NOT NULL,
  `id_pembayaran` varchar(5) NOT NULL,
  `bukti` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_credits_anggota`
--

CREATE TABLE `tb_credits_anggota` (
  `id` int(4) NOT NULL,
  `id_anggota` varchar(15) NOT NULL,
  `topup_credit` bigint(10) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_cronjob_rencana_absen`
--

CREATE TABLE `tb_cronjob_rencana_absen` (
  `id` int(11) NOT NULL,
  `id_anggota` varchar(15) NOT NULL,
  `status_id` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `tglawal` date NOT NULL,
  `tglakhir` date NOT NULL,
  `foto_lokasi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_cuti_anggota`
--

CREATE TABLE `tb_cuti_anggota` (
  `id_cuti` int(11) NOT NULL,
  `id_anggota` varchar(15) NOT NULL,
  `cuti_used` int(4) NOT NULL DEFAULT '0',
  `cuti_qty` int(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_detail_absen`
--

CREATE TABLE `tb_detail_absen` (
  `id` int(11) NOT NULL,
  `id_anggota` varchar(15) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time NOT NULL,
  `status_id` int(2) NOT NULL,
  `keterangan` varchar(255) DEFAULT '',
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `tgl_awal` date DEFAULT NULL,
  `tgl_akhir` date DEFAULT NULL,
  `foto_lokasi` varchar(255) DEFAULT NULL,
  `rencana_id` int(11) DEFAULT NULL,
  `credit_id` int(11) DEFAULT NULL,
  `credit_in` bigint(20) DEFAULT NULL,
  `credit_stat` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_jabatan`
--

CREATE TABLE `tb_jabatan` (
  `id_jabatan` varchar(3) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `gaji` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_jenistransaksi`
--

CREATE TABLE `tb_jenistransaksi` (
  `id_jenis` varchar(6) NOT NULL,
  `jenis` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_jenistransaksi`
--

INSERT INTO `tb_jenistransaksi` (`id_jenis`, `jenis`) VALUES
('TR-01', 'Bayar Listrik'),
('TR-02', 'Bayar Air Minum'),
('TR-03', 'Bayar Sampah'),
('TR-04', 'Bayar ART'),
('TR-05', 'Bayar Transport'),
('TR-06', 'Bayar Konsumsi');

-- --------------------------------------------------------

--
-- Table structure for table `tb_konfigurasi_kakatu`
--

CREATE TABLE `tb_konfigurasi_kakatu` (
  `id` int(11) NOT NULL,
  `email_admin` varchar(255) NOT NULL,
  `pass_email` varchar(255) NOT NULL,
  `secret_key` varchar(255) NOT NULL,
  `secret_iv` varchar(255) NOT NULL,
  `api_key_google` varchar(255) NOT NULL,
  `tanggal_set` date NOT NULL,
  `jam_set` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_konfirmasi`
--

CREATE TABLE `tb_konfirmasi` (
  `id_pembayaran` varchar(5) NOT NULL,
  `id_anggota` varchar(5) NOT NULL,
  `konfirm_anggota` varchar(1) NOT NULL,
  `konfirm_admin` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pembayaran`
--

CREATE TABLE `tb_pembayaran` (
  `id_pembayaran` varchar(5) NOT NULL,
  `id_anggota` varchar(5) NOT NULL,
  `tanggal` datetime NOT NULL,
  `id_jenis` varchar(5) NOT NULL,
  `nominal` varchar(9) NOT NULL,
  `keterangan` varchar(1000) NOT NULL,
  `status` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tb_tgllibur`
--

CREATE TABLE `tb_tgllibur` (
  `id` int(4) NOT NULL,
  `nama_libur` varchar(50) NOT NULL,
  `tglawal` date DEFAULT NULL,
  `tglakhir` date DEFAULT NULL,
  `jmlhari` mediumint(8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `jabatan_anggota`
--
ALTER TABLE `jabatan_anggota`
  ADD KEY `id_anggota` (`id_anggota`),
  ADD KEY `id_jabatan` (`id_jabatan`);

--
-- Indexes for table `tb_absen`
--
ALTER TABLE `tb_absen`
  ADD PRIMARY KEY (`status_id`);

--
-- Indexes for table `tb_anggota`
--
ALTER TABLE `tb_anggota`
  ADD PRIMARY KEY (`id_anggota`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tb_buktipembayaran`
--
ALTER TABLE `tb_buktipembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pembayaran` (`id_pembayaran`);

--
-- Indexes for table `tb_credits_anggota`
--
ALTER TABLE `tb_credits_anggota`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_anggota` (`id_anggota`);

--
-- Indexes for table `tb_cronjob_rencana_absen`
--
ALTER TABLE `tb_cronjob_rencana_absen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_anggota` (`id_anggota`),
  ADD KEY `status_id` (`status_id`);

--
-- Indexes for table `tb_cuti_anggota`
--
ALTER TABLE `tb_cuti_anggota`
  ADD PRIMARY KEY (`id_cuti`),
  ADD UNIQUE KEY `id_anggota` (`id_anggota`);

--
-- Indexes for table `tb_detail_absen`
--
ALTER TABLE `tb_detail_absen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_idanggota` (`id_anggota`),
  ADD KEY `status_id` (`status_id`),
  ADD KEY `rencana_id` (`rencana_id`),
  ADD KEY `credit_id` (`credit_id`);

--
-- Indexes for table `tb_jabatan`
--
ALTER TABLE `tb_jabatan`
  ADD PRIMARY KEY (`id_jabatan`);

--
-- Indexes for table `tb_jenistransaksi`
--
ALTER TABLE `tb_jenistransaksi`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indexes for table `tb_konfigurasi_kakatu`
--
ALTER TABLE `tb_konfigurasi_kakatu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_konfirmasi`
--
ALTER TABLE `tb_konfirmasi`
  ADD KEY `fk_idbayar` (`id_pembayaran`);

--
-- Indexes for table `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_anggota` (`id_anggota`),
  ADD KEY `id_jenis` (`id_jenis`);

--
-- Indexes for table `tb_tgllibur`
--
ALTER TABLE `tb_tgllibur`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_absen`
--
ALTER TABLE `tb_absen`
  MODIFY `status_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tb_buktipembayaran`
--
ALTER TABLE `tb_buktipembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_credits_anggota`
--
ALTER TABLE `tb_credits_anggota`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `tb_cronjob_rencana_absen`
--
ALTER TABLE `tb_cronjob_rencana_absen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_cuti_anggota`
--
ALTER TABLE `tb_cuti_anggota`
  MODIFY `id_cuti` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tb_detail_absen`
--
ALTER TABLE `tb_detail_absen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_konfigurasi_kakatu`
--
ALTER TABLE `tb_konfigurasi_kakatu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tb_tgllibur`
--
ALTER TABLE `tb_tgllibur`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jabatan_anggota`
--
ALTER TABLE `jabatan_anggota`
  ADD CONSTRAINT `fk_id-anggota` FOREIGN KEY (`id_anggota`) REFERENCES `tb_anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_id-jabatan` FOREIGN KEY (`id_jabatan`) REFERENCES `tb_jabatan` (`id_jabatan`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_buktipembayaran`
--
ALTER TABLE `tb_buktipembayaran`
  ADD CONSTRAINT `fk_idpembayaran` FOREIGN KEY (`id_pembayaran`) REFERENCES `tb_pembayaran` (`id_pembayaran`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_credits_anggota`
--
ALTER TABLE `tb_credits_anggota`
  ADD CONSTRAINT `tb_credits_anggota_ibfk_1` FOREIGN KEY (`id_anggota`) REFERENCES `tb_anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_cronjob_rencana_absen`
--
ALTER TABLE `tb_cronjob_rencana_absen`
  ADD CONSTRAINT `tb_cronjob_rencana_absen_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `tb_absen` (`status_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_cronjob_rencana_absen_ibfk_2` FOREIGN KEY (`id_anggota`) REFERENCES `tb_anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_cuti_anggota`
--
ALTER TABLE `tb_cuti_anggota`
  ADD CONSTRAINT `tb_cuti_anggota_ibfk_1` FOREIGN KEY (`id_anggota`) REFERENCES `tb_anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_detail_absen`
--
ALTER TABLE `tb_detail_absen`
  ADD CONSTRAINT `ibfk_idanggota3` FOREIGN KEY (`id_anggota`) REFERENCES `tb_anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_detail_absen_ibfk_1` FOREIGN KEY (`status_id`) REFERENCES `tb_absen` (`status_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_detail_absen_ibfk_2` FOREIGN KEY (`rencana_id`) REFERENCES `tb_cronjob_rencana_absen` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_detail_absen_ibfk_3` FOREIGN KEY (`credit_id`) REFERENCES `tb_credits_anggota` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_konfirmasi`
--
ALTER TABLE `tb_konfirmasi`
  ADD CONSTRAINT `ibfk_idbayar` FOREIGN KEY (`id_pembayaran`) REFERENCES `tb_pembayaran` (`id_pembayaran`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_pembayaran`
--
ALTER TABLE `tb_pembayaran`
  ADD CONSTRAINT `fk_idanggota` FOREIGN KEY (`id_anggota`) REFERENCES `tb_anggota` (`id_anggota`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_idjenis` FOREIGN KEY (`id_jenis`) REFERENCES `tb_jenistransaksi` (`id_jenis`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
