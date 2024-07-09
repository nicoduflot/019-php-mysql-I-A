-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : ven. 15 sep. 2023 à 09:27
-- Version du serveur : 8.0.31
-- Version de PHP : 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `php-mysql-i-a`
--

-- --------------------------------------------------------

--
-- Structure de la table `possesseur`
--

DROP TABLE IF EXISTS `possesseur`;
CREATE TABLE IF NOT EXISTS `possesseur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `prenom` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `identifiant` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `possesseur`
--

INSERT INTO `possesseur` (`id`, `prenom`, `nom`, `identifiant`, `email`) VALUES
(1, 'Corentin', 'Malou', 'corentin_malou', 'corentin_malou@yahoo.fr'),
(2, 'Florent', 'Bouton', 'florent_bouton', 'florent_bouton@yahoo.fr'),
(3, 'Mathieu', 'Fleur', 'mathieu_fleur', 'mathieu_fleur@yahoo.fr'),
(4, 'Michel', 'Dusse', 'michel_dusse', 'michel_dusse@yahoo.fr'),
(5, 'Patrick', 'Leseau', 'patrick_leseau', 'patrick_leseau@yahoo.fr'),
(6, 'Sébastien', 'Bel', 'sebastien_bel', 'sebastien_bel@yahoo.fr');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
