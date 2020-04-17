-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 17 Kwi 2020, 13:27
-- Wersja serwera: 10.4.11-MariaDB
-- Wersja PHP: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `discount_codes` (
  `id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `expires` date NOT NULL,
  `used` int(11) NOT NULL COMMENT '0-no 1-yes',
  `dish` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '[type,id]' CHECK (json_valid(`dish`))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `dish_sets` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `ingredients` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '[[type,id,amount],[type,id,amount]...]',
  `state` int(11) NOT NULL COMMENT '0-opened 1-blocked'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--INSERT INTO `dish_sets` (`id`, `name`, `ingredients`, `state`) VALUES
--(1, 'Zestaw 1', '[\r\n  {\r\n   \"type\":\"i\",\r\n   \"id\":\"1\",\r\n   \"amount\":\"14\"\r\n  },  \r\n  {\r\n   \"type\":\"i\",\r\n   \"id\":\"2\",\r\n   \"amount\":\"14\"\r\n  }\r\n]', 1),
--(2, 'Zestaw 2', '[\r\n{\"type\":\"i\",\"id\":\"3\",\"amount\":\"12\"}\r\n]', 0);

CREATE TABLE `ingredients` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--INSERT INTO `ingredients` (`id`, `name`, `price`) VALUES
--(2, 'burako', 11.22),
--(3, 'Sałata', 10);


CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `city` varchar(25) NOT NULL,
  `street` varchar(35) NOT NULL,
  `houseNumber` varchar(10) NOT NULL,
  `apartmentNumber` varchar(10) NOT NULL,
  `zipCode` text NOT NULL,
  `status` int(11) NOT NULL COMMENT '0-unseen 1-seen 2-pending 3-on delivery 4-delivered 5-cancelled',
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT '[[type,id,amount],...]' CHECK (json_valid(`items`)),
  `delivery` int(11) NOT NULL COMMENT '0-no 1-yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(30) NOT NULL,
  `password` text NOT NULL,
  `name` varchar(35) NOT NULL,
  `lastname` varchar(40) NOT NULL,
  `phone` varchar(9) NOT NULL,
  `question` varchar(150) NOT NULL,
  `answer` varchar(150) NOT NULL,
  `position` varchar(15) NOT NULL,
  `city` varchar(20) DEFAULT NULL,
  `street` varchar(35) DEFAULT NULL,
  `houseNumber` varchar(15) DEFAULT NULL,
  `apartmentNumber` varchar(15) DEFAULT NULL,
  `zipCode` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `users` (`id`, `login`, `password`, `name`, `lastname`, `phone`, `question`, `answer`, `position`, `city`, `street`, `houseNumber`, `apartmentNumber`, `zipCode`) VALUES
(1, 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'Admin', 'Admin', '000000000', 'Admin', 'd118d996e8ac4526198299b601d35d094e3f7771', 'pracownik', '', '', '', '', ''),

--INSERT INTO `users` (`id`, `login`, `password`, `name`, `lastname`, `phone`, `question`, `answer`, `position`, `city`, `street`, `houseNumber`, `apartmentNumber`, `zipCode`) VALUES
--(3, 'p', 'ab2467706ba38309fafcc9d86d79291eacbaaed1', 'R', 'A', 'A', 'Lala', '2ef345b5a1d455aa581fdc89beb3fc9f46584aed', 'klient', 'D', 'K', 'C', 'Z', 'E'),
--(4, 'a', 'e9d71f5ee7c92d6dc9e92ffdad17b8bd49418f98', 'aaa', 'a', 'asdasdasd', 'sasd', 'b1afc74a590467d15ab2c99b01e741043fa7561a', 'klient', 'b', 'd', 'e', 'k', 'a'),
--(5, 'b', 'e9d71f5ee7c92d6dc9e92ffdad17b8bd49418f98', 'b', 'b', 'b', 'b', 'e9d71f5ee7c92d6dc9e92ffdad17b8bd49418f98', 'pracownik', 'b', 'd', 'g', 'o', 'y'),
--(6, 'q', '22ea1c649c82946aa6e479e1ffd321e4a318b1b0', 'q', 'q', 'q', 'qwe', '22ea1c649c82946aa6e479e1ffd321e4a318b1b0', 'klient', '', '', '', '', '');

ALTER TABLE `discount_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`);


ALTER TABLE `dish_sets`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `ingredients`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);


ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);



ALTER TABLE `discount_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `dish_sets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


ALTER TABLE `ingredients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);


ALTER TABLE `discount_codes`
  ADD CONSTRAINT `discount_codes_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`);

ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
