-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2+deb7u4
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 06-Jul-2016 às 10:50
-- Versão do servidor: 5.5.49
-- versão do PHP: 5.4.45-0+deb7u3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `production`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `extruders`
--

CREATE TABLE IF NOT EXISTS `extruders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `lote` int(11) NOT NULL,
  `seq` int(11) NOT NULL,
  `pliq` double NOT NULL,
  `pbruto` double NOT NULL,
  `ext` int(11) NOT NULL,
  `data` datetime NOT NULL,
  `operador` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=2 ;

--
-- Extraindo dados da tabela `extruders`
--

INSERT INTO `extruders` (`id`, `lote`, `seq`, `pliq`, `pbruto`, `ext`, `data`, `operador`) VALUES
(1, 68434, 1, 100, 110, 1, '2016-07-06 00:00:00', 'roberto');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
