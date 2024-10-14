-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Gegenereerd op: 09 okt 2024 om 13:11
-- Serverversie: 10.4.32-MariaDB
-- PHP-versie: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `verkiezing_db`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `parties`
--

CREATE TABLE `parties` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `parties`
--

INSERT INTO `parties` (`id`, `name`, `description`, `created_at`) VALUES
(1, 'VVD', 'Een brede en sterke middengroep is cruciaal voor een stabiele samenleving.', '2024-10-08 16:17:22'),
(2, 'PVV', 'De Partij voor de Vrijheid (PVV) is een populistische partij met zowel conservatieve als liberale standpunten.', '2024-10-08 16:17:22'),
(3, 'PVDA', 'De PvdA zet zich in voor gelijkheid en sociale zekerheid voor alle burgers.', '2024-10-08 16:17:22'),
(4, 'D66', 'D66 gelooft in gelijke kansen voor iedereen en hulp voor wie het nodig heeft.', '2024-10-08 16:17:22');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `naam` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `users`
--

INSERT INTO `users` (`id`, `naam`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'tabon', 'tabon@tabon.com', '$2y$10$nF5v2jzuynnb8anaY0cR1eTN0u.sY7ooVsWI3RVIXUnbHAlzDpbZm', 'user', '2024-10-08 16:17:46'),
(2, 'test', 'test@test.com', '$2y$10$3IP4alKFVubyXRUURZS8G.CwUGlKaIyuW/NUptiAJ.CCzbahz5e.O', 'user', '2024-10-08 16:21:44'),
(3, 'baa', 'baa@baa.com', '$2y$10$3FHGoRHoCmynfhrWnkYiSOXXfmA./iZTteJfHSPFcXTyhiudFLOK2', 'user', '2024-10-08 16:24:20'),
(4, 'lucas', 'lucas@lucas.com', '$2y$10$nuuH3fVonWH84WZwmefVgeyZOS4w0Ay7Pc8r6V6LMQFBG9ymdNJPu', 'user', '2024-10-09 09:17:49'),
(5, 'erim', 'erim@erim.com', '$2y$10$tWJXGC9KcnW8s6pPdNzdmualItmPRsWtuqQ31f5vTZSwTT0Pn.mDO', 'user', '2024-10-09 09:18:49');

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `votes`
--

CREATE TABLE `votes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `party_id` int(11) NOT NULL,
  `vote_time` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Gegevens worden geëxporteerd voor tabel `votes`
--

INSERT INTO `votes` (`id`, `user_id`, `party_id`, `vote_time`) VALUES
(1, 1, 1, '2024-10-08 16:17:59'),
(2, 2, 3, '2024-10-08 16:22:07'),
(3, 3, 3, '2024-10-08 16:24:36'),
(4, 4, 4, '2024-10-09 09:18:13'),
(5, 5, 2, '2024-10-09 09:19:03');

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `parties`
--
ALTER TABLE `parties`
  ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexen voor tabel `votes`
--
ALTER TABLE `votes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_vote` (`user_id`),
  ADD KEY `party_id` (`party_id`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `parties`
--
ALTER TABLE `parties`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT voor een tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT voor een tabel `votes`
--
ALTER TABLE `votes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Beperkingen voor geëxporteerde tabellen
--

--
-- Beperkingen voor tabel `votes`
--
ALTER TABLE `votes`
  ADD CONSTRAINT `votes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `votes_ibfk_2` FOREIGN KEY (`party_id`) REFERENCES `parties` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
