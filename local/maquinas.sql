-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: 30-Jan-2018 às 14:55
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
-- Estrutura da tabela `maquinas`
--

CREATE TABLE `maquinas` (
  `id` int(11) NOT NULL,
  `maq` varchar(4) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Extraindo dados da tabela `maquinas`
--

INSERT INTO `maquinas` (`id`, `maq`, `descricao`) VALUES
(1, 'E1', 'HGR'),
(2, 'E2', 'Carnevale'),
(3, 'E3', 'Rulli'),
(4, 'E4', 'CMG'),
(5, 'E5', 'Minematsu'),
(6, 'E6', 'Carnevale'),
(7, 'E7', 'HGR'),
(8, 'E8', 'Carnevale'),
(9, 'I1', 'Feva 6'),
(10, 'I2', 'Feva 8'),
(11, 'R1', 'Startec'),
(12, 'R2', 'Permaco'),
(13, 'L1', 'colaminadora'),
(14, 'B1', 'Bolha 1300'),
(15, 'B2', 'Bolha 1700'),
(16, 'M1', 'Microperfuradeira'),
(17, 'C1', 'Polimaquinas'),
(18, 'C2', 'Macplas 800'),
(19, 'C3', 'Macplas 1400'),
(20, 'C4', 'Macplas 1400'),
(21, 'C5', 'Macplas 800'),
(22, 'C6', 'Macplas 800'),
(23, 'C7', 'HECCE'),
(24, 'C8', 'HECCE'),
(25, 'C9', 'Macplas 2000'),
(26, 'C10', 'FMC'),
(27, 'C11', 'FMC'),
(28, 'M1', 'Solda manual'),
(29, 'M2', 'Solda Manual');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `maquinas`
--
ALTER TABLE `maquinas`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `maquinas`
--
ALTER TABLE `maquinas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
