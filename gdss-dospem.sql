-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 24, 2025 at 08:15 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 5.6.40

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gdss-dospem`
--

-- --------------------------------------------------------

--
-- Table structure for table `alternatif`
--

CREATE TABLE `alternatif` (
  `id_alt` char(5) NOT NULL,
  `nama_alt` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `bobot_borda`
--

CREATE TABLE `bobot_borda` (
  `ranking` int(11) NOT NULL,
  `bobot_borda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `decision_maker`
--

CREATE TABLE `decision_maker` (
  `id_dm` char(5) NOT NULL,
  `nama_dm` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hasil_borda`
--

CREATE TABLE `hasil_borda` (
  `id_alt` char(5) NOT NULL,
  `total_poin` decimal(10,6) NOT NULL,
  `nilai_borda` decimal(10,6) NOT NULL,
  `ranking_borda` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hasil_wp_dm`
--

CREATE TABLE `hasil_wp_dm` (
  `id_dm` char(5) NOT NULL,
  `id_alt` char(5) NOT NULL,
  `skor_wp` decimal(10,6) NOT NULL,
  `ranking_wp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kriteria`
--

CREATE TABLE `kriteria` (
  `id_kriteria` char(5) NOT NULL,
  `nama_kriteria` varchar(200) NOT NULL,
  `sifat` enum('benefit','cost') NOT NULL,
  `bobot` decimal(10,4) NOT NULL,
  `bobot_normalisasi` decimal(10,6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `penilaian`
--

CREATE TABLE `penilaian` (
  `id_penilaian` bigint(20) NOT NULL,
  `id_dm` char(5) NOT NULL,
  `id_alt` char(5) NOT NULL,
  `id_kriteria` char(5) NOT NULL,
  `nilai_awal` decimal(10,4) NOT NULL,
  `nilai_terbobot` decimal(10,6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alternatif`
--
ALTER TABLE `alternatif`
  ADD PRIMARY KEY (`id_alt`);

--
-- Indexes for table `bobot_borda`
--
ALTER TABLE `bobot_borda`
  ADD PRIMARY KEY (`ranking`);

--
-- Indexes for table `decision_maker`
--
ALTER TABLE `decision_maker`
  ADD PRIMARY KEY (`id_dm`);

--
-- Indexes for table `hasil_borda`
--
ALTER TABLE `hasil_borda`
  ADD PRIMARY KEY (`id_alt`);

--
-- Indexes for table `hasil_wp_dm`
--
ALTER TABLE `hasil_wp_dm`
  ADD PRIMARY KEY (`id_dm`,`id_alt`),
  ADD KEY `id_alt` (`id_alt`);

--
-- Indexes for table `kriteria`
--
ALTER TABLE `kriteria`
  ADD PRIMARY KEY (`id_kriteria`);

--
-- Indexes for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD PRIMARY KEY (`id_penilaian`),
  ADD KEY `id_dm` (`id_dm`),
  ADD KEY `id_alt` (`id_alt`),
  ADD KEY `id_kriteria` (`id_kriteria`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `penilaian`
--
ALTER TABLE `penilaian`
  MODIFY `id_penilaian` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hasil_borda`
--
ALTER TABLE `hasil_borda`
  ADD CONSTRAINT `hasil_borda_ibfk_1` FOREIGN KEY (`id_alt`) REFERENCES `alternatif` (`id_alt`);

--
-- Constraints for table `hasil_wp_dm`
--
ALTER TABLE `hasil_wp_dm`
  ADD CONSTRAINT `hasil_wp_dm_ibfk_1` FOREIGN KEY (`id_dm`) REFERENCES `decision_maker` (`id_dm`),
  ADD CONSTRAINT `hasil_wp_dm_ibfk_2` FOREIGN KEY (`id_alt`) REFERENCES `alternatif` (`id_alt`);

--
-- Constraints for table `penilaian`
--
ALTER TABLE `penilaian`
  ADD CONSTRAINT `penilaian_ibfk_1` FOREIGN KEY (`id_dm`) REFERENCES `decision_maker` (`id_dm`),
  ADD CONSTRAINT `penilaian_ibfk_2` FOREIGN KEY (`id_alt`) REFERENCES `alternatif` (`id_alt`),
  ADD CONSTRAINT `penilaian_ibfk_3` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria` (`id_kriteria`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
