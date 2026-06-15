-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 12, 2026 at 11:23 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kuharski_recepti`
--

-- --------------------------------------------------------

--
-- Table structure for table `enote`
--

CREATE TABLE `enote` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ime` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

--
-- Dumping data for table `enote`
--

INSERT INTO `enote` (`id`, `ime`) VALUES
(1, 'kos'),
(2, 'g'),
(3, 'ml'),
(4, 'ščepec'),
(5, 'žlica'),
(6, 'malo');

-- --------------------------------------------------------

--
-- Table structure for table `kategorije`
--

CREATE TABLE `kategorije` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ime` varchar(100) NOT NULL,
  `opis` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

--
-- Dumping data for table `kategorije`
--

INSERT INTO `kategorije` (`id`, `ime`, `opis`) VALUES
(1, 'Juhe', 'Različne juhe'),
(2, 'Glavne jedi', 'Preprosti osnovni recepti'),
(3, 'Sladice', 'Sladke jedi'),
(4, 'Solate', 'različne solate');

-- --------------------------------------------------------

--
-- Table structure for table `komentarji`
--

CREATE TABLE `komentarji` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `vsebina` text NOT NULL,
  `datum` timestamp NOT NULL DEFAULT current_timestamp(),
  `uporabniki_id` bigint(20) UNSIGNED NOT NULL,
  `recepti_id` bigint(20) UNSIGNED NOT NULL,
  `ocena` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

--
-- Dumping data for table `komentarji`
--

INSERT INTO `komentarji` (`id`, `vsebina`, `datum`, `uporabniki_id`, `recepti_id`, `ocena`) VALUES
(1, 'super', '2026-06-07 17:23:10', 1, 1, 1),
(2, 'slabo', '2026-06-07 17:23:23', 1, 1, 6),
(4, 'za nič', '2026-06-08 17:49:37', 4, 1, 2),
(5, 'preveč vode', '2026-06-10 09:31:32', 5, 3, 8);

-- --------------------------------------------------------

--
-- Table structure for table `recepti`
--

CREATE TABLE `recepti` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ime` varchar(255) NOT NULL,
  `postopek` text NOT NULL,
  `cas_priprave` int(11) DEFAULT NULL,
  `zahtevnost` varchar(50) NOT NULL,
  `kategorije_id` bigint(20) UNSIGNED NOT NULL,
  `uporabniki_id` bigint(20) UNSIGNED DEFAULT NULL,
  `datum_objave` timestamp NOT NULL DEFAULT current_timestamp(),
  `st_oseb` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

--
-- Dumping data for table `recepti`
--

