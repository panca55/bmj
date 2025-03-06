-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 06 Mar 2025 pada 19.50
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bmj`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id_login` int NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_apbd_desa`
--

CREATE TABLE `tb_apbd_desa` (
  `id_apbd_desa` int NOT NULL COMMENT 'Primary Key',
  `keterangan` varchar(255) DEFAULT NULL,
  `foto` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_bpd`
--

CREATE TABLE `tb_bpd` (
  `id_bpd` int NOT NULL COMMENT 'Primary Key',
  `keterangan` varchar(255) DEFAULT NULL,
  `foto` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_bumdes`
--

CREATE TABLE `tb_bumdes` (
  `id_bpd` int NOT NULL COMMENT 'Primary Key',
  `keterangan` varchar(255) DEFAULT NULL,
  `foto` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_data_laporan`
--

CREATE TABLE `tb_data_laporan` (
  `id_data_laporan` int NOT NULL COMMENT 'Primary Key',
  `keterangan` varchar(255) DEFAULT NULL,
  `file` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kalender_kegiatan`
--

CREATE TABLE `tb_kalender_kegiatan` (
  `id_kegiatan` int NOT NULL COMMENT 'Primary Key',
  `bulan` varchar(255) DEFAULT NULL,
  `tanggal` varchar(255) DEFAULT NULL,
  `kegiatan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_karang_taruna`
--

CREATE TABLE `tb_karang_taruna` (
  `id_karang_taruna` int NOT NULL COMMENT 'Primary Key',
  `keterangan` varchar(255) DEFAULT NULL,
  `foto` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kegiatan_pembangunan`
--

CREATE TABLE `tb_kegiatan_pembangunan` (
  `id_kegiatan_pembangunan` int NOT NULL COMMENT 'Primary Key',
  `keterangan` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kepala_desa`
--

CREATE TABLE `tb_kepala_desa` (
  `id_kades` int NOT NULL COMMENT 'Primary Key',
  `nama` varchar(255) DEFAULT NULL,
  `tempat_tanggal_lahir` varchar(255) DEFAULT NULL,
  `jenis_kelamin` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `hp` varchar(255) DEFAULT NULL,
  `nama_pasangan` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `keterangan_jabatan` varchar(255) DEFAULT NULL,
  `no_sk` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kontak`
--

CREATE TABLE `tb_kontak` (
  `id_kontak` int NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_layanan`
--

CREATE TABLE `tb_layanan` (
  `id_layanan` int NOT NULL,
  `layanan_desa` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_lembaga`
--

CREATE TABLE `tb_lembaga` (
  `id_lembaga` int NOT NULL,
  `karang_taruna` varchar(255) DEFAULT NULL,
  `bpd` varchar(255) DEFAULT NULL,
  `rt` int DEFAULT NULL,
  `bumdes` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_perangkat_desa`
--

CREATE TABLE `tb_perangkat_desa` (
  `id_perangkat_desa` int NOT NULL COMMENT 'Primary Key',
  `nama` varchar(255) DEFAULT NULL,
  `tempat_tanggal_lahir` varchar(255) DEFAULT NULL,
  `jenis_kelamin` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_persyaratan_surat`
--

CREATE TABLE `tb_persyaratan_surat` (
  `id_persyaratan_surat` int NOT NULL COMMENT 'Primary Key',
  `keterangan` varchar(255) DEFAULT NULL,
  `file` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_profil_desa`
--

CREATE TABLE `tb_profil_desa` (
  `id_profil_desa` int NOT NULL,
  `sejarah_desa` text,
  `visi_desa` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `misi_desa` text,
  `struktur_desa` blob,
  `monografi_kependudukan` varchar(300) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_rt`
--

CREATE TABLE `tb_rt` (
  `id_rt` int NOT NULL COMMENT 'Primary Key',
  `keterangan` varchar(255) DEFAULT NULL,
  `jabatan` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `hp` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_transparansi_anggaran`
--

CREATE TABLE `tb_transparansi_anggaran` (
  `id_transparansi_anggaran` int NOT NULL COMMENT 'Primary Key',
  `keterangan` varchar(255) DEFAULT NULL,
  `apbd_desa` blob,
  `dana_desa` blob,
  `pendapatan_asli_desa` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_transparasi`
--

CREATE TABLE `tb_transparasi` (
  `id_transparasi` int NOT NULL,
  `kalender_kegiatan` datetime DEFAULT NULL,
  `transparasi_anggaran` varchar(255) DEFAULT NULL,
  `data_laporan` varchar(200) DEFAULT NULL,
  `apbdesa` blob,
  `kegiatan_pembangunan` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id_login`);

--
-- Indeks untuk tabel `tb_apbd_desa`
--
ALTER TABLE `tb_apbd_desa`
  ADD PRIMARY KEY (`id_apbd_desa`);

--
-- Indeks untuk tabel `tb_bpd`
--
ALTER TABLE `tb_bpd`
  ADD PRIMARY KEY (`id_bpd`);

--
-- Indeks untuk tabel `tb_bumdes`
--
ALTER TABLE `tb_bumdes`
  ADD PRIMARY KEY (`id_bpd`);

--
-- Indeks untuk tabel `tb_data_laporan`
--
ALTER TABLE `tb_data_laporan`
  ADD PRIMARY KEY (`id_data_laporan`);

--
-- Indeks untuk tabel `tb_kalender_kegiatan`
--
ALTER TABLE `tb_kalender_kegiatan`
  ADD PRIMARY KEY (`id_kegiatan`);

--
-- Indeks untuk tabel `tb_karang_taruna`
--
ALTER TABLE `tb_karang_taruna`
  ADD PRIMARY KEY (`id_karang_taruna`);

--
-- Indeks untuk tabel `tb_kegiatan_pembangunan`
--
ALTER TABLE `tb_kegiatan_pembangunan`
  ADD PRIMARY KEY (`id_kegiatan_pembangunan`);

--
-- Indeks untuk tabel `tb_kepala_desa`
--
ALTER TABLE `tb_kepala_desa`
  ADD PRIMARY KEY (`id_kades`);

--
-- Indeks untuk tabel `tb_kontak`
--
ALTER TABLE `tb_kontak`
  ADD PRIMARY KEY (`id_kontak`);

--
-- Indeks untuk tabel `tb_layanan`
--
ALTER TABLE `tb_layanan`
  ADD PRIMARY KEY (`id_layanan`);

--
-- Indeks untuk tabel `tb_lembaga`
--
ALTER TABLE `tb_lembaga`
  ADD PRIMARY KEY (`id_lembaga`);

--
-- Indeks untuk tabel `tb_perangkat_desa`
--
ALTER TABLE `tb_perangkat_desa`
  ADD PRIMARY KEY (`id_perangkat_desa`);

--
-- Indeks untuk tabel `tb_persyaratan_surat`
--
ALTER TABLE `tb_persyaratan_surat`
  ADD PRIMARY KEY (`id_persyaratan_surat`);

--
-- Indeks untuk tabel `tb_profil_desa`
--
ALTER TABLE `tb_profil_desa`
  ADD PRIMARY KEY (`id_profil_desa`);

--
-- Indeks untuk tabel `tb_rt`
--
ALTER TABLE `tb_rt`
  ADD PRIMARY KEY (`id_rt`);

--
-- Indeks untuk tabel `tb_transparansi_anggaran`
--
ALTER TABLE `tb_transparansi_anggaran`
  ADD PRIMARY KEY (`id_transparansi_anggaran`);

--
-- Indeks untuk tabel `tb_transparasi`
--
ALTER TABLE `tb_transparasi`
  ADD PRIMARY KEY (`id_transparasi`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id_login` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_apbd_desa`
--
ALTER TABLE `tb_apbd_desa`
  MODIFY `id_apbd_desa` int NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';

--
-- AUTO_INCREMENT untuk tabel `tb_bpd`
--
ALTER TABLE `tb_bpd`
  MODIFY `id_bpd` int NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';

--
-- AUTO_INCREMENT untuk tabel `tb_bumdes`
--
ALTER TABLE `tb_bumdes`
  MODIFY `id_bpd` int NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';

--
-- AUTO_INCREMENT untuk tabel `tb_data_laporan`
--
ALTER TABLE `tb_data_laporan`
  MODIFY `id_data_laporan` int NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';

--
-- AUTO_INCREMENT untuk tabel `tb_kalender_kegiatan`
--
ALTER TABLE `tb_kalender_kegiatan`
  MODIFY `id_kegiatan` int NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';

--
-- AUTO_INCREMENT untuk tabel `tb_karang_taruna`
--
ALTER TABLE `tb_karang_taruna`
  MODIFY `id_karang_taruna` int NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';

--
-- AUTO_INCREMENT untuk tabel `tb_kegiatan_pembangunan`
--
ALTER TABLE `tb_kegiatan_pembangunan`
  MODIFY `id_kegiatan_pembangunan` int NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';

--
-- AUTO_INCREMENT untuk tabel `tb_kepala_desa`
--
ALTER TABLE `tb_kepala_desa`
  MODIFY `id_kades` int NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';

--
-- AUTO_INCREMENT untuk tabel `tb_kontak`
--
ALTER TABLE `tb_kontak`
  MODIFY `id_kontak` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_layanan`
--
ALTER TABLE `tb_layanan`
  MODIFY `id_layanan` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_lembaga`
--
ALTER TABLE `tb_lembaga`
  MODIFY `id_lembaga` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_perangkat_desa`
--
ALTER TABLE `tb_perangkat_desa`
  MODIFY `id_perangkat_desa` int NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';

--
-- AUTO_INCREMENT untuk tabel `tb_persyaratan_surat`
--
ALTER TABLE `tb_persyaratan_surat`
  MODIFY `id_persyaratan_surat` int NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';

--
-- AUTO_INCREMENT untuk tabel `tb_profil_desa`
--
ALTER TABLE `tb_profil_desa`
  MODIFY `id_profil_desa` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `tb_rt`
--
ALTER TABLE `tb_rt`
  MODIFY `id_rt` int NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';

--
-- AUTO_INCREMENT untuk tabel `tb_transparansi_anggaran`
--
ALTER TABLE `tb_transparansi_anggaran`
  MODIFY `id_transparansi_anggaran` int NOT NULL AUTO_INCREMENT COMMENT 'Primary Key';

--
-- AUTO_INCREMENT untuk tabel `tb_transparasi`
--
ALTER TABLE `tb_transparasi`
  MODIFY `id_transparasi` int NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
