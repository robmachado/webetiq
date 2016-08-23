-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 23-Ago-2016 às 13:14
-- Versão do servidor: 5.7.13-0ubuntu0.16.04.2
-- PHP Version: 7.0.8-0ubuntu0.16.04.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "-03:00";
CREATE DATABASE IF NOT EXISTS webetiq;

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
  `id` int(11) NOT NULL,
  `numop` int(11) NOT NULL,
  `cliente` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `codcli` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pedido` int(11) DEFAULT NULL,
  `prazo` datetime DEFAULT NULL,
  `produto` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `codigo` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
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

-- --------------------------------------------------------

--
-- Estrutura da tabela `produtos`
--

CREATE TABLE `produtos` (
  `id` int(11) NOT NULL,
  `produto` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `codigo` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `ean` varchar(26) COLLATE utf8_unicode_ci DEFAULT NULL,
  `validade` int(11) DEFAULT NULL,
  `mp1` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `p1` float DEFAULT NULL,
  `mp2` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `p2` float DEFAULT NULL,
  `mp3` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `p3` float DEFAULT NULL,
  `mp4` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `p4` float DEFAULT NULL,
  `mp5` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `p5` float DEFAULT NULL,
  `mp6` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `p6` float DEFAULT NULL,
  `densidade` float DEFAULT NULL,
  `gramatura` float DEFAULT NULL,
  `tipobobina` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tratamento` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `lados` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `boblargura` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `tollargbobmax` float DEFAULT NULL,
  `tollargbobmin` float DEFAULT NULL,
  `refilar` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bobinasporvez` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `espessura1` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `tolespess1max` float DEFAULT NULL,
  `tolespess1min` float DEFAULT NULL,
  `espessura2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tolespess2max` float DEFAULT NULL,
  `tolespess2min` float DEFAULT NULL,
  `sanfona` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `tolsanfonamax` float DEFAULT NULL,
  `tolsanfonamin` float DEFAULT NULL,
  `impressao` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cilindro` int(11) DEFAULT NULL,
  `cyrel1` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cyrel2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cyrel3` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cyrel4` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cor1` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cor2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cor3` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cor4` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cor5` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cor6` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cor7` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cor8` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `modelosaco` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ziper` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `nziper` int(11) DEFAULT NULL,
  `solda` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cortarporvez` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `largboca` float DEFAULT NULL,
  `tollargbocamax` float DEFAULT NULL,
  `tollargbocamin` float DEFAULT NULL,
  `comprimento` float DEFAULT NULL,
  `tolcomprmax` float DEFAULT NULL,
  `tolcomprmin` float DEFAULT NULL,
  `sacoespess` float DEFAULT NULL,
  `tolsacoespessmax` float DEFAULT NULL,
  `tolsacoespessmin` float DEFAULT NULL,
  `microperfurado` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `estampado` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `estampar` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `laminado` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `laminar` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bolha` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `bolhar` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `isolmanta` char(1) COLLATE utf8_unicode_ci NOT NULL,
  `isolmantar` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `colagem` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dinas` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sanfcorte` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tolsanfcortemax` float DEFAULT NULL,
  `tolsanfcortemin` float DEFAULT NULL,
  `aba` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tolabamax` float DEFAULT NULL,
  `tolabamin` float DEFAULT NULL,
  `amarrar` int(11) DEFAULT NULL,
  `qtdpcbobbolha` int(11) DEFAULT NULL,
  `fatiar` int(11) DEFAULT NULL,
  `qtdpcbobmanta` int(11) DEFAULT NULL,
  `bolhafilm1` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bolhafilm2` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bolhafilm3` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `bolhafilm4` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pacote` int(11) DEFAULT NULL,
  `embalagem` varchar(90) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `unidades`
--

CREATE TABLE `unidades` (
  `id` int(11) NOT NULL,
  `unidade` varchar(6) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `OP`
--
ALTER TABLE `OP`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numop` (`numop`);

--
-- Indexes for table `produtos`
--
ALTER TABLE `produtos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `produto` (`produto`),
  ADD UNIQUE KEY `codigo` (`codigo`);

--
-- Indexes for table `unidades`
--
ALTER TABLE `unidades`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unidade` (`unidade`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `OP`
--
ALTER TABLE `OP`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `produtos`
--
ALTER TABLE `produtos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `unidades`
--
ALTER TABLE `unidades`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
