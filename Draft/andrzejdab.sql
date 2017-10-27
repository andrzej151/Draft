-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 27 Paź 2017, 12:45
-- Wersja serwera: 10.0.32-MariaDB-0+deb8u1
-- Wersja PHP: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `andrzejdab`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `DBenefity`
--

CREATE TABLE `DBenefity` (
  `id` int(11) NOT NULL,
  `idProj` int(11) NOT NULL,
  `opis` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `ilosc` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `DLiderzy`
--

CREATE TABLE `DLiderzy` (
  `idproj` int(11) NOT NULL,
  `idusera` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `DProjekty`
--

CREATE TABLE `DProjekty` (
  `id` int(11) NOT NULL,
  `nazwa` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `opisK` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `opisD` text COLLATE utf8_polish_ci NOT NULL,
  `linkOpis` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `benefityOpis` text COLLATE utf8_polish_ci NOT NULL,
  `punkty` int(11) NOT NULL,
  `punktyWydane` int(11) NOT NULL,
  `linkZak` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `status` varchar(10) COLLATE utf8_polish_ci NOT NULL COMMENT 'DOT REL ZAK ZAW ZGL ',
  `DataZl` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `DataZk` date DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `DPrzDoProj`
--

CREATE TABLE `DPrzDoProj` (
  `id` int(11) NOT NULL,
  `idproj` int(11) NOT NULL,
  `idusera` int(11) NOT NULL,
  `punkty` int(11) NOT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `DPrzDoUs`
--

CREATE TABLE `DPrzDoUs` (
  `id` int(11) NOT NULL,
  `idproj` int(11) NOT NULL,
  `idusera` int(11) NOT NULL,
  `idzad` int(11) NOT NULL COMMENT 'z tab DZadDoProj',
  `punkty` int(11) NOT NULL,
  `idLidera` int(11) NOT NULL,
  `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `DSpotkanie`
--

CREATE TABLE `DSpotkanie` (
  `id` int(11) NOT NULL,
  `idProj` int(11) NOT NULL,
  `cel` text COLLATE utf8_polish_ci NOT NULL,
  `data` datetime NOT NULL,
  `miejsce` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `link` varchar(255) COLLATE utf8_polish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `DUczestnProj`
--

CREATE TABLE `DUczestnProj` (
  `idproj` int(11) NOT NULL,
  `idusera` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `DUsers`
--

CREATE TABLE `DUsers` (
  `id` int(11) NOT NULL,
  `login` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `haslo` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `kod` varchar(255) COLLATE utf8_polish_ci NOT NULL,
  `status` varchar(20) COLLATE utf8_polish_ci NOT NULL COMMENT 'AKT ZAL ZGL ZAW ZBL',
  `imie` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `nazwisko` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_polish_ci NOT NULL,
  `punkty` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `DUwagiProj`
--

CREATE TABLE `DUwagiProj` (
  `id` int(11) NOT NULL,
  `idproj` int(11) NOT NULL,
  `idusera` int(11) NOT NULL,
  `idlidera` int(11) NOT NULL,
  `opis` text COLLATE utf8_polish_ci NOT NULL,
  `status` varchar(10) COLLATE utf8_polish_ci NOT NULL COMMENT 'ZAL WYK'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `DUwagiZad`
--

CREATE TABLE `DUwagiZad` (
  `id` int(11) NOT NULL,
  `IdZadG` int(11) NOT NULL,
  `idusera` int(11) NOT NULL,
  `idlidera` int(11) NOT NULL,
  `opis` text COLLATE utf8_polish_ci NOT NULL,
  `status` varchar(10) COLLATE utf8_polish_ci NOT NULL COMMENT 'WYK ZAL'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `DZadanieG`
--

CREATE TABLE `DZadanieG` (
  `id` int(11) NOT NULL,
  `idproj` int(11) NOT NULL,
  `opis` text COLLATE utf8_polish_ci NOT NULL,
  `punkty` int(11) NOT NULL,
  `priorytet` int(11) NOT NULL,
  `dedline` date NOT NULL,
  `status` varchar(10) COLLATE utf8_polish_ci NOT NULL COMMENT 'REL DWK DOB ZAK ZGL',
  `link` varchar(255) COLLATE utf8_polish_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `DZadanieM`
--

CREATE TABLE `DZadanieM` (
  `id` int(11) NOT NULL,
  `IdZadG` int(11) NOT NULL,
  `opis` text COLLATE utf8_polish_ci NOT NULL,
  `status` int(11) NOT NULL COMMENT 'WYK DWK DOB',
  `dedline` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `DZadDoProj`
--

CREATE TABLE `DZadDoProj` (
  `id` int(11) NOT NULL,
  `idProj` int(11) NOT NULL,
  `idZadG` int(11) NOT NULL,
  `idUsera` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `punkty` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

-- --------------------------------------------------------

--
-- Indeksy dla zrzutów tabel
--

--
-- Indexes for table `DBenefity`
--
ALTER TABLE `DBenefity`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `DLiderzy`
--
ALTER TABLE `DLiderzy`
  ADD PRIMARY KEY (`idproj`,`idusera`);

--
-- Indexes for table `DProjekty`
--
ALTER TABLE `DProjekty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `DPrzDoProj`
--
ALTER TABLE `DPrzDoProj`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `DPrzDoUs`
--
ALTER TABLE `DPrzDoUs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `DSpotkanie`
--
ALTER TABLE `DSpotkanie`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `DUczestnProj`
--
ALTER TABLE `DUczestnProj`
  ADD PRIMARY KEY (`idproj`,`idusera`);

--
-- Indexes for table `DUsers`
--
ALTER TABLE `DUsers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `DZadanieG`
--
ALTER TABLE `DZadanieG`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `DZadanieM`
--
ALTER TABLE `DZadanieM`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `DZadDoProj`
--
ALTER TABLE `DZadDoProj`
  ADD PRIMARY KEY (`id`);


--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `DBenefity`
--
ALTER TABLE `DBenefity`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `DProjekty`
--
ALTER TABLE `DProjekty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `DPrzDoProj`
--
ALTER TABLE `DPrzDoProj`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `DPrzDoUs`
--
ALTER TABLE `DPrzDoUs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `DSpotkanie`
--
ALTER TABLE `DSpotkanie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `DUsers`
--
ALTER TABLE `DUsers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `DZadanieG`
--
ALTER TABLE `DZadanieG`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `DZadanieM`
--
ALTER TABLE `DZadanieM`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT dla tabeli `DZadDoProj`
--
ALTER TABLE `DZadDoProj`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
