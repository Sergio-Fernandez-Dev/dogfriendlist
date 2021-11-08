
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+02:00";

DROP DATABASE IF EXISTS `dogfriendlist`;

CREATE DATABASE `dogfriendlist` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `dogfriendlist`;

-- Estructura de la tabla `Users`

CREATE TABLE `Users` (
  `id` INT(8) NOT NULL UNIQUE,
  `nickname` VARCHAR(15) NOT NULL UNIQUE,
  `email` VARCHAR(50) NOT NULL UNIQUE,
  `visibility` INT(1) NOT NULL DEFAULT 1,
  `city` VARCHAR(50) DEFAULT NULL,
  `country` VARCHAR(50) DEFAULT NULL,
  `name` VARCHAR(25) DEFAULT NULL,
  `surname` VARCHAR(50) DEFAULT NULL,
  `img` VARCHAR(255) NOT NULL DEFAULT 'users/common/default-profile-picture.jpg',
  `about_me` TEXT(350) DEFAULT NULL,
  `password` VARCHAR(64) NOT NULL,
  `role` INT(1) NOT NULL DEFAULT 0,
  `activation_key` VARCHAR(64) DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Estructura de la tabla `Spots`

CREATE TABLE `Spots` (
  `id` INT(8) NOT NULL UNIQUE,
  `title` VARCHAR(25) NOT NULL UNIQUE,
  `description` TEXT(500) NOT NULL,
  `address` VARCHAR(125)CHARACTER SET cp1250 COLLATE cp1250_bin DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` INT(8) NOT NULL,
  `category_id` INT(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Estructura de la tabla `Categories`

CREATE TABLE `Categories` (
  `id` INT(8) NOT NULL,
  `name` VARCHAR(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Estructura de la tabla `Comments`

CREATE TABLE `Comments` (
  `id` INT(8) NOT NULL,
  `title` VARCHAR(25) NOT NULL,
  `comment` TEXT(500) NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` INT(8) NOT NULL,
  `spot_id` INT(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Estructura de la tabla `Coordinates`

CREATE TABLE `Coordinates` (
  `spot_id` INT(8) NOT NULL,
  `long` DECIMAL(6,3) NOT NULL,
  `lat` DECIMAL(6,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Estructura de la tabla `Ratings`

CREATE TABLE `Ratings` (
  `user_id` INT(8) NOT NULL,
  `spot_id` INT(8) NOT NULL,
  `valuation` TINYINT(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Estructura de la tabla `Favourites`

CREATE TABLE `Favourites` (
  `user_id` INT(8) NOT NULL,
  `spot_id` INT(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Estructura de la tabla `Pictures`

CREATE TABLE `Pictures` (
  `id` INT(8) NOT NULL,
  `img` VARCHAR(255) DEFAULT 'spots/common/default-spot-picture.jpg',
  `user_id` INT(8) NOT NULL,
  `spot_id` INT(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Claves primarias y propiedades

ALTER TABLE `Users`
  ADD PRIMARY KEY (`id`),
  MODIFY `id` INT(8) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Spots`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_SPOTS_USERS` (`user_id`),
  ADD KEY `FK_SPOTS_CATEGORIES` (`category_id`),
  MODIFY `id` INT(8) NOT NULL AUTO_INCREMENT;

  ALTER TABLE `Categories`
  ADD PRIMARY KEY (`id`),
  MODIFY `id` INT(8) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Coordinates`
  ADD PRIMARY KEY `FK_COORDINATES_SPOTS` (`spot_id`),
  MODIFY `spot_id` INT(8) NOT NULL ;

ALTER TABLE `Comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_COMMENTS_USERS` (`user_id`),
  ADD KEY `FK_COMMENTS_SPOTS` (`spot_id`),
  MODIFY `id` INT(8) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Ratings`
  ADD PRIMARY KEY (`user_id`, `spot_id` ),
  ADD KEY `FK_RATINGS_USERS` (`user_id`),
  ADD KEY `FK_RATINGS_SPOTS` (`spot_id`),
  MODIFY `user_id` INT(8) NOT NULL,
  MODIFY `spot_id` INT(8) NOT NULL;

ALTER TABLE `Favourites`
  ADD PRIMARY KEY (`user_id`, `spot_id` ),
  ADD KEY `FK_FAVOURITES_USERS` (`user_id`),
  ADD KEY `FK_FAVOURITES_SPOTS` (`spot_id`),
  MODIFY `user_id` INT(8) NOT NULL,
  MODIFY `spot_id` INT(8) NOT NULL;

ALTER TABLE `Pictures`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_PICTURES_USERS` (`user_id`),
  ADD KEY `FK_PICTURES_SPOTS` (`spot_id`),
  MODIFY `id` INT(8) NOT NULL AUTO_INCREMENT;

-- Claves foráneas

ALTER TABLE `Spots`
  ADD CONSTRAINT `FK_SPOTS_USERS` FOREIGN KEY (`user_id`) 
  REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SPOTS_CATEGORIES` FOREIGN KEY (`category_id`) 
  REFERENCES `Categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `Coordinates`
  ADD CONSTRAINT `FK_COORDINATES_SPOTS` FOREIGN KEY (`spot_id`) 
  REFERENCES `Spots` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Comments`
  ADD CONSTRAINT `FK_COMMENTS_USERS` FOREIGN KEY (`user_id`) 
  REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_COMMENTS_SPOTS` FOREIGN KEY (`spot_id`) 
  REFERENCES `Spots` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Ratings`
  ADD CONSTRAINT `FK_RATINGS_USERS` FOREIGN KEY (`user_id`) 
  REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_RATINGS_SPOTS` FOREIGN KEY (`spot_id`) 
  REFERENCES `Spots` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Favourites`
  ADD CONSTRAINT `FK_FAVOURITES_USERS` FOREIGN KEY (`user_id`) 
  REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_FAVOURITES_SPOTS` FOREIGN KEY (`spot_id`) 
  REFERENCES `Spots` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Pictures`
  ADD CONSTRAINT `FK_PICTURES_USERS` FOREIGN KEY (`user_id`) 
  REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PICTURES_SPOTS` FOREIGN KEY (`spot_id`) 
  REFERENCES `Spots` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
