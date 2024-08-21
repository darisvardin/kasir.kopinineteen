-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 18 Agu 2024 pada 09.17
-- Versi server: 10.4.22-MariaDB
-- Versi PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kasir`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori`
--

CREATE TABLE `kategori` (
  `idkategori` int(4) NOT NULL,
  `namakategori` varchar(50) NOT NULL,
  `ketkategori` tinytext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `kategori`
--

INSERT INTO `kategori` (`idkategori`, `namakategori`, `ketkategori`) VALUES
(1, 'Makanan', NULL),
(2, 'Minuman Dingin', NULL),
(3, 'MilkShake', NULL),
(4, 'Mocktail', NULL),
(5, 'Coffe', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ksr`
--

CREATE TABLE `ksr` (
  `idksr` int(11) NOT NULL,
  `userksr` varchar(20) NOT NULL,
  `pwksr` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `jkksr` enum('L','P') NOT NULL DEFAULT 'P',
  `level` varchar(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `ksr`
--

INSERT INTO `ksr` (`idksr`, `userksr`, `pwksr`, `fullname`, `jkksr`, `level`) VALUES
(1, 'admin', '$2y$10$6F2V2TF.ZzsOeZA2kW5v5uotYp1pfvkgXFWO8yycrTKhT0rxt..qK', 'admin', 'P', 'Admin'),
(2, 'nana', '$2y$10$gTVCiFOnhXFfPQe7kaRziOu8S76RPpo/4qpA6rTYP3iUIVjUp4j5m', 'nana aja', 'P', 'Kasir'),
(3, 'daris', '$2y$10$BlITKM3xI2w6IFFJpGUWVuvmLW7LP0SwBTyZGvhhMyzoNhj6VG/2i', 'Daris Avyan F', 'L', 'Admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `idpembayaran` int(4) NOT NULL,
  `namapembayaran` varchar(50) NOT NULL,
  `ketpembayaran` tinytext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`idpembayaran`, `namapembayaran`, `ketpembayaran`) VALUES
(1, 'Tunai', NULL),
(2, 'QRIS', 'E-Wallet');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `idpl` int(11) NOT NULL,
  `ket` varchar(50) NOT NULL,
  `tgl` date NOT NULL,
  `qty` int(15) NOT NULL,
  `nominal` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `pengeluaran`
--

INSERT INTO `pengeluaran` (`idpl`, `ket`, `tgl`, `qty`, `nominal`) VALUES
(1, 'Gelas', '2024-08-06', 10, 10000),
(2, 'Piring', '2024-08-07', 20, 20000),
(3, 'Sedotan', '2024-08-09', 10, 5000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `idproduk` int(11) NOT NULL,
  `kodeproduk` varchar(10) NOT NULL,
  `kategori` int(4) NOT NULL,
  `namaproduk` varchar(255) NOT NULL,
  `hargadasar` double NOT NULL,
  `hargajual` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`idproduk`, `kodeproduk`, `kategori`, `namaproduk`, `hargadasar`, `hargajual`) VALUES
(1, 'MK001', 1, 'Cireng', 5000, 7000),
(2, 'MD001', 2, 'Es Teh', 3000, 4000),
(3, 'MD002', 2, 'Jus Mangga', 10000, 13000),
(4, 'MS001', 3, 'Ovaltin', 8000, 10000),
(5, 'C001', 5, 'Tubruk', 8000, 10000),
(6, 'MC001', 4, 'Orange', 13000, 15000),
(7, 'C002', 5, 'Vietnam Drip', 10000, 12000),
(8, 'MC002', 4, 'Manggo', 13000, 15000),
(9, 'MS002', 3, 'Milo', 10000, 12000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_msk`
--

CREATE TABLE `transaksi_msk` (
  `idtr` int(11) NOT NULL,
  `nota` varchar(10) NOT NULL,
  `tanggal` datetime NOT NULL,
  `produk` varchar(50) NOT NULL COMMENT 'kode produk',
  `nama_produk` varchar(255) NOT NULL,
  `harga` double UNSIGNED NOT NULL,
  `harga_dasar` double UNSIGNED NOT NULL COMMENT 'dari tb produk',
  `qty` int(10) UNSIGNED NOT NULL,
  `namapembayaran` varchar(10) NOT NULL,
  `pembeli` varchar(50) NOT NULL,
  `ksr` int(11) NOT NULL,
  `nama_ksr` varchar(50) NOT NULL,
  `periode` varchar(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `transaksi_msk`
--

INSERT INTO `transaksi_msk` (`idtr`, `nota`, `tanggal`, `produk`, `nama_produk`, `harga`, `harga_dasar`, `qty`, `namapembayaran`, `pembeli`, `ksr`, `nama_ksr`, `periode`) VALUES
(1, '00001', '2024-08-07 00:00:00', 'MD001', 'Es Teh', 4000, 3000, 1, 'Tunai', '', 1, 'admin', '08-2024'),
(2, '00002', '2024-08-07 00:00:00', 'MK001', 'Cireng', 7000, 5000, 2, 'Tunai', 'nana', 1, 'admin', '08-2024'),
(3, '00002', '2024-08-07 00:00:00', 'MD001', 'Es Teh', 4000, 3000, 2, 'Tunai', 'nana', 1, 'admin', '08-2024'),
(4, '00003', '2024-08-07 01:56:54', 'MD001', 'Es Teh', 4000, 3000, 4, 'Tunai', 'mas', 1, 'admin', '08-2024'),
(5, '00004', '2024-08-07 03:33:30', 'MK001', 'Cireng', 7000, 5000, 1, 'Tunai', 'awa', 1, 'admin', '08-2024'),
(6, '00005', '2024-08-07 08:33:38', 'MK001', 'Cireng', 7000, 5000, 2, 'Tunai', 'Daris', 2, 'nana aja', '08-2024'),
(7, '00005', '2024-08-07 08:33:38', 'MD001', 'Es Teh', 4000, 3000, 2, 'Tunai', 'Daris', 2, 'nana aja', '08-2024'),
(8, '00006', '2024-08-08 14:00:29', 'MD001', 'Es Teh', 4000, 3000, 2, 'QRIS', '', 2, 'nana aja', '08-2024'),
(9, '00007', '2024-08-08 14:06:16', 'MD001', 'Es Teh', 4000, 3000, 3, 'QRIS', '', 2, 'nana aja', '08-2024'),
(10, '00008', '2024-08-08 14:23:53', 'MK001', 'Cireng', 7000, 5000, 4, 'QRIS', '', 2, 'nana aja', '08-2024'),
(11, '00009', '2024-08-09 14:42:45', 'MD002', 'Jus Mangga', 13000, 10000, 2, 'QRIS', 'nano', 2, 'nana aja', '08-2024'),
(12, '00010', '2024-08-10 08:26:56', 'MK001', 'Cireng', 7000, 5000, 0, 'QRIS', '', 2, 'nana aja', '08-2024'),
(13, '00011', '2024-08-10 08:27:42', 'MD002', 'Jus Mangga', 13000, 10000, 3, 'QRIS', '', 2, 'nana aja', '08-2024'),
(14, '00012', '2024-08-10 08:32:28', 'MD002', 'Jus Mangga', 13000, 10000, 1, 'Tunai', '', 2, 'nana aja', '08-2024'),
(15, '00013', '2024-08-14 14:10:52', 'MD002', 'Jus Mangga', 13000, 10000, 2, 'Tunai', 'abidin', 2, 'nana aja', '08-2024'),
(16, '00014', '2024-08-14 14:25:28', 'MK001', 'Cireng', 7000, 5000, 3, 'QRIS', 'AW', 2, 'nana aja', '08-2024');

--
-- Trigger `transaksi_msk`
--
DELIMITER $$
CREATE TRIGGER `hps_sem` AFTER INSERT ON `transaksi_msk` FOR EACH ROW BEGIN
	DELETE FROM transaksi_sem
    WHERE produk = NEW.produk;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi_sem`
--

CREATE TABLE `transaksi_sem` (
  `idtr` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `produk` varchar(10) NOT NULL COMMENT 'kode produk',
  `nama_produk` varchar(255) NOT NULL,
  `harga` double UNSIGNED NOT NULL,
  `harga_dasar` double UNSIGNED NOT NULL COMMENT 'dari tb produk',
  `qty` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`idkategori`);

--
-- Indeks untuk tabel `ksr`
--
ALTER TABLE `ksr`
  ADD PRIMARY KEY (`idksr`),
  ADD UNIQUE KEY `userksr` (`userksr`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`idpembayaran`),
  ADD KEY `namapem` (`namapembayaran`);

--
-- Indeks untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`idpl`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`idproduk`),
  ADD UNIQUE KEY `kodeproduk` (`kodeproduk`),
  ADD KEY `kategori` (`kategori`);

--
-- Indeks untuk tabel `transaksi_msk`
--
ALTER TABLE `transaksi_msk`
  ADD PRIMARY KEY (`idtr`),
  ADD KEY `produk` (`produk`),
  ADD KEY `ksr` (`ksr`) USING BTREE;

--
-- Indeks untuk tabel `transaksi_sem`
--
ALTER TABLE `transaksi_sem`
  ADD PRIMARY KEY (`idtr`),
  ADD KEY `produk` (`produk`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kategori`
--
ALTER TABLE `kategori`
  MODIFY `idkategori` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `ksr`
--
ALTER TABLE `ksr`
  MODIFY `idksr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `idpembayaran` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `idpl` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `idproduk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `transaksi_msk`
--
ALTER TABLE `transaksi_msk`
  MODIFY `idtr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `transaksi_sem`
--
ALTER TABLE `transaksi_sem`
  MODIFY `idtr` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`kategori`) REFERENCES `kategori` (`idkategori`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
