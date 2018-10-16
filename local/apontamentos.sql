-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 30-Jan-2018 às 14:23
-- Versão do servidor: 5.7.21-0ubuntu0.16.04.1
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
-- Estrutura da tabela `apontamentos`
--

CREATE TABLE `apontamentos` (
  `id` int(11) NOT NULL,
  `maq` varchar(15) COLLATE utf8_unicode_ci NOT NULL,
  `data` date NOT NULL,
  `shifttimeini` decimal(16,8) NOT NULL,
  `shifttimefim` decimal(16,8) NOT NULL,
  `turno` tinyint(4) NOT NULL,
  `parada` int(11) NOT NULL DEFAULT '0',
  `numop` int(11) DEFAULT NULL,
  `qtd` double(12,4) DEFAULT NULL,
  `uni` enum('KG','M','PC') COLLATE utf8_unicode_ci DEFAULT NULL,
  `fator` double(16,8) DEFAULT NULL,
  `setup` double(8,4) DEFAULT NULL,
  `ops` double(3,1) DEFAULT NULL,
  `velocidade` int(11) DEFAULT NULL,
  `refile` double(8,3) DEFAULT NULL,
  `aparas` double(8,3) DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Tabela dos apontamentos de produção';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `apontamentos`
--
ALTER TABLE `apontamentos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hini_dt_maq` (`maq`,`data`,`shifttimeini`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `apontamentos`
--
ALTER TABLE `apontamentos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
