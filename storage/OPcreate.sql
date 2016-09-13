-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 06-Set-2016 às 13:18
-- Versão do servidor: 5.7.13-0ubuntu0.16.04.2
-- PHP Version: 7.0.8-0ubuntu0.16.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `opmigrate`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `OP`
--

CREATE TABLE `OP` (
  `numop` int(11) NOT NULL,
  `cliente` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `codcli` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pedido` int(11) DEFAULT NULL,
  `prazo` datetime DEFAULT NULL,
  `produto` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `nummaq` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `matriz` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `kg1` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `kg1ind` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `kg2` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `kg2ind` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `kg3` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `kg3ind` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `kg4` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `kg4ind` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `kg5` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `kg5ind` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `kg6` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `kg6ind` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pesototal` float DEFAULT NULL,
  `pesomilheiro` float DEFAULT NULL,
  `pesobobina` float DEFAULT NULL,
  `quantidade` float DEFAULT NULL,
  `bolbobinas` int(11) DEFAULT NULL,
  `dataemissao` datetime DEFAULT NULL,
  `metragem` int(11) DEFAULT NULL,
  `contadordif` int(11) DEFAULT NULL,
  `isobobinas` int(11) DEFAULT NULL,
  `pedcli` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `unidade` varchar(6) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `OP`
--
ALTER TABLE `OP`
  ADD PRIMARY KEY (`numop`) USING BTREE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
