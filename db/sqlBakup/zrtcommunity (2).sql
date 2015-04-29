-- phpMyAdmin SQL Dump
-- version 4.4.2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Jeu 30 Avril 2015 à 00:57
-- Version du serveur :  10.0.17-MariaDB-log
-- Version de PHP :  5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `zrtcommunity`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `order` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`id`, `name`, `order`) VALUES
(1, 'Info', 1),
(2, 'Support', 2),
(3, 'Inscriptions Candidatues', 3),
(4, 'Projet', 4);

-- --------------------------------------------------------

--
-- Structure de la table `messageforum`
--

CREATE TABLE IF NOT EXISTS `messageforum` (
  `id` int(11) NOT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `auteur_id` int(11) DEFAULT NULL,
  `date` datetime NOT NULL,
  `contenu` varchar(5000) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=1996 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `messageforum`
--

INSERT INTO `messageforum` (`id`, `topic_id`, `auteur_id`, `date`, `contenu`) VALUES
(1993, 1, 1, '2015-04-28 00:00:00', 'OUI J4AIME LE PENIS'),
(1994, 2, 1, '2015-04-28 00:00:00', 'keur'),
(1995, 3, 1, '2015-04-28 00:00:00', '#mdr.');

-- --------------------------------------------------------

--
-- Structure de la table `souscategorie`
--

CREATE TABLE IF NOT EXISTS `souscategorie` (
  `id` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `order` int(11) NOT NULL,
  `parentCategorie_id` int(11) DEFAULT NULL,
  `parentSousCategorie_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `souscategorie`
--

INSERT INTO `souscategorie` (`id`, `description`, `name`, `order`, `parentCategorie_id`, `parentSousCategorie_id`) VALUES
(1, '', 'News', 1, 1, NULL),
(2, 'le reglement', 'Reglement', 2, 1, NULL),
(3, '', 'Informations', 3, 1, NULL),
(4, 'vous avez une question?', 'Questions plaintes suggestions', 1, 2, NULL),
(5, 'Pour vous inscrir', 'Inscriptions', 1, 3, NULL),
(6, '', 'demande de changement de rang', 2, 3, NULL),
(7, '', 'Candidature pou des fonctions', 3, 3, NULL),
(8, 'Oé Oé club med', 'tourisme', 1, 4, NULL),
(9, 'tkt viens pas tes idées sont null', 'Proposition de projet', 2, 4, NULL),
(10, 'ceux la sont biens', 'Projets validés', 3, 4, NULL),
(11, '', 'projets refusés', 4, 4, NULL),
(12, '', 'brouillon', 1, NULL, 1),
(13, '', 'Brouillon', 1, NULL, 5),
(14, '', 'Brouillon', 1, NULL, 8),
(15, '', 'Brouillon', 1, NULL, 9),
(16, '', 'Services publiques officiels', 1, NULL, 10),
(17, '', 'Villes', 2, NULL, 10),
(18, '', 'Pixelarts', 3, NULL, 10),
(19, '', 'Reproductions de fictions', 4, NULL, 10);

-- --------------------------------------------------------

--
-- Structure de la table `topics`
--

CREATE TABLE IF NOT EXISTS `topics` (
  `id` int(11) NOT NULL,
  `creator_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sousCategorie_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `topics`
--

INSERT INTO `topics` (`id`, `creator_id`, `name`, `description`, `sousCategorie_id`) VALUES
(1, 1, 'j''aime le penis et vous ?', 'tout est dans le titre (mais n’hésite pas a donner ton avis)', 1),
(2, 1, 'bla bla', 'touch my tralala', 1),
(3, 1, 'un autre topic un peu nul', '', 1);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `salt`, `role`, `email`) VALUES
(1, 'Nydareld', 'eAKtVJL8797p12v5AiunxLbucVFf5+6yjs1u9D18iWFTAPP0+NfGSAeKk/poYd2PECX16Rm6rTO0Ohb2NAMn3A==', 'a620e599e0b0bff1091b11a', 'ROLE_USER', 'theo.guerin.pro@gmail.com');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `messageforum`
--
ALTER TABLE `messageforum`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_719B550F1F55203D` (`topic_id`),
  ADD KEY `IDX_719B550F60BB6FE6` (`auteur_id`);

--
-- Index pour la table `souscategorie`
--
ALTER TABLE `souscategorie`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6FF3A70191559C5B` (`parentCategorie_id`),
  ADD KEY `IDX_6FF3A70147686575` (`parentSousCategorie_id`);

--
-- Index pour la table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_91F6463961220EA6` (`creator_id`),
  ADD KEY `IDX_91F64639BA40FD18` (`sousCategorie_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `messageforum`
--
ALTER TABLE `messageforum`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1996;
--
-- AUTO_INCREMENT pour la table `souscategorie`
--
ALTER TABLE `souscategorie`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT pour la table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `messageforum`
--
ALTER TABLE `messageforum`
  ADD CONSTRAINT `FK_719B550F1F55203D` FOREIGN KEY (`topic_id`) REFERENCES `topics` (`id`),
  ADD CONSTRAINT `FK_719B550F60BB6FE6` FOREIGN KEY (`auteur_id`) REFERENCES `users` (`id`);

--
-- Contraintes pour la table `souscategorie`
--
ALTER TABLE `souscategorie`
  ADD CONSTRAINT `FK_6FF3A70147686575` FOREIGN KEY (`parentSousCategorie_id`) REFERENCES `souscategorie` (`id`),
  ADD CONSTRAINT `FK_6FF3A70191559C5B` FOREIGN KEY (`parentCategorie_id`) REFERENCES `categories` (`id`);

--
-- Contraintes pour la table `topics`
--
ALTER TABLE `topics`
  ADD CONSTRAINT `FK_91F6463961220EA6` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `FK_91F64639BA40FD18` FOREIGN KEY (`sousCategorie_id`) REFERENCES `souscategorie` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
