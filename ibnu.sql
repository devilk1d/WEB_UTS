-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2024 at 09:44 AM
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
-- Database: `ibnu`
--

-- --------------------------------------------------------

--
-- Table structure for table `abimanyu`
--

CREATE TABLE `abimanyu` (
  `id_pembeli` int(10) NOT NULL,
  `nama` varchar(30) NOT NULL,
  `alamat` varchar(50) NOT NULL,
  `no_telp` varchar(20) NOT NULL,
  `Tgl_Transaksi` date NOT NULL,
  `Jenis_barang` varchar(25) NOT NULL,
  `Nama_barang` varchar(50) NOT NULL,
  `Jumlah` int(20) NOT NULL,
  `Harga` int(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `abimanyu`
--

INSERT INTO `abimanyu` (`id_pembeli`, `nama`, `alamat`, `no_telp`, `Tgl_Transaksi`, `Jenis_barang`, `Nama_barang`, `Jumlah`, `Harga`) VALUES
(1, 'Ibnu Dwito Abimanyu', 'jambu', '08111014502', '2024-10-23', '123123', 'asus', 11, 10000000),
(3, 'raja gula', 'nonin', '082373912', '2024-10-05', 'Kendaraan', 'Mobil', 1, 800000000),
(4, 'Jontor', 'Jl. Merdeka 123', '08123456789', '2024-10-23', 'Elektronik', 'Smartphone XYZ', 1, 5000000),
(5, 'Maikal Jomok', 'Jl. Sudirman 45', '08234567890', '2024-10-23', 'Fashion', 'Kemeja Formal', 2, 350000),
(6, 'Joko Kendil', 'Jl. Gatot Subroto 67', '08345678901', '2024-10-22', 'Elektronik', 'Laptop ABC', 1, 8000000),
(7, 'Hafiz Rizqi', 'Jl. Asia Afrika 89', '08456789012', '2024-10-22', 'Fashion', 'Celana Jeans', 3, 250000),
(8, 'Asan', 'Jl. Diponegoro 12', '08567890123', '2024-10-21', 'Elektronik', 'Headphone XYZ', 2, 800000),
(9, 'Aufa', 'Jl. Veteran 34', '08678901234', '2024-10-21', 'Fashion', 'Dress Casual', 1, 450000),
(10, 'Al Bilad', 'Jl. Pahlawan 56', '08789012345', '2024-10-20', 'Elektronik', 'Speaker Bluetooth', 2, 600000),
(11, 'Ucup Jawa', 'Jl. Tentara 78', '08890123456', '2024-10-20', 'Fashion', 'Kaos Polos', 4, 100000),
(12, 'Maulana', 'Jl. Veteran 90', '08901234567', '2024-10-19', 'Elektronik', 'Power Bank', 3, 200000),
(13, 'Fahmi ALi', 'Jl. Sudirman 11', '09012345678', '2024-10-19', 'Fashion', 'Jaket Denim', 1, 550000),
(14, 'Alek Bijer', 'Jl. Asia 23', '09123456789', '2024-10-18', 'Elektronik', 'Mouse Wireless', 2, 150000),
(15, 'Katak Bijer', 'Jl. Merdeka 45', '09234567890', '2024-10-18', 'Fashion', 'Topi Baseball', 3, 75000),
(16, 'SAyur Kangkung', 'Jl. Pahlawan 67', '09345678901', '2024-10-17', 'Elektronik', 'Keyboard Gaming', 1, 900000),
(18, 'Muklish', 'kukusan', '88912389', '2024-10-05', 'laptop', 'rog', 1, 17000000),
(19, 'Naufal', 'Bekasi', '012838123', '2024-09-12', 'hp', 'hp', 1, 1000000),
(22, 'bimzo', 'jambu123', '08111014502', '2024-10-11', 'buah', '10', 919, 123),
(24, 'Rizqi Asan', 'Citayem', '08111014503', '2024-11-01', 'Laptop', 'Asus ROG', 1, 25000000),
(25, 'Hani', 'depok', '00123980912', '2024-02-07', 'Laptop', 'Lenovo', 1, 43000000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abimanyu`
--
ALTER TABLE `abimanyu`
  ADD PRIMARY KEY (`id_pembeli`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `abimanyu`
--
ALTER TABLE `abimanyu`
  MODIFY `id_pembeli` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
