-- phpMyAdmin SQL Dump
-- version 4.5.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Tempo de geração: 14/09/2016 às 12:10
-- Versão do servidor: 5.5.52-0ubuntu0.14.04.1
-- Versão do PHP: 7.0.10-2+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `blabel`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `movements`
--

CREATE TABLE `movements` (
  `id` int(11) NOT NULL,
  `op_id` int(11) NOT NULL,
  `volume` int(11) NOT NULL,
  `amount` float NOT NULL,
  `unit` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `netweight` float NOT NULL,
  `grossweight` float NOT NULL,
  `labels` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Movements of packages table';

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `movements`
--
ALTER TABLE `movements`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `op_id` (`op_id`,`volume`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `movements`
--
ALTER TABLE `movements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
