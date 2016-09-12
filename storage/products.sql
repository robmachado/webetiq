-- phpMyAdmin SQL Dump
-- version 4.5.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Tempo de geração: 09/09/2016 às 15:54
-- Versão do servidor: 5.5.50-0ubuntu0.14.04.1
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
-- Estrutura para tabela `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `eancode` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `shelflife` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Products Table';

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
