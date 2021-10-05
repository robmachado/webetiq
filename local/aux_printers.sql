-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tempo de Geração: 30/09/2015 às 10:40
-- Versão do servidor: 5.5.44-0ubuntu0.14.04.1
-- Versão do PHP: 5.6.13-1+deb.sury.org~trusty+3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Banco de dados: `pbase`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `aux_printers`
--

CREATE TABLE IF NOT EXISTS `printers` (
  `printId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id da tabela',
  `printName` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Nome da Impressora conforme compartilhada no CUPS',
  `printType` varchar(1) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'T' COMMENT 'Tipo de impressora M-matricial, T-térmica, L-laser, D-deskjet',
  `printDesc` varchar(250) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'Descrição da Impressora',
  `printIp` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `printLang` varchar(4) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `printInterface` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `printBlock` tinyint(4) NOT NULL,
  PRIMARY KEY (`printId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Cadastro das Impressoras de Rede' AUTO_INCREMENT=2 ;

--
-- Fazendo dump de dados para tabela `aux_printers`
--

INSERT INTO `printers` (`printId`, `printName`, `printType`, `printDesc`, `printIp`, `printLang`, `printInterface`, `printBlock`) VALUES
(1, 'newZebra', 'T', 'ZT230', '192.168.1.20', 'ZPL', 'CUPS', 0),
(2, 'Zebra', 'T', 'impressora zebra gc420t', '0.0.0.0', 'EPL2', 'QZ', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
