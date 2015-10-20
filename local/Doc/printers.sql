-- phpMyAdmin SQL Dump
-- version 4.2.12deb2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Tempo de geração: 20/10/2015 às 14:46
-- Versão do servidor: 5.6.25-0ubuntu0.15.04.1
-- Versão do PHP: 5.6.4-4ubuntu6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de dados: `printers`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `printers`
--

CREATE TABLE IF NOT EXISTS `printers` (
`printId` int(11) NOT NULL,
  `printName` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `printType` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `printDesc` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `printIP` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `printLang` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `printInterface` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `printBlock` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Lista de impressoras';

--
-- Fazendo dump de dados para tabela `printers`
--

INSERT INTO `printers` (`printId`, `printName`, `printType`, `printDesc`, `printIP`, `printLang`, `printInterface`, `printBlock`) VALUES
(1, 'newZebra', 'T', 'ZT230', '192.168.1.20', 'ZPL2', 'LPR', 0),
(2, 'Local', 'T', 'TLP2844', '0.0.0.0', 'EPL2', 'QZ', 0);

--
-- Índices de tabelas apagadas
--

--
-- Índices de tabela `printers`
--
ALTER TABLE `printers`
 ADD PRIMARY KEY (`printId`), ADD UNIQUE KEY `printName` (`printName`);

--
-- AUTO_INCREMENT de tabelas apagadas
--

--
-- AUTO_INCREMENT de tabela `printers`
--
ALTER TABLE `printers`
MODIFY `printId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
