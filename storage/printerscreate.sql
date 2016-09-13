-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 06-Set-2016 às 13:26
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
-- Estrutura da tabela `printers`
--

CREATE TABLE `printers` (
  `printId` int(11) NOT NULL,
  `printName` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `printType` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `printDesc` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `printIP` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `printLang` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `printInterface` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `printBlock` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Lista de impressoras';

--
-- Extraindo dados da tabela `printers`
--

INSERT INTO `printers` (`printId`, `printName`, `printType`, `printDesc`, `printIP`, `printLang`, `printInterface`, `printBlock`) VALUES
(1, 'newZebra', 'T', 'ZT230', '192.168.1.20', 'ZPL2', 'LPR', 0),
(2, 'Local', 'T', 'TLP2844', '0.0.0.0', 'EPL2', 'QZ', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `printers`
--
ALTER TABLE `printers`
  ADD PRIMARY KEY (`printId`),
  ADD UNIQUE KEY `printName` (`printName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `printers`
--
ALTER TABLE `printers`
  MODIFY `printId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