INSERT INTO `recepti` (`id`, `ime`, `postopek`, `cas_priprave`, `zahtevnost`, `kategorije_id`, `uporabniki_id`, `datum_objave`, `st_oseb`) VALUES
(1, 'Umešana jajca', 'Jajca ubij v skledo. Dodaj sol, poper in mleko. Vse dobro premešaj z vilico. Na ponvi segrej malo masla ali olja. Vlij jajca v ponev. Mešaj na srednji temperaturi, dokler jajca niso pečena. Postrezi s kruhom.', 10, 'Lahko', 2, NULL, '2026-06-07 10:06:27', 1),
(2, 'Palačinke', 'V skledo daj jajci, mleko, moko, sol in sladkor. Vse dobro zmešaj, da dobiš gladko maso. Maso pusti stati približno 10 minut. Ponev segrej in jo namaži z malo olja. Vlij malo mase in jo razlij po ponvi. Palačinko peci približno 1 minuto na eni strani, nato jo obrni. Ko je pečena, jo namaži z marmelado, čokolado ali drugim nadevom.', 30, 'Srednje', 3, NULL, '2026-06-07 10:06:27', 4),
(3, 'Goveja juha', 'Meso in kosti daj v velik lonec. Dodaj približno 2 litra hladne vode. Juho počasi segrevaj do vretja. Ko se naredi pena, jo odstrani z žlico. Dodaj korenček, čebulo, zeleno, peteršiljevo korenino, sol in poper. Juha naj počasi vre približno 2 uri. Ko je kuhana, jo precedi. Posebej skuhaj rezance ali jušne testenine. Juho postrezi z rezanci, korenčkom in peteršiljem.', 120, 'Srednje', 1, NULL, '2026-06-07 10:06:27', 4),
(4, 'Paradiznikova juha', 'Na olju prepraži čebulo, dodaj paradižnik, vodo, sol in poper. Kuhaj približno 25 minut, nato juho zmešaj s paličnim mešalnikom.', 35, 'Lahko', 1, NULL, '2026-06-08 15:57:36', 4),
(5, 'Gobova juha', 'Gobe očisti in nareži. Prepraži čebulo, dodaj gobe, začimbe in vodo. Kuhaj, dokler se gobe ne zmehčajo.', 40, 'Lahko', 1, NULL, '2026-06-08 15:57:36', 4),
(6, 'Zelenjavna juha', 'Zelenjavo nareži na koščke, dodaj v lonec z vodo, posoli in kuhaj približno 30 minut.', 35, 'Lahko', 1, NULL, '2026-06-08 15:57:36', 4),
(7, 'Krompirjeva juha', 'Krompir olupi in nareži. Dodaj čebulo, korenček, vodo in začimbe. Kuhaj, dokler krompir ni mehak.', 40, 'Lahko', 1, NULL, '2026-06-08 15:57:36', 4),
(8, 'Bučna juha', 'Bučo nareži, dodaj čebulo, vodo in začimbe. Kuhaj do mehkega in zmešaj v kremno juho.', 35, 'Lahko', 1, NULL, '2026-06-08 15:57:36', 4),
(9, 'Fizolova juha', 'Fižol skuhaj z zelenjavo in začimbami. Del juhe pretlači, da postane gostejša.', 90, 'Lahko', 1, NULL, '2026-06-08 15:57:36', 4),
(10, 'Piscancja juha', 'Piščanca kuhaj z zelenjavo, soljo in poprom. Juho precedi in postrezi z rezanci.', 80, 'Lahko', 1, NULL, '2026-06-08 15:57:36', 4),
(11, 'Česnova juha', 'Na olju rahlo prepraži česen, dodaj vodo ali jušno osnovo, začini in kuhaj nekaj minut.', 25, 'Lahko', 1, NULL, '2026-06-08 15:57:36', 2),
(12, 'Pecen piscancji file', 'Piscancji file posoli in popopraj. V ponvi segrej malo olja in meso peci na obeh straneh, dokler ni lepo zapeceno. Postrezi s krompirjem ali rizem.', 35, 'Lahko', 2, NULL, '2026-06-08 16:31:07', 2),
(13, 'Spageti bolognese', 'Cebulo preprazi na olju, dodaj mleto meso in ga popeci. Dodaj paradiznikovo omako, sol in zacimbe ter kuhaj priblizno 30 minut. Posebej skuhaj spagete in jih postrezi z omako.', 45, 'Lahko', 2, NULL, '2026-06-08 16:31:07', 4),
(14, 'Rizota z zelenjavo', 'Na olju preprazi cebulo, dodaj riz in zelenjavo. Postopoma dolivaj vodo ali juho in mesaj, dokler riz ni kuhan. Na koncu dodaj malo masla.', 40, 'Lahko', 2, NULL, '2026-06-08 16:31:07', 3),
(15, 'Pecen krompir z mesom', 'Krompir narezi na kose, meso zacinis s soljo in poprom. Vse skupaj daj v pekac, dodaj malo olja in peci v pecici, dokler ni meso mehko in krompir zapecen.', 70, 'Lahko', 2, NULL, '2026-06-08 16:31:07', 4),
(16, 'Dunajski zrezek', 'Zrezke potolci, posoli in jih povaljaj v moki, jajcu in drobtinah. Ocvri jih v vrocem olju do zlate barve. Postrezi z limono in krompirjem.', 40, 'Lahko', 2, NULL, '2026-06-08 16:31:07', 2),
(17, 'Testenine s sirom', 'Testenine skuhaj v slani vodi. V ponvi segrej malo mleka, dodaj sir in mesaj, da nastane omaka. Testenine zmesaj z omako in postrezi.', 25, 'Lahko', 2, NULL, '2026-06-08 16:31:07', 2),
(18, 'Polnjene paprike', 'Paprike ocisti. Mleto meso zmesaj z rizem, soljo in zacimbami ter napolni paprike. Kuhaj jih v paradiznikovi omaki, dokler niso mehke.', 90, 'Lahko', 2, NULL, '2026-06-08 16:31:07', 4),
(19, 'Ribji file z zelenjavo', 'Ribji file posoli in pokapaj z limono. Peci ga v ponvi ali pecici. Zraven pripravi kuhano ali peceno zelenjavo.', 30, 'Lahko', 2, NULL, '2026-06-08 16:31:07', 2),
(20, 'Jabolcni zavitek', 'Jabolka naribaj in jih zmesaj s sladkorjem ter cimetom. Nadev razporedi po testu, zavij in peci v pecici, dokler zavitek ni zlatorumen.', 60, 'Lahko', 3, NULL, '2026-06-08 16:33:25', 6),
(21, 'Cokoladni mafini', 'V eni skledi zmesaj suhe sestavine, v drugi jajca, mleko in olje. Vse skupaj zmesaj, dodaj cokolado in peci v modelckih.', 30, 'Lahko', 3, NULL, '2026-06-08 16:33:25', 6),
(22, 'Sadna kupa', 'Sadje narezi na manjse kose in ga razporedi v posodice. Dodaj jogurt, smetano ali kepico sladoleda.', 15, 'Lahko', 3, NULL, '2026-06-08 16:33:25', 4),
(23, 'Tiramisu', 'Pi?kote namoci v kavo. V posodi pripravi kremo iz mascarponeja, sladkorja in smetane. Plasti piskotov in kreme zlozi v posodo ter ohladi.', 45, 'Lahko', 3, NULL, '2026-06-08 16:33:25', 6),
(24, 'Piskoti z marmelado', 'Iz sestavin zgneti testo, oblikuj piskote in jih speci. Ko se ohladijo, jih namazi z marmelado in zlepi po dva skupaj.', 50, 'Lahko', 3, NULL, '2026-06-08 16:33:25', 8),
(25, 'Vanilijev puding', 'Puding v prahu zmesaj z malo mleka in sladkorjem. Ostalo mleko zavri, dodaj zmes in kuhaj, dokler se ne zgosti.', 15, 'Lahko', 3, NULL, '2026-06-08 16:33:25', 4),
(26, 'Skutina torta', 'Pi?kotno dno pripravi iz zdrobljenih piskotov in masla. Skuto zmesaj s sladkorjem in smetano, nadev razporedi po dnu in ohladi.', 70, 'Lahko', 3, NULL, '2026-06-08 16:33:25', 8),
(27, 'Banane s cokolado', 'Banane narezi in jih prelij s stopljeno cokolado. Po zelji dodaj orehe, smetano ali kokos.', 15, 'Lahko', 3, NULL, '2026-06-08 16:33:25', 2),
(28, 'Mesana solata', 'Solato operi in narezi. Dodaj paradiznik, kumaro, papriko, sol, kis in olje ter dobro premesaj.', 15, 'Lahko', 4, NULL, '2026-06-08 16:33:25', 2),
(29, 'Sopska solata', 'Paradiznik, kumaro in papriko narezi na kocke. Dodaj cebulo, sol in olje, na vrh pa naribaj sir.', 20, 'Lahko', 4, NULL, '2026-06-08 16:33:25', 3),
(30, 'Cezarjeva solata', 'Solato narezi, dodaj pecen piscancji file, kruhove kocke in preliv. Na koncu potresi s sirom.', 30, 'Lahko', 4, NULL, '2026-06-08 16:33:25', 2),
(31, 'Krompirjeva solata', 'Krompir skuhaj, olupi in narezi. Dodaj cebulo, kis, olje, sol in malo vode ter premesaj.', 40, 'Lahko', 4, NULL, '2026-06-08 16:33:25', 4),
(32, 'Testeninska solata', 'Testenine skuhaj in ohladi. Dodaj zelenjavo, sir, sunko ali tuno ter preliv po zelji.', 30, 'Lahko', 4, NULL, '2026-06-08 16:33:25', 4),
(33, 'Tuna solata', 'V skledo daj tuno, koruzo, fizol, cebulo in zeleno solato. Dodaj sol, poper, olje in limonin sok.', 20, 'Lahko', 3, NULL, '2026-06-08 16:33:25', 2),
(34, 'Grška solata', 'Kumaro, paradiznik, cebulo in papriko narezi. Dodaj olive, feta sir, sol in olivno olje.', 20, 'Lahko', 4, NULL, '2026-06-08 16:33:25', 3),
(35, 'Zeljna solata', 'Zelje na tanko narezi, posoli in malo pregneti. Dodaj kis, olje in poper ter premesaj.', 15, 'Lahko', 4, NULL, '2026-06-08 16:33:25', 4);

