-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Apr 26, 2024 alle 09:48
-- Versione del server: 10.4.28-MariaDB
-- Versione PHP: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eco_group`
--

--
-- Dump dei dati per la tabella `aziende`
--

INSERT INTO `aziende` (`codAzienda`, `username`, `mail`, `citta`, `cap`, `codAteco`, `password`, `DIMENSIONE_dimensione`) VALUES
(1, 'azienda 1', 'lia_davide@yahoo.it', 'Cesena', '4752321', '12913', '$2y$10$/6jjTKC96hxjIUlfqpcmhePtBYlxsFQCm3C6W21.RBwD2e/2x8w8e', 'media'),
(2, 'azienda2', 'ferarluca3@gmail.com', 'Cesena', '4752321', '1233124', '$2y$10$O4cGgF6I9WczWDhYM2EdeeNv96rYlL.w7NVVzfn.ATz2SVXDdftFy', 'media');

--
-- Dump dei dati per la tabella `categorie`
--

INSERT INTO `categorie` (`codCategoria`, `nomeCategoria`) VALUES
(8, 'Maturità aziendale'),
(6, 'Parametri Agile'),
(4, 'Parametri green'),
(5, 'Parametri lean'),
(7, 'Parametri resilient'),
(9, 'Risorse input-output');

--
-- Dump dei dati per la tabella `codici_azienda`
--

INSERT INTO `codici_azienda` (`AZIENDE_codAzienda`, `CODICI_CER_codiceCER`) VALUES
(1, '023912'),
(1, '13841'),
(2, '0909'),
(2, '12381');

--
-- Dump dei dati per la tabella `codici_cer`
--

INSERT INTO `codici_cer` (`codiceCER`) VALUES
('023912'),
('0909'),
('12381'),
('13841');

--
-- Dump dei dati per la tabella `dimensioni`
--

INSERT INTO `dimensioni` (`dimensione`) VALUES
('grande'),
('media'),
('piccola');

--
-- Dump dei dati per la tabella `domande`
--

INSERT INTO `domande` (`codDomanda`, `positiva`, `testo`, `CATEGORIE_idCATEGORIA`, `moderatori_codModeratore`) VALUES
(10, 1, 'L\'azienda è certificata ISO 14001?', 'Parametri green', 1),
(11, 1, 'L\'azienda è certificata ISO 14020?', 'Parametri green', 1),
(12, 1, 'L\'azienda è certificata ISO 14021?', 'Parametri green', 1),
(13, 1, 'L\'azienda è certificata ISO 14024?', 'Parametri green', 1),
(14, 1, 'L\'azienda è certificata ISO 14025?', 'Parametri green', 1),
(15, 1, 'L\'azienda è certificata ISO 14040?', 'Parametri green', 1),
(16, 1, 'L\'azienda è certificata ISO 14044?', 'Parametri green', 1),
(17, 1, 'L\'azienda è certificata ISO 14064?', 'Parametri green', 1),
(18, 1, 'L\'azienda è certificata ISO 14067?', 'Parametri green', 1),
(19, 1, 'L\'azienda è certificata EMAS?', 'Parametri green', 1),
(20, 1, 'L\'azienda è conforme al GRI 300?', 'Parametri green', 1),
(21, 1, 'E\' presente un bilancio di sostenibilità annuale? ', 'Parametri green', 1),
(22, 1, 'L\'attività economica principale dell\'azienda è conforme alla tassonomia UE?', 'Parametri green', 1),
(23, 1, 'Sono utilizzate materie prime seconde (anche rilavorate/riciclate) nel processi produttivi?', 'Parametri green', 1),
(24, 1, 'Con quale frequenza l\'azienda riceve sanzioni per le esternalità aziendali?', 'Parametri green', 1),
(25, 1, 'C\'è stata una riduzione del consumo di acqua nell\'ultimo triennio?', 'Parametri green', 1);

--
-- Dump dei dati per la tabella `moderatori`
--

INSERT INTO `moderatori` (`codModeratore`, `mail`, `username`, `password`) VALUES
(1, 'ferarluca@gmail.com', 'lucone113', '$2y$10$.UkAvACHBS2VDSAQDsKXreJ4o02KfkZXytx1a993sxsuKbR9yh/ze');

--
-- Dump dei dati per la tabella `scelte`
--

INSERT INTO `scelte` (`codScelta`, `valore`, `peso`, `domande_codDomanda`) VALUES
(29, 'no', 0, 10),
(30, 'non lo so', 0.5, 10),
(31, 'si', 1, 10),
(32, 'no', 0, 11),
(33, 'non lo so', 0.5, 11),
(34, 'si', 1, 11),
(35, 'no', 0, 12),
(36, 'non lo so', 0.5, 12),
(37, 'si', 1, 12),
(38, 'no', 0, 13),
(39, 'non lo so', 0.5, 13),
(40, 'si', 1, 13),
(41, 'no', 0, 14),
(42, 'non lo so', 0.5, 14),
(43, 'si', 1, 14),
(44, 'no', 0, 15),
(45, 'non lo so', 0.5, 15),
(46, 'si', 1, 15),
(47, 'no', 0, 16),
(48, 'non lo so', 0.5, 16),
(49, 'si', 1, 16),
(50, 'no', 0, 17),
(51, 'non lo so', 0.5, 17),
(52, 'si', 1, 17),
(53, 'no', 0, 17),
(54, 'non lo so', 0.5, 17),
(55, 'si', 1, 17),
(56, 'no', 0, 19),
(57, 'non lo so', 0.5, 19),
(58, 'si', 1, 19),
(59, 'no', 0, 20),
(60, 'non lo so', 0.5, 20),
(61, 'si', 1, 20),
(62, 'no', 0, 21),
(63, 'non lo so', 0.5, 21),
(64, 'si', 1, 21),
(65, 'no', 0, 22),
(66, 'non lo so', 0.5, 22),
(67, 'si', 1, 22),
(68, 'no', 0, 23),
(69, 'non lo so', 0.2, 23),
(70, 'non molto', 0.4, 23),
(71, 'normale', 0.6, 23),
(72, 'molto', 0.8, 23),
(73, 'estremamente', 1, 23),
(74, 'regolarmente', 0, 24),
(75, 'non lo so', 0.2, 24),
(76, 'ricevute spesso', 0.4, 24),
(77, 'ricevute avvolte', 0.6, 24),
(78, 'raramente', 0.8, 24),
(79, 'mai ricevute', 1, 24),
(80, 'no', 0, 25),
(81, 'non lo so', 0.5, 25),
(82, 'si', 1, 25);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
