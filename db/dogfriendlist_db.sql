
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+02:00";

DROP DATABASE IF EXISTS `testing-db`;

CREATE DATABASE `testing-db` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `testing-db`;

-- Estructura de la tabla `Users`

CREATE TABLE `Users` (
  `id` INT(8) NOT NULL UNIQUE,
  `username` VARCHAR(15) NOT NULL UNIQUE,
  `email` VARCHAR(50) NOT NULL UNIQUE,
  `visibility` INT(1) NOT NULL DEFAULT 1,
  `city` VARCHAR(50) DEFAULT NULL,
  `country` VARCHAR(50) DEFAULT NULL,
  `name` VARCHAR(25) DEFAULT NULL,
  `surname` VARCHAR(50) DEFAULT NULL,
  `img` VARCHAR(255) NOT NULL DEFAULT 'storage/common/img/default-profile-picture.jpeg',
  `about_me` TEXT(350) DEFAULT NULL,
  `password` VARCHAR(64) NOT NULL,
  `role` INT(1) NOT NULL DEFAULT 0,
  `activation_key` VARCHAR(64) DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Estructura de la tabla `Spots`

CREATE TABLE `Spots` (
  `id` INT(8) NOT NULL UNIQUE,
  `title` VARCHAR(50) NOT NULL UNIQUE,
  `description` TEXT(500) NOT NULL,
  `lat` DECIMAL(10,7) NOT NULL,
  `lng` DECIMAL(10,7) NOT NULL,
  `address` VARCHAR(125) DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` INT(8) NOT NULL,
  `category_id` INT(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Estructura de la tabla `Categories`

CREATE TABLE `Categories` (
  `id` INT(8) NOT NULL,
  `name` VARCHAR(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Estructura de la tabla `Favourites`

CREATE TABLE `Favourites` (
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
  MODIFY `id` INT(8) NOT NULL;


ALTER TABLE `Favourites`
  ADD PRIMARY KEY (`user_id`, `spot_id` ),
  ADD KEY `FK_FAVOURITES_USERS` (`user_id`),
  ADD KEY `FK_FAVOURITES_SPOTS` (`spot_id`),
  MODIFY `user_id` INT(8) NOT NULL,
  MODIFY `spot_id` INT(8) NOT NULL;

-- Claves foráneas

ALTER TABLE `Spots`
  ADD CONSTRAINT `FK_SPOTS_USERS` FOREIGN KEY (`user_id`) 
  REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SPOTS_CATEGORIES` FOREIGN KEY (`category_id`) 
  REFERENCES `Categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Favourites`
  ADD CONSTRAINT `FK_FAVOURITES_USERS` FOREIGN KEY (`user_id`) 
  REFERENCES `Users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_FAVOURITES_SPOTS` FOREIGN KEY (`spot_id`) 
  REFERENCES `Spots` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

-- Valores predefinidos para la tabla `Categories`.

INSERT INTO `Categories` (id, name) VALUES (2, 'Parques y zonas verdes');
INSERT INTO `Categories` (id, name) VALUES (3, 'Alojamiento');
INSERT INTO `Categories` (id, name) VALUES (4,	'Bares y restaurantes');
INSERT INTO `Categories` (id, name) VALUES (5, 'Tiendas de mascotas');
INSERT INTO `Categories` (id, name) VALUES (6, 'Clínicas veterinarias');
INSERT INTO `Categories` (id, name) VALUES (7,	'Guarderías caninas');
INSERT INTO `Categories` (id, name) VALUES (8,	'Otros');