-- --------------------------------------------------------

--
-- Table structure for table `recepti_sestavine`
--

CREATE TABLE `recepti_sestavine` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kolicina` varchar(50) NOT NULL,
  `recepti_id` bigint(20) UNSIGNED NOT NULL,
  `sestavine_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

--
-- Dumping data for table `recepti_sestavine`
--

INSERT INTO `recepti_sestavine` (`id`, `kolicina`, `recepti_id`, `sestavine_id`) VALUES
(1, '2-3', 1, 1),
(2, 'ščepec', 1, 2),
(3, 'malo', 1, 3),
(4, '1', 1, 4),
(5, 'malo', 1, 5),
(6, '2', 2, 1),
(7, '250', 2, 6),
(8, '500', 2, 7),
(9, 'ščepec', 2, 2),
(10, '1', 2, 8),
(11, 'malo', 2, 9),
(12, '500', 3, 10),
(13, '1-2', 3, 11),
(14, '2', 3, 12),
(15, '1', 3, 13),
(16, 'košček', 3, 14),
(17, 'košček', 3, 15),
(18, 'malo', 3, 16),
(19, 'malo', 3, 2),
(20, 'malo', 3, 17),
(21, '2000', 3, 18),
(22, 'malo', 3, 19),
(23, '500', 4, 20),
(24, '1', 4, 21),
(25, '500', 4, 22),
(26, 'malo', 4, 23),
(27, '300', 5, 24),
(28, '1', 5, 25),
(29, '500', 5, 26),
(30, 'malo', 5, 27),
(31, '2', 6, 28),
(32, '1', 6, 29),
(33, '1', 6, 30),
(34, '1000', 6, 31),
(35, '4', 7, 32),
(36, '1', 7, 33),
(37, '700', 7, 34),
(38, 'malo', 7, 35),
(39, '500', 8, 36),
(40, '1', 8, 37),
(41, '500', 8, 38),
(42, 'malo', 8, 39),
(43, '300', 9, 40),
(44, '1', 9, 41),
(45, '1', 9, 42),
(46, '1000', 9, 43),
(47, '300', 10, 44),
(48, '1', 10, 45),
(49, '1000', 10, 46),
(50, 'malo', 10, 47),
(51, '5', 11, 48),
(52, '500', 11, 49),
(53, '1', 11, 50),
(54, 'malo', 11, 51),
(55, '2', 12, 52),
(56, 'malo', 12, 53),
(57, 'malo', 12, 54),
(58, '1', 12, 55),
(59, '400', 13, 56),
(60, '300', 13, 57),
(61, '1', 13, 58),
(62, '400', 13, 59),
(63, '300', 14, 60),
(64, '300', 14, 61),
(65, '1', 14, 62),
(66, '700', 14, 63),
(67, '600', 15, 64),
(68, '400', 15, 65),
(69, '1', 15, 66),
(70, 'malo', 15, 67),
(71, '2', 16, 68),
(72, '100', 16, 69),
(73, '2', 16, 70),
(74, '150', 16, 71),
(75, '300', 17, 72),
(76, '200', 17, 73),
(77, '100', 17, 74),
(78, 'malo', 17, 75),
(79, '4', 18, 76),
(80, '300', 18, 77),
(81, '100', 18, 78),
(82, '400', 18, 79),
(83, '2', 19, 80),
(84, '300', 19, 81),
(85, '1', 19, 82),
(86, 'malo', 19, 83),
(87, '5', 20, 84),
(88, '1', 20, 85),
(89, '2', 20, 86),
(90, 'malo', 20, 87),
(91, '250', 21, 88),
(92, '2', 21, 89),
(93, '100', 21, 90),
(94, '100', 21, 91),
(95, '500', 22, 92),
(96, '200', 22, 93),
(97, '1', 22, 94),
(98, 'malo', 22, 95),
(99, '200', 23, 96),
(100, '250', 23, 97),
(101, '200', 23, 98),
(102, '2', 23, 99),
(103, '300', 24, 100),
(104, '150', 24, 101),
(105, '100', 24, 102),
(106, 'malo', 24, 103),
(107, '1', 25, 104),
(108, '500', 25, 105),
(109, '2', 25, 106),
(110, 'malo', 25, 107),
(111, '300', 26, 108),
(112, '200', 26, 109),
(113, '100', 26, 110),
(114, '2', 26, 111),
(115, '2', 27, 112),
(116, '100', 27, 113),
(117, 'malo', 27, 114),
(118, 'malo', 27, 115),
(119, '1', 28, 116),
(120, '2', 28, 117),
(121, '1', 28, 118),
(122, 'malo', 28, 119),
(123, '2', 29, 120),
(124, '1', 29, 121),
(125, '1', 29, 122),
(126, '100', 29, 123),
(127, '1', 30, 124),
(128, '200', 30, 125),
(129, '50', 30, 126),
(130, 'malo', 30, 127),
(131, '500', 31, 128),
(132, '1', 31, 129),
(133, 'malo', 31, 130),
(134, 'malo', 31, 131),
(135, '300', 32, 132),
(136, '200', 32, 133),
(137, '100', 32, 134),
(138, 'malo', 32, 135),
(139, '1', 33, 136),
(140, '100', 33, 137),
(141, '100', 33, 138),
(142, 'malo', 33, 139),
(143, '1', 34, 140),
(144, '2', 34, 141),
(145, '100', 34, 142),
(146, 'malo', 34, 143),
(147, '500', 35, 144),
(148, 'malo', 35, 145),
(149, 'malo', 35, 146),
(150, 'malo', 35, 147);

