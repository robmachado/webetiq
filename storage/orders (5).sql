-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 13-Set-2016 às 10:25
-- Versão do servidor: 5.7.13-0ubuntu0.16.04.2
-- PHP Version: 7.0.8-0ubuntu0.16.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blabel`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `customercode` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `pourchaseorder` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `salesorder` int(11) NOT NULL,
  `code` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `eancode` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `shelflife` int(11) NOT NULL,
  `salesunit` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Production Orders Table';

--
-- Extraindo dados da tabela `orders`
--

INSERT INTO `orders` (`id`, `customer`, `customercode`, `pourchaseorder`, `salesorder`, `code`, `description`, `eancode`, `shelflife`, `salesunit`, `created_at`) VALUES
(14, 'CIA', '', 'AS1212', 0, 'PEBD-B0075', 'SACO PEAD REC LEITOSO 80X150X005', '', 365, 'pcs', '2002-06-10 00:00:00'),
(17, 'AUTOMETAL', '', '5454545', 5077, 'PEBD-S0687', 'SACO PEBD 60X90X004', '11111111', 365, 'kg', '2002-06-10 00:00:00'),
(18, 'REXAM', '', '', 0, 'PEBD-P1713', 'PELICULA PEBD IMP 125X002 - COD. 467882-001', '', 365, 'kg', '2002-06-10 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
