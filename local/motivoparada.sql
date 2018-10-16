-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 30-Jan-2018 às 14:56
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
-- Estrutura da tabela `motivoparada`
--

CREATE TABLE `motivoparada` (
  `id` int(11) NOT NULL,
  `descricao` varchar(200) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='Motivos de paradas de maquinas';

--
-- Extraindo dados da tabela `motivoparada`
--

INSERT INTO `motivoparada` (`id`, `descricao`) VALUES
(1, 'Manutencao Corretiva'),
(2, 'Manutencao Preventiva'),
(3, 'Limpeza'),
(4, 'Falta Programacao (sem pedido)'),
(5, 'Domingo/Feriado'),
(6, 'Falta de Energia'),
(7, 'Falta Materia-Prima'),
(8, 'Falta de Ar comprimido'),
(9, 'Falta de Mao de Obra');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `motivoparada`
--
ALTER TABLE `motivoparada`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `motivoparada`
--
ALTER TABLE `motivoparada`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
