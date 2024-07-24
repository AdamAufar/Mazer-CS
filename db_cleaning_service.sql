-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 24, 2024 at 08:16 PM
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
(36, 1, '../uploads/absensi/6695e193af295.jpg', '2024-07-16 09:57:23'),
(37, 1, '../uploads/absensi/669d3612da262.jpg', '2024-07-21 23:23:46');

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
(1, 1, '../uploads/tugasHarian/6667ca6428303.png', 0, '2024-06-11 10:54:12', 0),
(2, 3, '../uploads/tugasHarian/6667ca7278a2d.png', 0, '2024-06-11 10:54:26', 0),
(3, 3, '../uploads/tugasHarian/6667ca8e7ab17.png', 1, '2024-06-11 10:54:54', 0),
(5, 1, '../uploads/tugasHarian/666a9bf9076c2.png', 1, '2024-06-13 14:12:57', 0),
(6, 2, '../uploads/tugasHarian/666bf4deb3c35.png', 0, '2024-06-14 14:44:30', 0),
(8, 4, '../uploads/tugasHarian/6695330b3f19b.jpg', 0, '2024-07-15 21:32:43', 0),
(9, 4, '../uploads/tugasHarian/669539bc9ed9d.jpg', 1, '2024-07-15 22:01:16', 0),
(10, 1, '../uploads/tugasHarian/66a144698873f.jpg', 0, '2024-07-25 01:14:01', 3);

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
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `followup_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `komplain`
--

INSERT INTO `komplain` (`id`, `nama`, `tugas_id`, `filename`, `followup`, `status`, `catatan`, `created_at`, `followup_at`) VALUES
(3, 'doni', 3, '../uploads/komplain/666a9c1554247.png', '../uploads/komplain/666a9c1554247.png', 0, 'jendela kotor', '2024-06-13 14:10:23', '2024-07-16 11:05:07'),
(4, 'koni', 3, '../uploads/komplain/666a9c1554247.png', '../uploads/komplain/6695ef04f2720.jpg', 0, 'jendela kotor', '2024-06-13 14:12:13', '2024-07-16 11:05:07'),
(5, 'loni', 1, '../uploads/komplain/666a9c1554247.png', '../uploads/komplain/666a9c1554247.png', 0, 'lantai masih kotor', '2024-06-13 14:13:25', '2024-07-16 11:05:07'),
(6, 'honi', 1, '../uploads/komplain/666a9c1554247.png', '../uploads/komplain/6695e51e014ec.jpg', 0, 'aaaaaaaaaaaaaaaaaaa', '2024-06-14 09:49:23', '2024-07-16 11:05:07'),
(7, 'biibkbk', 1, '../uploads/komplain/666a9c1554247.png', '../uploads/komplain/666a9c1554247.png', 0, 'fvygbhni', '2024-06-14 14:45:38', '2024-07-16 11:05:07'),
(8, 'bonin', 3, '../uploads/komplain/666a9c1554247.png', '-', 1, 'debu', '2024-06-19 13:08:48', '2024-07-16 11:05:07');

-- --------------------------------------------------------

--
-- Table structure for table `tugas_harian`
--

CREATE TABLE `tugas_harian` (
  `id` int(11) NOT NULL,
  `lokasi` varchar(100) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '0 = not active\r\n1 = active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tugas_harian`
--

INSERT INTO `tugas_harian` (`id`, `lokasi`, `details`, `status`) VALUES
(1, 'Melawai 10 Lt.3', 'Lantai sudah di pel dengan bersih', 1),
(2, 'Melawai 10 Lt.3', 'Semua Air Minum karyawan sudah terisi', 1),
(3, 'Melawai 10 Lt.3', 'Jendela sudah di lap', 1),
(4, 'Melawai 10 Lt.3', 'Semua tempat sampah dibuang', 0),
(5, 'Melawai 10 Lt.2', 'Pel Lantai', 1),
(6, 'Melawai 10 Lt.2', 'Isi dispenser', 1),
(7, 'Melawai 10 Lt.2', 'Sapu lantai', 1),
(8, 'Melawai 10 Lt.2', 'Lap jendela', 1),
(9, 'Melawai 10 Lt.3', 'Bersihin meja', 1),
(10, 'Melawai 10 Lt.3', 'asdasdasdasd', 0);

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
(1, 'petugas1', 'pass1', 'Petugas', '123456489', 'Cleaning Service', 0),
(2, 'petugas2', 'pass2', 'Petugas Dua', '23465789', 'Cleaning Service', 1),
(3, 'admin1', 'admin1', 'Admin Satu', '98767123', 'Admin', 1);

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
-- Indexes for table `tugas_harian`
--
ALTER TABLE `tugas_harian`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `image_tugas_harian`
--
ALTER TABLE `image_tugas_harian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `komplain`
--
ALTER TABLE `komplain`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tugas_harian`
--
ALTER TABLE `tugas_harian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
