-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 26, 2024 at 10:49 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_cleaning_service`
--

-- --------------------------------------------------------

--
-- Table structure for table `absensi`
--

CREATE TABLE `absensi` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `filename` varchar(100) NOT NULL,
  `absen_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `absensi`
--

INSERT INTO `absensi` (`id`, `user_id`, `filename`, `absen_at`) VALUES
(12, 1, 'uploads/6682138a35ec4.png', '2024-07-01 09:25:14'),
(38, 1, '../uploads/6684bf4b633f6.jpeg', '2024-07-03 10:02:35'),
(39, 1, '../uploads/6684bf50d56c0.jpeg', '2024-07-03 10:02:40'),
(40, 1, '../uploads/6684c29eb3c8a.jpeg', '2024-07-03 10:16:46'),
(41, 1, '../uploads/6684d9a86bfd3.jpeg', '2024-07-03 11:55:04'),
(42, 1, '../uploads/6684d9b7384d6.jpeg', '2024-07-03 11:55:19'),
(43, 1, '../uploads/6684e77835127.jpeg', '2024-07-03 12:54:00'),
(44, 1, '../uploads/6686716dcb27d.jpg', '2024-07-04 16:54:53'),
(45, 1, '../uploads/668671e158b36.jpg', '2024-07-04 16:56:49'),
(46, 1, '../uploads/668671e91cddc.jpg', '2024-07-04 16:56:57'),
(49, 1, 'uploads/668754ef54499.png', '2024-07-05 09:05:35'),
(50, 3, '../uploads/absensi/66a1c164e87e3.jpg', '2024-07-25 10:07:16');

-- --------------------------------------------------------

--
-- Table structure for table `image_tugas_harian`
--

CREATE TABLE `image_tugas_harian` (
  `id` int(11) NOT NULL,
  `tugas_id` int(11) DEFAULT NULL,
  `filename` varchar(100) DEFAULT NULL,
  `status` tinyint(1) DEFAULT NULL COMMENT '0 = sebelum,\r\n1 = sesudah,\r\n2 = komplain',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `submitted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `image_tugas_harian`
--

INSERT INTO `image_tugas_harian` (`id`, `tugas_id`, `filename`, `status`, `created_at`, `submitted_by`) VALUES
(1, 1, 'uploads/6667ca6428303.png', 0, '2024-06-11 10:54:12', 0),
(2, 3, 'uploads/6667ca7278a2d.png', 0, '2024-06-11 10:54:26', 0),
(3, 3, 'uploads/6667ca8e7ab17.png', 1, '2024-06-11 10:54:54', 0),
(5, 1, 'uploads/666a9bf9076c2.png', 1, '2024-06-13 14:12:57', 0),
(7, 4, 'uploads/667e30cff2df8.png', 0, '2024-06-28 10:41:04', 0),
(8, 9, 'uploads/668213940f15e.png', 0, '2024-07-01 09:25:24', 0),
(9, 9, 'uploads/668213b579339.png', 1, '2024-07-01 09:25:57', 0),
(10, 1, '../uploads/tugasHarian/66a1c250df8d3.jpg', 0, '2024-07-25 10:11:12', 3),
(11, 1, '../uploads/tugasHarian/66a1c266a21ea.jpg', 1, '2024-07-25 10:11:34', 3),
(12, 2, '../uploads/tugasHarian/66a1c5bf2ee8d.jpg', 0, '2024-07-25 10:25:51', 3),
(13, 2, '../uploads/tugasHarian/66a1cceb1a29f.jpg', 1, '2024-07-25 10:56:27', 3),
(14, 9, '../uploads/tugasHarian/66a1d2dc96ff4.jpg', 0, '2024-07-25 11:21:48', 3);

-- --------------------------------------------------------

--
-- Table structure for table `komplain`
--

CREATE TABLE `komplain` (
  `id` int(11) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `tugas_id` int(11) NOT NULL,
  `filename` varchar(100) NOT NULL,
  `followup` varchar(100) NOT NULL DEFAULT '-',
  `status` tinyint(1) NOT NULL COMMENT '0 = bersih,\r\n1 = kurang bersih,\r\n2 = kotor',
  `catatan` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE `lokasi` (
  `id` int(11) NOT NULL,
  `lokasi` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`id`, `lokasi`) VALUES
(1, 'Melawai 10 Lt.2'),
(2, 'Melawai 10 Lt.3');

-- --------------------------------------------------------

--
-- Table structure for table `tugas_harian`
--

CREATE TABLE `tugas_harian` (
  `id` int(11) NOT NULL,
  `lokasi` int(11) NOT NULL,
  `details` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tugas_harian`
--

INSERT INTO `tugas_harian` (`id`, `lokasi`, `details`, `status`) VALUES
(1, 2, 'Lantai sudah di pel dengan bersih', 1),
(2, 2, 'Semua Air Minum karyawan sudah terisi', 1),
(3, 2, 'Jendela sudah di lap', 0),
(4, 2, 'Semua tempat sampah dibuang', 0),
(5, 1, 'Pel Lantai', 1),
(6, 1, 'Isi dispenser', 1),
(7, 1, 'Sapu lantai', 1),
(8, 1, 'Lap jendela', 1),
(9, 2, 'Bersihin meja', 1),
(10, 2, 'bersihin toilet', 1),
(11, 2, 'Tugas Baruuuuu lt3', 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama` text NOT NULL,
  `nik` varchar(60) NOT NULL,
  `jabatan` text NOT NULL,
  `status` tinyint(1) NOT NULL COMMENT '0 = tidak aktif, 1 = aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama`, `nik`, `jabatan`, `status`) VALUES
(1, 'petugas1', 'pass1', 'Fathan Petugas', '123456489', 'Cleaning Service', 0),
(2, 'petugas2', 'pass2', 'Petugas Dua', '23465789', 'Cleaning Service', 0),
(3, 'admin1', 'admin1', 'Admin Satu', '987678912', 'Admin', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absensi`
--
ALTER TABLE `absensi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `image_tugas_harian`
--
ALTER TABLE `image_tugas_harian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tugas_id` (`tugas_id`);

--
-- Indexes for table `komplain`
--
ALTER TABLE `komplain`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tugas_harian`
--
ALTER TABLE `tugas_harian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_tugasharian_lokasiid` (`lokasi`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `nik` (`nik`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `absensi`
--
ALTER TABLE `absensi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `image_tugas_harian`
--
ALTER TABLE `image_tugas_harian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `komplain`
--
ALTER TABLE `komplain`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tugas_harian`
--
ALTER TABLE `tugas_harian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absensi`
--
ALTER TABLE `absensi`
  ADD CONSTRAINT `absensi_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `image_tugas_harian`
--
ALTER TABLE `image_tugas_harian`
  ADD CONSTRAINT `image_tugas_harian_ibfk_1` FOREIGN KEY (`tugas_id`) REFERENCES `tugas_harian` (`id`);

--
-- Constraints for table `tugas_harian`
--
ALTER TABLE `tugas_harian`
  ADD CONSTRAINT `FK_tugasharian_lokasiid` FOREIGN KEY (`lokasi`) REFERENCES `lokasi` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
