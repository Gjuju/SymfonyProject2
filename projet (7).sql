-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : sam. 06 fév. 2021 à 21:54
-- Version du serveur :  10.4.17-MariaDB
-- Version de PHP : 7.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `projet`
--

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id` int(11) NOT NULL,
  `nom_categorie` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `nom_categorie`, `photo`) VALUES
(1, 'livre', ''),
(2, 'jouet', ''),
(3, 'jeu video', ''),
(4, 'electromenager', ''),
(5, 'musique', '');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) DEFAULT NULL,
  `produit_id` int(11) NOT NULL,
  `produit_nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `produit_prix` decimal(10,2) NOT NULL,
  `produit_quantite` int(11) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20210206204550', '2021-02-06 21:46:05', 981);

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

CREATE TABLE `panier` (
  `id` int(11) NOT NULL,
  `produit_id` int(11) NOT NULL,
  `utilisateur_id` int(11) DEFAULT NULL,
  `quantite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `panier`
--

INSERT INTO `panier` (`id`, `produit_id`, `utilisateur_id`, `quantite`) VALUES
(1, 1, 43, 1),
(2, 3, 43, 1);

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id` int(11) NOT NULL,
  `categorie_id` int(11) NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `categorie_id`, `nom`, `description`, `prix`, `stock`, `photo`, `is_active`) VALUES
(1, 1, 'coucou', 'Un livre super', '39.00', 5, '/img/livre.png', 1),
(2, 1, 'salut', 'Un livre génial', '29.00', 6, '/img/livre.png', 1),
(3, 2, 'quille', 'Le jeu de quille', '15.00', 5, '/img/quille.jpg', 1),
(4, 2, 'poker', 'Jeu de carte poker', '9.00', 13, '/img/poker.png', 1),
(5, 2, 'Jeu d\'échec', 'Un damier et des pions en marbre', '79.00', 3, '/img/jeuechec.jpg', 1),
(6, 3, 'spwitch', 'Console de jeu', '219.00', 7, '/img/switch.jpg', 1),
(7, 3, 'Ryzen 2 le retour', 'Jeu pour console spwitch', '69.00', 15, '/img/jeuvideo.png', 1),
(8, 4, 'minitel', 'retro, mais vraiment retro', '199.00', 2, '/img/minitel.jpg', 1),
(9, 4, 'pamsung machine laver linge', 'Machine à laver le linge', '499.00', 5, '/img/machinelaver.jpg', 1),
(10, 4, 'four whirlpool', 'Four encastrable', '379.00', 4, '/img/four.jpg', 1),
(11, 5, 'Le groupe de ouf', 'CD rock', '29.00', 10, '/img/cdrock.jpg', 1),
(12, 5, 'Mozart', 'Musique classique', '15.00', 7, '/img/mozart.jpg', 1),
(13, 3, 'Worms', 'Le Vieux jeu Collector Edition !', '10.00', 1, '/worms.jpg', 1);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL,
  `username` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `first_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `birth_date` date DEFAULT NULL,
  `email` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_verified` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `username`, `roles`, `password`, `first_name`, `last_name`, `address`, `phone_number`, `birth_date`, `email`, `is_verified`) VALUES
(1, 'admin', '[\"ROLE_ADMIN\"]', '$argon2id$v=19$m=65536,t=4,p=1$cN76DbICOKVdELQ9P8WzSA$r5OqGNQJ4hYwrrz/ykd7oW8tkatpwBGMFTU3dUulWnw', 'Marc', 'Balouzet', NULL, NULL, NULL, NULL, 0),
(3, 'jean', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$kgE3vg2lUCog1keTlHxAog$oVx0BCrdKJegTv/6eeKuRkkMmbkQCC0x1jsJDVBfpp8', 'Jean', 'Michel', NULL, NULL, NULL, NULL, 0),
(35, 'tests', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$IFRbBJl5zZoa5QvcJiPQHg$r73FB+nAVFF9CDgeYF3I/HfFAxjkyJxjSeCqsFJoQW0', NULL, NULL, NULL, NULL, NULL, NULL, 0),
(37, 'gjuju', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$nlh/xxv+bUfJzJM/+Bm0zQ$ruCNi6EV6Kv1P45eALm+N5VnAWAwHVMqghzt3Ruf4tY', 'Gainza', 'Julien', '17 Rue', '068258', '2017-01-14', 'gainza@gmail.com', 0),
(38, 'tetst', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$a3rkVV1kUvVo0aJsMv5+2w$424f6TZc8Ghr157DEsnsNjy9+qBbeGOsIDZDjQ0BYVA', 'ju', 'lien', '23', '234566', NULL, 'gainza@gmail.com', 0),
(39, 'toto', '[]', '$argon2id$v=19$m=65536,t=4,p=1$8NxmPeu0BE7MentAi7yDjA$bBgVurGr77g4ZdAg3TyIYhbzchVMg4yOIXP6naEmR8s', 'to', 'to', '17 ro', '5069939595', '2019-01-04', 'toto@toto.fr', 0),
(40, 'tutu', '[]', '$argon2id$v=19$m=65536,t=4,p=1$t3t594SuVv+Rw1zR+Ehksg$U7DFlXK1SuSTvim6d8yVkU4oCo0BNOKcjaHOlWlSXug', 'tu', 'tu', 'tu 56', '5678901234', '2019-04-04', 'tutu@tutu.fr', 0),
(41, 'titi', '[]', '$argon2id$v=19$m=65536,t=4,p=1$C+XdL4XlGk8GPiBJDLA4+g$QhGjlcztMoj5jS1ajKl3+0JYVTcKbmXPZDqbor4/IAA', 'titi', 'titi', 'titi 78', '1234567890', '2020-05-18', 'TITI@titi.fr', 0),
(42, 'tptp', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$mtg3dEV+/Bg8WySVTfsKQg$4TlT026ETNuSYRK8OAYKpMhzWJKF2bYmyOQluDRxaaQ', 'tptp', 'tptp', 'tptp', '5678901234', '2023-09-15', 'tptp@tptp.ft', 0),
(43, 'jo', '[\"ROLE_USER\"]', '$argon2id$v=19$m=65536,t=4,p=1$49p1PJZgdF3O/sDoyCyWVA$TrrYhnw37CZdcZaGxNetIiClVJFO9PzqzmmTB5Gl794', 'jo', 'jo', 'jo', 'jo', '2018-02-01', 'jo@jo.jo', 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6EEAA67DFB88E14F` (`utilisateur_id`);

--
-- Index pour la table `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Index pour la table `panier`
--
ALTER TABLE `panier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_24CC0DF2F347EFB` (`produit_id`),
  ADD KEY `IDX_24CC0DF2FB88E14F` (`utilisateur_id`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_29A5EC27BCF5E72D` (`categorie_id`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_1D1C63B3F85E0677` (`username`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `commande`
--
ALTER TABLE `commande`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `panier`
--
ALTER TABLE `panier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `FK_6EEAA67DFB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `FK_24CC0DF2F347EFB` FOREIGN KEY (`produit_id`) REFERENCES `produit` (`id`),
  ADD CONSTRAINT `FK_24CC0DF2FB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id`);

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `FK_29A5EC27BCF5E72D` FOREIGN KEY (`categorie_id`) REFERENCES `categorie` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
