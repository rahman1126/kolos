-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 30 Mar 2016 pada 12.07
-- Versi Server: 10.1.10-MariaDB
-- PHP Version: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kolos`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `form_merchant`
--

CREATE TABLE `form_merchant` (
  `id` int(10) UNSIGNED NOT NULL,
  `business_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `category` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `business_address` text COLLATE utf8_unicode_ci NOT NULL,
  `business_phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `profile_picture` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `open_time` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `close_time` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `area_covered` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `number_employees` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `services` text COLLATE utf8_unicode_ci NOT NULL,
  `email_registration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mobile` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `form_merchant`
--

INSERT INTO `form_merchant` (`id`, `business_name`, `category`, `business_address`, `business_phone`, `name`, `phone`, `email`, `description`, `profile_picture`, `open_time`, `close_time`, `area_covered`, `number_employees`, `services`, `email_registration`, `username`, `password`, `mobile`, `created_at`, `updated_at`) VALUES
(17, 'bego', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'rahmankurnia1126@gmail.com', '123456', '', '2016-03-30 10:01:32', '2016-03-30 10:01:32');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `form_merchant`
--
ALTER TABLE `form_merchant`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `form_merchant`
--
ALTER TABLE `form_merchant`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
