-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 05 Jul 2022 pada 16.28
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `antrian`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `nama`, `username`, `password`) VALUES
(4, 'Admin', 'Admin', 'adminadmin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `antrian`
--

CREATE TABLE `antrian` (
  `id` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `no_antrian` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `waktu_panggil` timestamp NULL DEFAULT NULL,
  `waktu_selesai` timestamp NULL DEFAULT NULL,
  `pelayanan_id` int(11) NOT NULL,
  `loket_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `antrian`
--

INSERT INTO `antrian` (`id`, `tanggal`, `no_antrian`, `status`, `waktu_panggil`, `waktu_selesai`, `pelayanan_id`, `loket_id`) VALUES
(25, '2022-07-04 03:38:59', 1, 2, '2022-07-03 20:25:44', '2022-07-04 15:08:17', 3, 2),
(26, '2022-07-04 03:39:13', 2, 0, '2022-07-03 20:08:55', NULL, 3, NULL),
(27, '2022-07-04 03:40:00', 1, 0, NULL, NULL, 2, NULL),
(28, '2022-07-04 03:40:41', 2, 0, NULL, NULL, 2, NULL),
(29, '2022-07-04 17:05:15', 3, 0, NULL, NULL, 3, NULL),
(30, '2022-07-05 05:07:45', 1, 2, '2022-07-04 15:08:25', '2022-07-05 02:10:25', 3, 2),
(31, '2022-07-05 05:08:47', 2, 1, '2022-07-04 15:14:52', NULL, 3, 4),
(32, '2022-07-05 05:08:50', 1, 1, '2022-07-04 15:11:13', NULL, 2, 3),
(33, '2022-07-05 05:08:56', 2, 0, NULL, NULL, 2, NULL),
(34, '2022-07-05 05:09:13', 3, 0, NULL, NULL, 2, NULL),
(35, '2022-07-05 05:09:29', 3, 1, '2022-07-05 02:14:15', NULL, 3, 2),
(36, '2022-07-05 09:02:56', 4, 0, NULL, NULL, 3, NULL),
(37, '2022-07-05 09:03:00', 4, 0, NULL, NULL, 2, NULL),
(38, '2022-07-05 09:03:44', 5, 0, NULL, NULL, 3, NULL),
(39, '2022-07-05 09:07:42', 6, 0, NULL, NULL, 3, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `loket`
--

CREATE TABLE `loket` (
  `id` int(11) NOT NULL,
  `nama` varchar(199) NOT NULL,
  `keterangan` tinytext NOT NULL,
  `pelayanan_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `loket`
--

INSERT INTO `loket` (`id`, `nama`, `keterangan`, `pelayanan_id`) VALUES
(2, 'Loket 1', 'Loket 1 Keterangan', 3),
(3, 'Loket 2', 'Keterangan Loket 2', 2),
(4, 'Loket 3', 'Loket 3 Keterangan', 3),
(5, 'Loket 4', 'Keterangan Loket 4', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelayanan`
--

CREATE TABLE `pelayanan` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `keterangan` tinytext NOT NULL,
  `kode` varchar(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pelayanan`
--

INSERT INTO `pelayanan` (`id`, `nama`, `keterangan`, `kode`) VALUES
(2, 'Customer Serv', 'Customer Service Keterangan', 'CS'),
(3, 'Teller', 'Keterangan Teller', 'TE');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `antrian`
--
ALTER TABLE `antrian`
  ADD PRIMARY KEY (`id`),
  ADD KEY `loket_id` (`loket_id`),
  ADD KEY `pelayanan_id` (`pelayanan_id`);

--
-- Indeks untuk tabel `loket`
--
ALTER TABLE `loket`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pelayanan_id` (`pelayanan_id`);

--
-- Indeks untuk tabel `pelayanan`
--
ALTER TABLE `pelayanan`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `antrian`
--
ALTER TABLE `antrian`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `loket`
--
ALTER TABLE `loket`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pelayanan`
--
ALTER TABLE `pelayanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `antrian`
--
ALTER TABLE `antrian`
  ADD CONSTRAINT `antrian_ibfk_1` FOREIGN KEY (`loket_id`) REFERENCES `loket` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `antrian_ibfk_2` FOREIGN KEY (`pelayanan_id`) REFERENCES `pelayanan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `loket`
--
ALTER TABLE `loket`
  ADD CONSTRAINT `loket_ibfk_1` FOREIGN KEY (`pelayanan_id`) REFERENCES `pelayanan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
