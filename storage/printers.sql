-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u5
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 01-Set-2016 às 09:26
-- Versão do servidor: 5.5.50
-- versão do PHP: 5.4.45-0+deb7u4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `printers`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `printers`
--

CREATE TABLE IF NOT EXISTS `printers` (
  `printId` int(11) NOT NULL AUTO_INCREMENT,
  `printName` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `printType` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `printDesc` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `printIP` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `printLang` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `printInterface` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `printBlock` tinyint(4) NOT NULL,
  PRIMARY KEY (`printId`),
  UNIQUE KEY `printName` (`printName`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Lista de impressoras' AUTO_INCREMENT=3 ;

--
-- Extraindo dados da tabela `printers`
--

INSERT INTO `printers` (`printId`, `printName`, `printType`, `printDesc`, `printIP`, `printLang`, `printInterface`, `printBlock`) VALUES
(1, 'newZebra', 'T', 'ZT230', '192.168.1.20', 'ZPL2', 'LPR', 0),
(2, 'Local', 'T', 'TLP2844', '0.0.0.0', 'EPL2', 'QZ', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
