-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 05.09.2025 klo 11:21
-- Palvelimen versio: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `213583`
--

-- --------------------------------------------------------

--
-- Rakenne taululle `kategoriat`
--

CREATE TABLE `kategoriat` (
  `id` int(11) NOT NULL,
  `nimi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vedos taulusta `kategoriat`
--

INSERT INTO `kategoriat` (`id`, `nimi`) VALUES
(1, 'Pizza'),
(2, 'Lisuke'),
(3, 'Juoma'),
(4, 'Jälkiruoka'),
(5, 'päivitys');

-- --------------------------------------------------------

--
-- Rakenne taululle `kayttajat`
--

CREATE TABLE `kayttajat` (
  `id` int(11) NOT NULL,
  `kayttajatunnus` varchar(50) DEFAULT NULL,
  `salasana` varchar(255) DEFAULT NULL,
  `rooli` enum('asiakas','työntekijä') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vedos taulusta `kayttajat`
--

INSERT INTO `kayttajat` (`id`, `kayttajatunnus`, `salasana`, `rooli`) VALUES
(0, 'justus.putkonen', '$2y$10$R3St/uiUFPznGalmTCRtkOFofvcD4BGHHI6putVKxKDdLuB.b1LG2', 'asiakas'),
(1, 'testi', 'salasana123', 'asiakas'),
(2, 'admin', 'admin123', 'työntekijä');

-- --------------------------------------------------------

--
-- Rakenne taululle `tilaukset`
--

CREATE TABLE `tilaukset` (
  `id` int(11) NOT NULL,
  `kayttaja_id` int(11) DEFAULT NULL,
  `yhteensa` decimal(5,2) DEFAULT NULL,
  `luotu` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vedos taulusta `tilaukset`
--

INSERT INTO `tilaukset` (`id`, `kayttaja_id`, `yhteensa`, `luotu`) VALUES
(4, 0, 9.20, '2025-09-05 07:15:20'),
(5, 0, 9.20, '2025-09-05 07:15:20'),
(6, 0, 9.20, '2025-09-05 07:15:20');

-- --------------------------------------------------------

--
-- Rakenne taululle `tilausrivit`
--

CREATE TABLE `tilausrivit` (
  `id` int(11) NOT NULL,
  `tilaus_id` int(11) DEFAULT NULL,
  `tuote_id` int(11) DEFAULT NULL,
  `maara` int(11) DEFAULT NULL,
  `hinta` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vedos taulusta `tilausrivit`
--

INSERT INTO `tilausrivit` (`id`, `tilaus_id`, `tuote_id`, `maara`, `hinta`) VALUES
(1, 0, 0, 6, 700.00),
(2, 4, 3, 1, 9.20);

-- --------------------------------------------------------

--
-- Rakenne taululle `tuotteet`
--

CREATE TABLE `tuotteet` (
  `id` int(11) NOT NULL,
  `nimi` varchar(100) DEFAULT NULL,
  `hinta` decimal(5,2) DEFAULT NULL,
  `kuva_url` varchar(255) DEFAULT NULL,
  `kategoria_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vedos taulusta `tuotteet`
--

INSERT INTO `tuotteet` (`id`, `nimi`, `hinta`, `kuva_url`, `kategoria_id`) VALUES
(1, 'Jäätelö', 700.00, NULL, 1),
(2, 'Pepperoni', 8.90, NULL, 1),
(3, 'Hawaii', 9.20, NULL, 1),
(4, 'Valkosipulileipä', 3.50, NULL, 2),
(5, 'Ranskalaiset', 4.00, NULL, 2),
(6, 'Coca-Cola 0,5l', 2.50, NULL, 3),
(7, 'Fanta 0,5l', 2.50, NULL, 3),
(8, 'Jälkiruoka', 0.05, '', 4),
(9, 'Margarita', 7.70, 'p3.jpg', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategoriat`
--
ALTER TABLE `kategoriat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kayttajat`
--
ALTER TABLE `kayttajat`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tilaukset`
--
ALTER TABLE `tilaukset`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kayttaja_id` (`kayttaja_id`);

--
-- Indexes for table `tilausrivit`
--
ALTER TABLE `tilausrivit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tilaus_id` (`tilaus_id`),
  ADD KEY `tuote_id` (`tuote_id`);

--
-- Indexes for table `tuotteet`
--
ALTER TABLE `tuotteet`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategoria_id` (`kategoria_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategoriat`
--
ALTER TABLE `kategoriat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tilaukset`
--
ALTER TABLE `tilaukset`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tilausrivit`
--
ALTER TABLE `tilausrivit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tuotteet`
--
ALTER TABLE `tuotteet`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Rajoitteet vedostauluille
--

--
-- Rajoitteet taululle `tilaukset`
--
ALTER TABLE `tilaukset`
  ADD CONSTRAINT `tilaukset_ibfk_1` FOREIGN KEY (`kayttaja_id`) REFERENCES `kayttajat` (`id`);

--
-- Rajoitteet taululle `tilausrivit`
--
ALTER TABLE `tilausrivit`
  ADD CONSTRAINT `tilausrivit_ibfk_1` FOREIGN KEY (`tilaus_id`) REFERENCES `tilaukset` (`id`);

--
-- Rajoitteet taululle `tuotteet`
--
ALTER TABLE `tuotteet`
  ADD CONSTRAINT `tuotteet_ibfk_1` FOREIGN KEY (`kategoria_id`) REFERENCES `kategoriat` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
