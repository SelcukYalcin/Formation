-- --------------------------------------------------------
-- Hôte:                         127.0.0.1
-- Version du serveur:           8.0.30 - MySQL Community Server - GPL
-- SE du serveur:                Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Listage de la structure de la base pour formationbdd
CREATE DATABASE IF NOT EXISTS `formationbdd` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `formationbdd`;

-- Listage de la structure de table formationbdd. categorie
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre_cat` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table formationbdd.categorie : ~4 rows (environ)
INSERT INTO `categorie` (`id`, `titre_cat`) VALUES
	(1, 'BUREAUTIQUE'),
	(2, 'DEW WEB'),
	(3, 'COMMERCE'),
	(4, 'COMPTABILITE');

-- Listage de la structure de table formationbdd. doctrine_migration_versions
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

-- Listage des données de la table formationbdd.doctrine_migration_versions : ~2 rows (environ)
INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
	('DoctrineMigrations\\Version20221202200705', '2022-12-02 20:09:52', 475),
	('DoctrineMigrations\\Version20221204145405', '2022-12-04 14:54:16', 282);

-- Listage de la structure de table formationbdd. formateur
CREATE TABLE IF NOT EXISTS `formateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `prenom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cp` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_naissance` date NOT NULL,
  `adresse` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sexe` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table formationbdd.formateur : ~5 rows (environ)
INSERT INTO `formateur` (`id`, `prenom`, `nom`, `telephone`, `email`, `ville`, `cp`, `date_naissance`, `adresse`, `sexe`) VALUES
	(1, 'Mickael', 'MURMANN', '07087896548', 'murmann@gmail.com', 'STRASBOURG', '67100', '1986-11-14', 'Rue des Peupliers', 'M'),
	(2, 'Stephane', 'SMAIL', '0708742554', 'smail@gmail.com', 'MULHOUSE', '68000', '1985-12-02', 'Rue des Champs', 'M'),
	(3, 'Philippe ', 'BOURDON', '0696857448', 'bourdon@gmail.com', 'COLMAR', '68100', '1988-12-04', 'Avenue de Mulhouse', 'M'),
	(4, 'Océane', 'MARTIN', '0635324547', 'martin@gmail.com', 'STRASBOURG', '67000', '1993-12-04', '54 Rue Principale', 'F'),
	(5, 'Julie', 'ADER', '0656897845', 'ader@gmail.com', 'COLMAR', '68200', '1995-12-04', '22 Rue des Roses', 'F');

-- Listage de la structure de table formationbdd. messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `available_at` datetime NOT NULL,
  `delivered_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table formationbdd.messenger_messages : ~0 rows (environ)

-- Listage de la structure de table formationbdd. module
CREATE TABLE IF NOT EXISTS `module` (
  `id` int NOT NULL AUTO_INCREMENT,
  `categorie_id` int NOT NULL,
  `titre_mod` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_C242628BCF5E72D` (`categorie_id`),
  CONSTRAINT `FK_C242628BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table formationbdd.module : ~12 rows (environ)
INSERT INTO `module` (`id`, `categorie_id`, `titre_mod`) VALUES
	(1, 1, 'Word'),
	(2, 1, 'Excel'),
	(3, 1, 'Powerpoint'),
	(4, 2, 'PHP'),
	(5, 2, 'SQL'),
	(6, 2, 'JavaScript'),
	(7, 4, 'Excel'),
	(8, 3, 'Word'),
	(9, 3, 'Powerpoint'),
	(10, 4, 'Word'),
	(11, 3, 'Vente'),
	(12, 4, 'Maths');

-- Listage de la structure de table formationbdd. programmer
CREATE TABLE IF NOT EXISTS `programmer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `prog_ses_id` int NOT NULL,
  `prog_mod_id` int NOT NULL,
  `duree` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_4136CCA9D79E5C31` (`prog_ses_id`),
  KEY `IDX_4136CCA9693C485D` (`prog_mod_id`),
  CONSTRAINT `FK_4136CCA9693C485D` FOREIGN KEY (`prog_mod_id`) REFERENCES `module` (`id`),
  CONSTRAINT `FK_4136CCA9D79E5C31` FOREIGN KEY (`prog_ses_id`) REFERENCES `session` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table formationbdd.programmer : ~0 rows (environ)

-- Listage de la structure de table formationbdd. session
CREATE TABLE IF NOT EXISTS `session` (
  `id` int NOT NULL AUTO_INCREMENT,
  `formateur_id` int NOT NULL,
  `intitule` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `nb_place` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_D044D5D4155D8F51` (`formateur_id`),
  CONSTRAINT `FK_D044D5D4155D8F51` FOREIGN KEY (`formateur_id`) REFERENCES `formateur` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table formationbdd.session : ~2 rows (environ)
INSERT INTO `session` (`id`, `formateur_id`, `intitule`, `date_debut`, `date_fin`, `nb_place`) VALUES
	(1, 1, 'Plateau Strasbourg', '2022-12-02', '2022-12-05', 15),
	(2, 2, 'Plateau Mulhouse', '2022-12-02', '2023-03-02', 12);

-- Listage de la structure de table formationbdd. session_stagiaire
CREATE TABLE IF NOT EXISTS `session_stagiaire` (
  `session_id` int NOT NULL,
  `stagiaire_id` int NOT NULL,
  PRIMARY KEY (`session_id`,`stagiaire_id`),
  KEY `IDX_C80B23B613FECDF` (`session_id`),
  KEY `IDX_C80B23BBBA93DD6` (`stagiaire_id`),
  CONSTRAINT `FK_C80B23B613FECDF` FOREIGN KEY (`session_id`) REFERENCES `session` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_C80B23BBBA93DD6` FOREIGN KEY (`stagiaire_id`) REFERENCES `stagiaire` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table formationbdd.session_stagiaire : ~0 rows (environ)

-- Listage de la structure de table formationbdd. stagiaire
CREATE TABLE IF NOT EXISTS `stagiaire` (
  `id` int NOT NULL AUTO_INCREMENT,
  `prenom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telephone` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ville` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `adresse` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cp` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_naissance` date NOT NULL,
  `sexe` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table formationbdd.stagiaire : ~4 rows (environ)
INSERT INTO `stagiaire` (`id`, `prenom`, `nom`, `email`, `telephone`, `ville`, `adresse`, `cp`, `date_naissance`, `sexe`) VALUES
	(1, 'Nicolas', 'AUBERT', 'nicolas@gmail.com', '0708040501', 'STRASBOURG', '15 Rue des Champs', '67000', '2000-12-04', 'M\r\n'),
	(2, 'Corinne', 'DIAZ', 'corine@gmail.com', '0807090504', 'STRASBOURG', '8 Rue du Chêne', '67200', '1999-12-04', 'F'),
	(3, 'Henri', 'BLONDEL', 'henri@gmail.com', '0759587884', 'COLMAR', '31 Avenue de Starsbourg', '68000', '2003-12-04', 'M'),
	(4, 'Aurelie', 'LESAGE', 'aurelie@gmail.com', '0654987585', 'COLMAR', '33 Avenue de Strasbourg', '68000', '1996-12-04', 'F');

-- Listage de la structure de table formationbdd. user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pseudo` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Listage des données de la table formationbdd.user : ~0 rows (environ)

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
