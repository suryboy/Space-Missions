-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 02, 2024 at 10:00 PM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `spacemissions`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `create_costs`
--

CREATE TABLE `create_costs` (
  `id` int(11) NOT NULL,
  `metal_cost` int(11) DEFAULT NULL,
  `synthetics_cost` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `create_costs`
--

INSERT INTO `create_costs` (`id`, `metal_cost`, `synthetics_cost`) VALUES
(1, 3, 1),
(2, 0, 2),
(3, 2, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `main_base_inventory`
--

CREATE TABLE `main_base_inventory` (
  `id` int(11) NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `itemID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `main_base_inventory`
--

INSERT INTO `main_base_inventory` (`id`, `quantity`, `itemID`) VALUES
(1, 0, 1),
(2, 0, 2),
(3, 0, 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `main_base_resources`
--

CREATE TABLE `main_base_resources` (
  `id` int(11) NOT NULL,
  `water` int(11) DEFAULT NULL,
  `oxygen` int(11) DEFAULT NULL,
  `research` int(11) DEFAULT NULL,
  `money` int(11) DEFAULT NULL,
  `metals` int(11) DEFAULT NULL,
  `synthetics` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `main_base_resources`
--

INSERT INTO `main_base_resources` (`id`, `water`, `oxygen`, `research`, `money`, `metals`, `synthetics`) VALUES
(1, 0, 20, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `missions`
--

CREATE TABLE `missions` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `duration` int(11) NOT NULL,
  `current_duration` int(11) NOT NULL DEFAULT `duration`,
  `target` varchar(45) DEFAULT NULL,
  `on_going` tinyint(1) DEFAULT 1,
  `confirmed` tinyint(1) DEFAULT 0,
  `resource_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `missions_personnel`
--

CREATE TABLE `missions_personnel` (
  `id` int(11) NOT NULL,
  `miID` int(11) DEFAULT NULL,
  `peID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `mission_logs`
--

CREATE TABLE `mission_logs` (
  `id` int(11) NOT NULL,
  `mission_id` int(11) DEFAULT NULL,
  `log` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `names`
--

CREATE TABLE `names` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `names`
--

INSERT INTO `names` (`id`, `name`) VALUES
(1, 'Tamera Duffy'),
(2, 'Erma Moore'),
(3, 'Robt Bullock'),
(4, 'Marcel Hurst'),
(5, 'Carissa Castillo'),
(6, 'Dallas Bright'),
(7, 'Ester Smith'),
(8, 'Abram Bennett'),
(9, 'Dale Galloway'),
(10, 'Tracy Wilkins'),
(11, 'Sharlene Bautista'),
(12, 'Gloria Frey'),
(13, 'Shawn Booker'),
(14, 'Colette Camacho'),
(15, 'Morgan Black'),
(16, 'Hal Moses'),
(17, 'Hilario Burgess'),
(18, 'Emily Conner'),
(19, 'Carroll Blanchard'),
(20, 'Kenny Andrews'),
(21, 'Marlon Rosales'),
(22, 'Amanda Elliott'),
(23, 'Jerome Wade'),
(24, 'Damion Stewart'),
(25, 'Callie Barker'),
(26, 'Merle Clements'),
(27, 'Lacy Vasquez'),
(28, 'Isabelle Humphrey'),
(29, 'Melba Schroeder'),
(30, 'Nickolas Montgomery'),
(31, 'Laura Pitts'),
(32, 'Myrtle Archer'),
(33, 'Sallie Juarez'),
(34, 'Kerry Willis'),
(35, 'Myles Young'),
(36, 'Cassie Hale'),
(37, 'Leila Berg'),
(38, 'Ike Marsh'),
(39, 'Flossie Ayers'),
(40, 'Shana Graham'),
(41, 'Hollie Atkins'),
(42, 'Kirk Winters'),
(43, 'Tanner Harrington'),
(44, 'Autumn Zavala'),
(45, 'Emil Higgins'),
(46, 'Cynthia Wolfe'),
(47, 'Philip Daugherty'),
(48, 'Walton Vance'),
(49, 'Donnie Ho'),
(50, 'Kris Valentine'),
(51, 'Millard Burch'),
(52, 'Sean Valencia'),
(53, 'Esther Gilbert'),
(54, 'Woodrow Cherry'),
(55, 'Dina Middleton'),
(56, 'Jame Dennis'),
(57, 'Ofelia Doyle'),
(58, 'Mamie Peters'),
(59, 'Cherie Cameron'),
(60, 'Fidel Lara'),
(61, 'Dianna Wood'),
(62, 'Myra Duke'),
(63, 'Brice Leonard'),
(64, 'Lavonne Pace'),
(65, 'Rodrick Adams'),
(66, 'Cedric Watson'),
(67, 'Keri Mathews'),
(68, 'Isreal Young'),
(69, 'Victoria Vance'),
(70, 'Noe Gallagher'),
(71, 'Rafael Hood'),
(72, 'Blair Browning'),
(73, 'Fritz Thompson'),
(74, 'Brock Dominguez'),
(75, 'Cesar Patton'),
(76, 'Glen Valentine'),
(77, 'Harry Foley'),
(78, 'Matthew Cooke'),
(79, 'Cassie Pena'),
(80, 'Damien Bryant'),
(81, 'Dollie Roberson'),
(82, 'Margaret Lynn'),
(83, 'Rachel Bright'),
(84, 'Cody Hooper'),
(85, 'Frieda Fox'),
(86, 'Maxine Horne'),
(87, 'Crystal Serrano'),
(88, 'Darcy Sawyer'),
(89, 'Luigi Novak'),
(90, 'Byron Huerta'),
(91, 'Gary Neal'),
(92, 'Raul Lane'),
(93, 'Jodie Cardenas'),
(94, 'Gail Compton'),
(95, 'Glenn Fowler'),
(96, 'Roxanne Martin'),
(97, 'Omar Rush'),
(98, 'Laura Hanna'),
(99, 'Vickie Atkinson'),
(100, 'Terry Sanders');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `occupations`
--

CREATE TABLE `occupations` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `occupations`
--

INSERT INTO `occupations` (`id`, `name`, `description`) VALUES
(1, 'Miner', 'Professional miner'),
(2, 'Researcher', 'Professional researcher'),
(3, 'Soldier', 'Professional soldier');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `personnel`
--

CREATE TABLE `personnel` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `health` int(11) NOT NULL DEFAULT 100,
  `description` text NOT NULL DEFAULT 'Insert your description here',
  `age` int(11) DEFAULT NULL,
  `occupation` int(11) NOT NULL,
  `is_owned` tinyint(1) NOT NULL DEFAULT 0,
  `on_mission` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `personnel`
--

INSERT INTO `personnel` (`id`, `name`, `health`, `description`, `age`, `occupation`, `is_owned`, `on_mission`) VALUES
(1, 'Kapitan Pazur', 100, 'Insert your description here', 30, 1, 1, 0),
(2, 'Grzanczy', 100, 'Insert your description here', 31, 2, 1, 0),
(3, 'Underwood', 100, 'Insert your description here', 32, 3, 1, 0),
(4, 'Mr Crow', 100, 'Insert your description here', 33, 2, 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `research`
--

CREATE TABLE `research` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `is_owned` tinyint(1) DEFAULT 0,
  `cost` int(11) DEFAULT 100,
  `craftID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `research`
--

INSERT INTO `research` (`id`, `name`, `description`, `is_owned`, `cost`, `craftID`) VALUES
(1, 'Space Rover', 'speedy super car epic', 0, 100, 1),
(2, 'Unbreakable flask', 'the golden grail for researchers', 0, 100, 2),
(3, 'Aeralite', 'an alloy of diffrent materials that can be used for excavation and military', 0, 100, 3);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `resources`
--

CREATE TABLE `resources` (
  `id` int(11) NOT NULL,
  `water` int(11) DEFAULT 0,
  `oxygen` int(11) DEFAULT 0,
  `research` int(11) DEFAULT 0,
  `money` int(11) DEFAULT 0,
  `metals` int(11) DEFAULT 0,
  `synthetics` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `create_costs`
--
ALTER TABLE `create_costs`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `main_base_inventory`
--
ALTER TABLE `main_base_inventory`
  ADD PRIMARY KEY (`id`),
  ADD KEY `itemID` (`itemID`);

--
-- Indeksy dla tabeli `main_base_resources`
--
ALTER TABLE `main_base_resources`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `missions`
--
ALTER TABLE `missions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `resource_id` (`resource_id`);

--
-- Indeksy dla tabeli `missions_personnel`
--
ALTER TABLE `missions_personnel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `miID` (`miID`),
  ADD KEY `peID` (`peID`);

--
-- Indeksy dla tabeli `mission_logs`
--
ALTER TABLE `mission_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mission_id` (`mission_id`);

--
-- Indeksy dla tabeli `names`
--
ALTER TABLE `names`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `occupations`
--
ALTER TABLE `occupations`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `personnel`
--
ALTER TABLE `personnel`
  ADD PRIMARY KEY (`id`),
  ADD KEY `occupation` (`occupation`);

--
-- Indeksy dla tabeli `research`
--
ALTER TABLE `research`
  ADD PRIMARY KEY (`id`),
  ADD KEY `craftID` (`craftID`);

--
-- Indeksy dla tabeli `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `create_costs`
--
ALTER TABLE `create_costs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `main_base_inventory`
--
ALTER TABLE `main_base_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `main_base_resources`
--
ALTER TABLE `main_base_resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `missions`
--
ALTER TABLE `missions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `missions_personnel`
--
ALTER TABLE `missions_personnel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mission_logs`
--
ALTER TABLE `mission_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `names`
--
ALTER TABLE `names`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `occupations`
--
ALTER TABLE `occupations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personnel`
--
ALTER TABLE `personnel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `research`
--
ALTER TABLE `research`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `main_base_inventory`
--
ALTER TABLE `main_base_inventory`
  ADD CONSTRAINT `main_base_inventory_ibfk_1` FOREIGN KEY (`itemID`) REFERENCES `research` (`id`);

--
-- Constraints for table `missions`
--
ALTER TABLE `missions`
  ADD CONSTRAINT `missions_ibfk_1` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`id`);

--
-- Constraints for table `missions_personnel`
--
ALTER TABLE `missions_personnel`
  ADD CONSTRAINT `missions_personnel_ibfk_1` FOREIGN KEY (`miID`) REFERENCES `missions` (`id`),
  ADD CONSTRAINT `missions_personnel_ibfk_2` FOREIGN KEY (`peID`) REFERENCES `personnel` (`id`);

--
-- Constraints for table `mission_logs`
--
ALTER TABLE `mission_logs`
  ADD CONSTRAINT `mission_logs_ibfk_1` FOREIGN KEY (`mission_id`) REFERENCES `missions` (`id`);

--
-- Constraints for table `personnel`
--
ALTER TABLE `personnel`
  ADD CONSTRAINT `personnel_ibfk_1` FOREIGN KEY (`occupation`) REFERENCES `occupations` (`id`);

--
-- Constraints for table `research`
--
ALTER TABLE `research`
  ADD CONSTRAINT `research_ibfk_1` FOREIGN KEY (`craftID`) REFERENCES `create_costs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
