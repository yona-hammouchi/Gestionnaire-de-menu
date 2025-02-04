-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 03 fév. 2025 à 13:30
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `gestionnaire_de_menu`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int NOT NULL AUTO_INCREMENT,
  `Nom` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `Nom`) VALUES
(1, 'Entrée'),
(2, 'Plat'),
(3, 'Dessert');

-- --------------------------------------------------------

--
-- Structure de la table `menus`
--

DROP TABLE IF EXISTS `menus`;
CREATE TABLE IF NOT EXISTS `menus` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom_menu` varchar(255) NOT NULL,
  `id_user` int NOT NULL,
  `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `menus`
--

INSERT INTO `menus` (`id`, `nom_menu`, `id_user`, `date_creation`) VALUES
(1, 'First Menu', 0, '2025-02-03 12:55:57'),
(2, 'Second Menu', 0, '2025-02-03 12:56:27'),
(3, 'Projet BLOOD', 0, '2025-02-03 13:29:01');

-- --------------------------------------------------------

--
-- Structure de la table `menu_plats`
--

DROP TABLE IF EXISTS `menu_plats`;
CREATE TABLE IF NOT EXISTS `menu_plats` (
  `menu_id` int NOT NULL,
  `plat_id` int NOT NULL,
  PRIMARY KEY (`menu_id`,`plat_id`),
  KEY `plat_id` (`plat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `menu_plats`
--

INSERT INTO `menu_plats` (`menu_id`, `plat_id`) VALUES
(1, 6),
(1, 7),
(1, 13),
(2, 5),
(2, 11),
(2, 71),
(3, 1),
(3, 4),
(3, 11);

-- --------------------------------------------------------

--
-- Structure de la table `plats`
--

DROP TABLE IF EXISTS `plats`;
CREATE TABLE IF NOT EXISTS `plats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `titre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `prix` decimal(10,0) NOT NULL,
  `id_categorie` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_categorie` (`id_categorie`)
) ENGINE=MyISAM AUTO_INCREMENT=72 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `plats`
--

INSERT INTO `plats` (`id`, `titre`, `description`, `prix`, `id_categorie`) VALUES
(1, 'Bruschetta', 'Pain tartine, Crème fraiche, Tomate, Basilic', 0, 1),
(2, 'Crème glacée', 'Parfums disponibles: Vanille, Chocolat, Pistache, Fraise', 0, 3),
(3, 'Flan', 'Pâte brisée, Crème, lait, maïzena, sucre en poudre, vanille', 0, 3),
(4, 'Fraisier', 'Oeufs, lait, sucre, farine, beurre, fraise', 0, 3),
(5, 'Gaspacho', 'Tomates au jus, ail, poivrons', 0, 1),
(6, 'Gâteau citron', 'Oeufs, lait, sucre, farine, beurre, citron', 0, 1),
(7, 'Gâteau chocolat', 'Oeufs, lait, sucre, farine, beurre, chocolat', 0, 3),
(8, 'Mille feuilles', 'Pâte feuilletée, oeuf, sucre, farine, lait', 0, 1),
(9, 'Muffin fruits rouges', 'Farine, sucre en poudre, fruits rouges surgelés, oeuf, beurre fondu, yaourt, levure', 0, 3),
(10, 'Pâtes carbonara', 'Jaunes d\'oeuf, parmesan, huile d\'olive, pancetta', 0, 2),
(11, 'Pâtes bolognaise', 'Boeuf haché, carottes, navet, feuilles de laurier', 0, 2),
(12, 'Pizza mozzarella', 'Mozzarella, purée de tomates, origan, vinaigre balsamique', 0, 2),
(13, 'Pizza végétarienne', 'Mozzarella, tomate, aubergine, poivron, courgette, olive', 0, 2),
(14, 'Ragoût de boeuf', 'Bouillon de boeuf, petits pois, carottes', 0, 2),
(15, 'Salade grecque', 'Tomate, concombre, poivrons, feta', 0, 1),
(16, 'Salade de lentilles', 'Lentilles, lardon, tomate, feta', 0, 1),
(17, 'Soupe de courge', 'Courges, pommes de terre, oignon, crème fraiche', 0, 1),
(71, 'Mille feuilles', 'Pâte feuilletée, oeuf, sucre, farine, lait', 0, 3),
(70, 'Gâteau citron', 'Oeufs, lait, sucre, farine, beurre, citron', 0, 3),
(69, 'carbonara', 'bfwg', 25, 2),
(68, 'carbonara', 'bfwg', 25, 2);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `id_user` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `created_at`, `id_user`) VALUES
(10, 'popo', 'popo@popo.com', '$2y$10$Xiztmp2.6OO3bleDsIiZIuJDepYQnKTjJxNyMnV1ff2ml034c1Ni2', '2025-01-28 20:16:16', 0),
(14, 'marvin', 'marvin@marvin.com', '$2y$10$l0vo8u0QUqL9W/fttxLdYuFZFUoRXdHQnzUCFD5fm4hrEaJTbHycy', '2025-01-29 08:47:55', 0),
(15, 'john', 'john@jonh.com', '$2y$10$sdb9VLoAcveEVRkvPlnwmeTz4nzhYjJj1xwIkoBuPqDzbvSr5EHf6', '2025-01-29 12:40:14', 0),
(17, 'scott', 'scott@scott.com', '$2y$10$ZO2SDCA/NdJ7pe3W/MY4keN9F7DKPynrzrZCgK41S/QHp.DgYon1O', '2025-01-29 12:53:23', 0),
(18, 'Olivia', 'olivia@olivia.com', '$2y$10$3oJtlKc48shrU21iwNOcG.aHfCMWAMmEpgiF4aEzUe45k1sM2C4XW', '2025-01-30 12:13:57', 0),
(19, 'yona', 'yona@yona.com', '$2y$10$ACBbPiI59hz7faFQhUWkuuzJWE3ff6fRybmPYWLlg92tyt2VqpF76', '2025-01-30 15:42:35', 0),
(20, 'maxence.b', 'maxence@b.com', '$2y$10$RJHLe187K1GDfBcxb4GkGemzcbvrA5rcehPOffmoxe0t6FCxy8pVS', '2025-02-02 14:32:30', 0),
(22, 'jack', 'jack@jack.com', '$2y$10$rVmgBcvH13iozH2B3EYXQeDcyDJvUVgGh8eVdhud1x7rRCXpbpvM2', '2025-02-02 21:25:15', 0),
(23, 'scoot', 'scoot@scoot.com', '$2y$10$G1e/c6e9MGVMrFmBR8DfIeRwpjdYVb.YER7eiwwq4p5ig60Zb9Wiy', '2025-02-03 10:02:20', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
