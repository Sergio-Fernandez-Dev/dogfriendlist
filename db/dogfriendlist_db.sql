
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+02:00";

CREATE DATABASE IF NOT EXISTS `dogfriendlist` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `dogfriendlist`;

-- Estructura de la tabla `Users`

CREATE TABLE `Users` (
  `Id` INT(8) NOT NULL,
  `Nickname` VARCHAR(15) NOT NULL,
  `Email` VARCHAR(50) NOT NULL,
  `Visibility` BIT NOT NULL,
  `City` VARCHAR(50) DEFAULT NULL,
  `Country` VARCHAR(50) DEFAULT NULL,
  `Name` VARCHAR(25) NOT NULL,
  `Surname` VARCHAR(50) NOT NULL,
  `Img` VARCHAR(255) DEFAULT 'users/common/default-profile-picture.jpg',
  `AboutMe` TEXT(350) DEFAULT NULL,
  `PassHash` VARCHAR(64) NOT NULL,
  `CreatedAt ` DATETIME DEFAULT TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Estructura de la tabla `Spots`

CREATE TABLE `Spots` (
  `Id` INT(8) NOT NULL,
  `Title` VARCHAR(25) NOT NULL,
  `Description` TEXT(500) NOT NULL,
  `Address` VARCHAR(125)CHARACTER SET cp1250 COLLATE cp1250_bin DEFAULT NULL,
  `CreatedAt` DATETIME DEFAULT TIMESTAMP,
  `UserId` INT(8) NOT NULL
  `CategoryId` INT(8) NOT NULL;
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Estructura de la tabla `Categories`

CREATE TABLE `Categories` (
  `Id` INT(8) NOT NULL,
  `Name` VARCHAR(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- Estructura de la tabla `Comments`

CREATE TABLE `Comments` (
  `Id` INT(8) NOT NULL,
  `Title` VARCHAR(25) NOT NULL,
  `Comment` TEXT(500) NOT NULL,
  `CreatedAt` DATETIME DEFAULT TIMESTAMP,
  `UserId` INT(8) NOT NULL,
  `SpotID` INT(8) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Estructura de la tabla `Coordinates`

CREATE TABLE `Coordinates` (
  `SpotId` INT(8) NOT NULL,
  `Long` DECIMAL(6,3) NOT NULL,
  `Lat` DECIMAL(6,3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Estructura de la tabla `Ratings`

CREATE TABLE `Ratings` (
  `UserId` INT(8) NOT NULL,
  `SpotId` INT(8) NOT NULL,
  `Valuation` TINYINT(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Estructura de la tabla `Favourites`

CREATE TABLE `Favourites` (
  `UserId` INT(8) NOT NULL,
  `SpotId` INT(8) NOT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Estructura de la tabla `Pictures`

CREATE TABLE `Pictures` (
  `Id` INT(8) NOT NULL,
  `Img` VARCHAR(255) DEFAULT 'spots/common/default-spot-picture.jpg',
  `UserId` INT(8) NOT NULL,
  `SpotId` INT(8) NOT NULL,
) ENGINE=InnoDB DEFAULT CHARSET=utf8


-- Claves primarias y propiedades

ALTER TABLE `Users`
  ADD PRIMARY KEY (`Id`),
  MODIFY `Id` INT(8) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Spots`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `FK_SPOTS_USERS` (`UserId`),
  ADD KEY `FK_SPOTS_CATEGORIES` (`CategoryId`),
  MODIFY `Id` INT(8) NOT NULL AUTO_INCREMENT;

  ALTER TABLE `Categories`
  ADD PRIMARY KEY (`Id`),
  MODIFY `Id` INT(8) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Coordinates`
  ADD PRIMARY KEY `FK_COORDINATES_SPOTS` (`Id`),
  MODIFY `Id` INT(8) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Comments`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `FK_COMMENTS_USERS` (`UserId`),
  ADD KEY `FK_COMMENTS_SPOTS` (`SpotId`),
  MODIFY `Id` INT(8) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Ratings`
  ADD PRIMARY KEY (`UserId`, `SpotId` ),
  ADD KEY `FK_RATINGS_USERS` (`UserId`),
  ADD KEY `FK_RATINGS_SPOTS` (`SpotId`),
  MODIFY `Id` INT(8) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Favourites`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `FK_FAVOURITES_USERS` (`UserId`),
  ADD KEY `FK_FAVOURITES_SPOTS` (`SpotId`),
  MODIFY `Id` INT(8) NOT NULL AUTO_INCREMENT;

ALTER TABLE `Pictures`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `FK_PICTURES_USERS` (`UserId`),
  ADD KEY `FK_PICTURES_SPOTS` (`SpotId`),
  MODIFY `Id` INT(8) NOT NULL AUTO_INCREMENT;

-- Claves foráneas

ALTER TABLE `Spots`
  ADD CONSTRAINT `FK_SPOTS_USERS` FOREIGN KEY (`UserId`) 
  REFERENCES `Users` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_SPOTS_CATEGORIES` FOREIGN KEY (`CategoryId`) 
  REFERENCES `Categories` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Categories`
  ADD CONSTRAINT `FK_SPOTS_CATEGORIES` FOREIGN KEY (`CategoryId`) 
  REFERENCES `Categories` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Coordinates`
  ADD CONSTRAINT `FK_COORDINATES_SPOTS` FOREIGN KEY (`Id`) 
  REFERENCES `Spots` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Comments`
  ADD CONSTRAINT `FK_COMMENTS_USERS` FOREIGN KEY (`UserId`) 
  REFERENCES `Users` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_COMMENTS_SPOTS` FOREIGN KEY (`SpotId`) 
  REFERENCES `Spots` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Ratings`
  ADD CONSTRAINT `FK_RATINGS_USERS` FOREIGN KEY (`UserId`) 
  REFERENCES `Users` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_RATINGS_SPOTS` FOREIGN KEY (`SpotId`) 
  REFERENCES `Spots` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Favourites`
  ADD CONSTRAINT `FK_FAVOURITES_USERS` FOREIGN KEY (`UserId`) 
  REFERENCES `Users` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_FAVOURITES_SPOTS` FOREIGN KEY (`SpotId`) 
  REFERENCES `Spots` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `Pictures`
  ADD CONSTRAINT `FK_PICTURES_USERS` FOREIGN KEY (`UserId`) 
  REFERENCES `Users` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_PICTURES_SPOTS` FOREIGN KEY (`SpotId`) 
  REFERENCES `Spots` (`Id`) ON DELETE CASCADE ON UPDATE CASCADE;
