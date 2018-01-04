-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 26-Set-2017 às 15:33
-- Versão do servidor: 5.7.19-0ubuntu0.16.04.1
-- PHP Version: 7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `legacy`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `entries`
--

CREATE TABLE `entries` (
  `id` int(11) NOT NULL,
  `numop` int(10) UNSIGNED NOT NULL,
  `fase` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `data` datetime NOT NULL,
  `maq` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `operador` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `hrIn` time NOT NULL,
  `hrFim` time NOT NULL,
  `qtd` float NOT NULL,
  `uni` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `sucata` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `entries`
--

INSERT INTO `entries` (`id`, `numop`, `fase`, `data`, `maq`, `operador`, `hrIn`, `hrFim`, `qtd`, `uni`, `sucata`) VALUES
(1, 1232, 'EXT', '2017-12-12 00:00:00', '1', 'AAAA', '12:22:00', '19:35:00', 100, 'KG', 1),
(3, 12123, 'REB', '2017-08-12 00:00:00', '1', 'SDS', '12:22:00', '23:22:00', 100, 'KG', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `entries`
--
ALTER TABLE `entries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `lancamento` (`numop`,`fase`,`data`,`maq`,`hrIn`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `entries`
--
ALTER TABLE `entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