-- --------------------------------------------------------

--
-- Table structure for table `sestavine`
--

CREATE TABLE `sestavine` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ime` varchar(100) NOT NULL,
  `opis` varchar(255) DEFAULT NULL,
  `enote_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

--
-- Dumping data for table `sestavine`
--

INSERT INTO `sestavine` (`id`, `ime`, `opis`, `enote_id`) VALUES
(1, 'jajca', '', 1),
(2, 'sol', '', 4),
(3, 'poper', '', 6),
(4, 'mleko ali smetana', '', 5),
(5, 'maslo ali olje', '', 6),
(6, 'moka', '', 2),
(7, 'mleko', '', 3),
(8, 'sladkor', '', 5),
(9, 'olje za peko', '', 6),
(10, 'goveje meso', '', 2),
(11, 'goveji kosti', '', 1),
(12, 'korenček', '', 1),
(13, 'čebula', '', 1),
(14, 'zelena', '', 6),
(15, 'peteršiljeva korenina', '', 6),
(16, 'peteršilj', '', 6),
(17, 'poper v zrnu', '', 6),
(18, 'voda', '', 3),
(19, 'jušne testenine ali rezanci', '', 6),
(20, 'paradiznik', '', 2),
(21, 'cebula', '', 1),
(22, 'voda', '', 3),
(23, 'sol', '', 6),
(24, 'gobe', '', 2),
(25, 'cebula', '', 1),
(26, 'voda', '', 3),
(27, 'sol', '', 6),
(28, 'korenje', '', 1),
(29, 'krompir', '', 1),
(30, 'cebula', '', 1),
(31, 'voda', '', 3),
(32, 'krompir', '', 1),
(33, 'cebula', '', 1),
(34, 'voda', '', 3),
(35, 'sol', '', 6),
(36, 'buca', '', 2),
(37, 'cebula', '', 1),
(38, 'voda', '', 3),
(39, 'sol', '', 6),
(40, 'fizol', '', 2),
(41, 'cebula', '', 1),
(42, 'korenje', '', 1),
(43, 'voda', '', 3),
(44, 'piscancje meso', '', 2),
(45, 'korenje', '', 1),
(46, 'voda', '', 3),
(47, 'sol', '', 6),
(48, 'cesen', '', 1),
(49, 'voda', '', 3),
(50, 'jajce', '', 1),
(51, 'sol', '', 6),
(52, 'piscancji file', '', 1),
(53, 'sol', '', 6),
(54, 'poper', '', 6),
(55, 'olje', '', 5),
(56, 'spageti', '', 2),
(57, 'mleto meso', '', 2),
(58, 'cebula', '', 1),
(59, 'paradiznikova omaka', '', 3),
(60, 'riz', '', 2),
(61, 'zelenjava', '', 2),
(62, 'cebula', '', 1),
(63, 'voda', '', 3),
(64, 'krompir', '', 2),
(65, 'meso', '', 2),
(66, 'olje', '', 5),
(67, 'sol', '', 6),
(68, 'zrezek', '', 1),
(69, 'moka', '', 2),
(70, 'jajce', '', 1),
(71, 'drobtine', '', 2),
(72, 'testenine', '', 2),
(73, 'sir', '', 2),
(74, 'mleko', '', 3),
(75, 'sol', '', 6),
(76, 'paprika', '', 1),
(77, 'mleto meso', '', 2),
(78, 'riz', '', 2),
(79, 'paradiznikova omaka', '', 3),
(80, 'ribji file', '', 1),
(81, 'zelenjava', '', 2),
(82, 'limona', '', 1),
(83, 'sol', '', 6),
(84, 'jabolko', '', 1),
(85, 'testo', '', 1),
(86, 'sladkor', '', 5),
(87, 'cimet', '', 6),
(88, 'moka', '', 2),
(89, 'jajce', '', 1),
(90, 'sladkor', '', 2),
(91, 'cokolada', '', 2),
(92, 'sadje', '', 2),
(93, 'jogurt', '', 3),
(94, 'sladkor', '', 5),
(95, 'smetana', '', 6),
(96, 'piskoti', '', 2),
(97, 'mascarpone', '', 2),
(98, 'kava', '', 3),
(99, 'sladkor', '', 5),
(100, 'moka', '', 2),
(101, 'maslo', '', 2),
(102, 'sladkor', '', 2),
(103, 'marmelada', '', 6),
(104, 'puding v prahu', '', 1),
(105, 'mleko', '', 3),
(106, 'sladkor', '', 5),
(107, 'smetana', '', 6),
(108, 'skuta', '', 2),
(109, 'piskoti', '', 2),
(110, 'maslo', '', 2),
(111, 'sladkor', '', 5),
(112, 'banana', '', 1),
(113, 'cokolada', '', 2),
(114, 'kokos', '', 6),
(115, 'smetana', '', 6),
(116, 'solata', '', 1),
(117, 'paradiznik', '', 1),
(118, 'kumara', '', 1),
(119, 'olje', '', 6),
(120, 'paradiznik', '', 1),
(121, 'kumara', '', 1),
(122, 'paprika', '', 1),
(123, 'sir', '', 2),
(124, 'solata', '', 1),
(125, 'piscancji file', '', 2),
(126, 'kruhove kocke', '', 2),
(127, 'preliv', '', 6),
(128, 'krompir', '', 2),
(129, 'cebula', '', 1),
(130, 'kis', '', 6),
(131, 'olje', '', 6),
(132, 'testenine', '', 2),
(133, 'zelenjava', '', 2),
(134, 'sir', '', 2),
(135, 'preliv', '', 6),
(136, 'tuna', '', 1),
(137, 'koruza', '', 2),
(138, 'fizol', '', 2),
(139, 'limonin sok', '', 6),
(140, 'kumara', '', 1),
(141, 'paradiznik', '', 1),
(142, 'feta sir', '', 2),
(143, 'olive', '', 6),
(144, 'zelje', '', 2),
(145, 'kis', '', 6),
(146, 'olje', '', 6),
(147, 'sol', '', 6),
(148, 'kruh', '', 1),
(149, 'salam', '', 1),
(150, 'sir', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `shranjeni_recepti`
--

CREATE TABLE `shranjeni_recepti` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `datum` timestamp NOT NULL DEFAULT current_timestamp(),
  `uporabniki_id` bigint(20) UNSIGNED NOT NULL,
  `recepti_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

--
-- Dumping data for table `shranjeni_recepti`
--

INSERT INTO `shranjeni_recepti` (`id`, `datum`, `uporabniki_id`, `recepti_id`) VALUES
(4, '2026-06-11 20:21:34', 2, 18),
(5, '2026-06-12 08:38:30', 5, 20);

-- --------------------------------------------------------

--
-- Table structure for table `slike`
--

CREATE TABLE `slike` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ime` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `recepti_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

--
-- Dumping data for table `slike`
--

INSERT INTO `slike` (`id`, `ime`, `url`, `recepti_id`) VALUES
(1, 'Umešana jajca', 'slike/umesana_jajca_slika.png', 1),
(2, 'Palačinke', 'slike/palacinke_slika.png', 2),
(3, 'Goveja juha', 'slike/goveja_juha_slika.png', 3),
(4, 'Bucna juha', 'slike/Posnetek zaslona 2026-06-08 181101.png', 8),
(5, 'Cesnova juha', 'slike/Posnetek zaslona 2026-06-08 182044.png', 11),
(6, 'Fizolova juha', 'slike/Posnetek zaslona 2026-06-08 182141.png', 9),
(7, 'Gobova juha', 'slike/Posnetek zaslona 2026-06-08 182245.png', 5),
(8, 'Krompirjeva juha', 'slike/Posnetek zaslona 2026-06-08 182346.png', 7),
(9, 'Paradiznikova juha', 'slike/Posnetek zaslona 2026-06-08 182433.png', 4),
(10, 'Piscancja juha', 'slike/Posnetek zaslona 2026-06-08 182506.png', 10),
(11, 'Zelenjavna juha', 'slike/Posnetek zaslona 2026-06-08 182536.png', 6),
(12, 'Banane s cokolado', 'slike/Posnetek zaslona 2026-06-10 113532.png', 27),
(13, 'Cezarjeva solata', 'slike/Posnetek zaslona 2026-06-10 113744.png', 30),
(14, 'Cokoladni mafini', 'slike/Posnetek zaslona 2026-06-10 113830.png', 21),
(15, 'Dunajski zrezek', 'slike/Posnetek zaslona 2026-06-10 114518.png', 16),
(16, 'Grška solata', 'slike/Posnetek zaslona 2026-06-10 114604.png', 34),
(17, 'Jabolcni zavitek', 'slike/Posnetek zaslona 2026-06-10 114752.png', 20),
(18, 'Krompirjeva solata', 'slike/Posnetek zaslona 2026-06-10 114830.png', 31),
(19, 'Mesana solata', 'slike/Posnetek zaslona 2026-06-10 115205.png', 28),
(20, 'Pecen krompir z mesom', 'slike/Posnetek zaslona 2026-06-10 115439.png', 15),
(21, 'Pecen piscancji file', 'slike/Posnetek zaslona 2026-06-10 115517.png', 12),
(22, 'Piskoti z marmelado', 'slike/Posnetek zaslona 2026-06-10 115710.png', 24),
(23, 'Polnjene paprike', 'slike/Posnetek zaslona 2026-06-10 115747.png', 18),
(24, 'Ribji file z zelenjavo', 'slike/Posnetek zaslona 2026-06-10 115844.png', 19),
(25, 'Rizota z zelenjavo', 'slike/Posnetek zaslona 2026-06-10 115918.png', 14),
(26, 'Sadna kupa', 'slike/Posnetek zaslona 2026-06-10 120059.png', 22),
(27, 'Skutina torta', 'slike/Posnetek zaslona 2026-06-10 120157.png', 26),
(28, 'Tuna solata', 'slike/Posnetek zaslona 2026-06-10 120253.png', 33),
(29, 'Sopska solata', 'slike/Posnetek zaslona 2026-06-10 120334.png', 29),
(30, 'Spageti bolognese', 'slike/Posnetek zaslona 2026-06-10 120406.png', 13),
(31, 'Testenine s sirom', 'slike/Posnetek zaslona 2026-06-10 120444.png', 17),
(32, 'Testeninska solata', 'slike/Posnetek zaslona 2026-06-10 120516.png', 32),
(33, 'Tiramisu', 'slike/Posnetek zaslona 2026-06-10 120539.png', 23),
(34, 'Vanilijev puding', 'slike/Posnetek zaslona 2026-06-10 120633.png', 25),
(35, 'Zeljna solata', 'slike/Posnetek zaslona 2026-06-10 120717.png', 35);

-- --------------------------------------------------------

--
-- Table structure for table `uporabniki`
--

CREATE TABLE `uporabniki` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `ime` varchar(100) NOT NULL,
  `priimek` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `geslo` varchar(255) NOT NULL,
  `datum_registracije` timestamp NOT NULL DEFAULT current_timestamp(),
  `vloga` varchar(50) NOT NULL DEFAULT 'uporabnik'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_slovenian_ci;

--
-- Dumping data for table `uporabniki`
--

INSERT INTO `uporabniki` (`id`, `ime`, `priimek`, `email`, `geslo`, `datum_registracije`, `vloga`) VALUES
(1, 'Luka', 'Meža', 'luka@email.com', '1234', '2026-06-07 10:06:26', 'uporabnik'),
(2, 'admin', 'lastnik', 'admin@admin', '$2y$10$.XBEZGxBDc9In.1OWVJyQernTjrewSLI1OL/cNgN9MsNI1MX0tpma', '2026-06-08 15:33:05', 'admin'),
(4, 'matija', 'matija', 'matija.meza1@gmail.com', '$2y$10$J26gpQi4tarjofswifkwp.kl9Pv/f9hp.Jeyk3H4tK6Nfj26N5WfS', '2026-06-08 17:48:31', 'uporabnik'),
(5, 'Luka', 'Meža', 'luka.meza12@gmail.com', '$2y$10$FwmVc25zkrOSm8dM7j8iI.E37V008WU9OV3vpoU77fTOA0uC.vJ8G', '2026-06-10 09:28:14', 'uporabnik');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `enote`
--
ALTER TABLE `enote`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategorije`
--
ALTER TABLE `kategorije`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `komentarji`
--
ALTER TABLE `komentarji`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uporabniki_id` (`uporabniki_id`),
  ADD KEY `recepti_id` (`recepti_id`);

--
-- Indexes for table `recepti`
--
ALTER TABLE `recepti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kategorije_id` (`kategorije_id`),
  ADD KEY `uporabniki_id` (`uporabniki_id`);

--
-- Indexes for table `recepti_sestavine`
--
ALTER TABLE `recepti_sestavine`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recepti_id` (`recepti_id`),
  ADD KEY `sestavine_id` (`sestavine_id`);

--
-- Indexes for table `sestavine`
--
ALTER TABLE `sestavine`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enote_id` (`enote_id`);

--
-- Indexes for table `shranjeni_recepti`
--
ALTER TABLE `shranjeni_recepti`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uporabniki_id` (`uporabniki_id`),
  ADD KEY `recepti_id` (`recepti_id`);

--
-- Indexes for table `slike`
--
ALTER TABLE `slike`
  ADD PRIMARY KEY (`id`),
  ADD KEY `recepti_id` (`recepti_id`);

--
-- Indexes for table `uporabniki`
--
ALTER TABLE `uporabniki`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `enote`
--
ALTER TABLE `enote`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `kategorije`
--
ALTER TABLE `kategorije`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `komentarji`
--
ALTER TABLE `komentarji`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `recepti`
--
ALTER TABLE `recepti`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `recepti_sestavine`
--
ALTER TABLE `recepti_sestavine`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT for table `sestavine`
--
ALTER TABLE `sestavine`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=151;

--
-- AUTO_INCREMENT for table `shranjeni_recepti`
--
ALTER TABLE `shranjeni_recepti`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `slike`
--
ALTER TABLE `slike`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `uporabniki`
--
ALTER TABLE `uporabniki`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `komentarji`
--
ALTER TABLE `komentarji`
  ADD CONSTRAINT `komentarji_ibfk_1` FOREIGN KEY (`uporabniki_id`) REFERENCES `uporabniki` (`id`),
  ADD CONSTRAINT `komentarji_ibfk_2` FOREIGN KEY (`recepti_id`) REFERENCES `recepti` (`id`);

--
-- Constraints for table `recepti`
--
ALTER TABLE `recepti`
  ADD CONSTRAINT `recepti_ibfk_1` FOREIGN KEY (`kategorije_id`) REFERENCES `kategorije` (`id`),
  ADD CONSTRAINT `recepti_ibfk_2` FOREIGN KEY (`uporabniki_id`) REFERENCES `uporabniki` (`id`);

--
-- Constraints for table `recepti_sestavine`
--
ALTER TABLE `recepti_sestavine`
  ADD CONSTRAINT `recepti_sestavine_ibfk_1` FOREIGN KEY (`recepti_id`) REFERENCES `recepti` (`id`),
  ADD CONSTRAINT `recepti_sestavine_ibfk_2` FOREIGN KEY (`sestavine_id`) REFERENCES `sestavine` (`id`);

--
-- Constraints for table `sestavine`
--
ALTER TABLE `sestavine`
  ADD CONSTRAINT `sestavine_ibfk_1` FOREIGN KEY (`enote_id`) REFERENCES `enote` (`id`);

--
-- Constraints for table `shranjeni_recepti`
--
ALTER TABLE `shranjeni_recepti`
  ADD CONSTRAINT `shranjeni_recepti_ibfk_1` FOREIGN KEY (`uporabniki_id`) REFERENCES `uporabniki` (`id`),
  ADD CONSTRAINT `shranjeni_recepti_ibfk_2` FOREIGN KEY (`recepti_id`) REFERENCES `recepti` (`id`);

--
-- Constraints for table `slike`
--
ALTER TABLE `slike`
  ADD CONSTRAINT `slike_ibfk_1` FOREIGN KEY (`recepti_id`) REFERENCES `recepti` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
