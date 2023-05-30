-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Maj 30, 2023 at 03:17 AM
-- Wersja serwera: 10.4.28-MariaDB
-- Wersja PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pizzadatabase`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `uzytkownicy`
--

CREATE TABLE `uzytkownicy` (
  `id` int(11) NOT NULL,
  `imie` varchar(50) NOT NULL,
  `nazwisko` varchar(50) NOT NULL,
  `numer_telefonu` varchar(20) NOT NULL,
  `adres_zamieszkania` varchar(100) NOT NULL,
  `nazwa_uzytkownika` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `haslo` varchar(100) NOT NULL,
  `typ_konta` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `uzytkownicy`
--

INSERT INTO `uzytkownicy` (`id`, `imie`, `nazwisko`, `numer_telefonu`, `adres_zamieszkania`, `nazwa_uzytkownika`, `email`, `haslo`, `typ_konta`) VALUES
(1, 'Mateusz', 'Kuźnia', '100000001', 'Opole, Ul. Sezamkowa 5', 'mateusz', 'mateusz@mail.com', '$2y$10$s.3Ye8Ibp10sWiF8i9Qvi.IZmoATicIgTHqYuSYo.z3/MGu8WyBiK', 'user'),
(2, 'Jacek', 'Ciszewski', '100000002', 'Opole, ul. Skargi 13', 'jacek', 'jacek@mail.com', '$2y$10$6/o.OPKQeYockno7MJaBlOPMngtqCBwPSu6RReobhDOI61Dd21wc6', 'user');

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `uzytkownicy`
--
ALTER TABLE `uzytkownicy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
