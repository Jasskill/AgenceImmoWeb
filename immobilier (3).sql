-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 22 nov. 2023 à 14:06
-- Version du serveur : 5.7.36
-- Version de PHP : 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `immobilier`
--

-- --------------------------------------------------------

--
-- Structure de la table `disponibilite`
--

DROP TABLE IF EXISTS `disponibilite`;
CREATE TABLE IF NOT EXISTS `disponibilite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL,
  `idLogement` int(11) NOT NULL,
  `tarif` decimal(10,0) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idLogement` (`idLogement`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `disponibilite`
--

INSERT INTO `disponibilite` (`id`, `dateDebut`, `dateFin`, `idLogement`, `tarif`) VALUES
(1, '2023-12-01', '2023-12-07', 1, '120'),
(2, '2023-11-25', '2023-11-30', 2, '90'),
(3, '2024-01-10', '2024-01-20', 3, '150'),
(4, '2023-12-15', '2023-12-20', 4, '100'),
(5, '2024-02-01', '2024-02-10', 5, '130');

-- --------------------------------------------------------

--
-- Structure de la table `equipement`
--

DROP TABLE IF EXISTS `equipement`;
CREATE TABLE IF NOT EXISTS `equipement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(100) NOT NULL,
  `idPiece` int(11) NOT NULL,
  `idLogement` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Equipement_Piece_FK` (`idPiece`),
  KEY `idLogement` (`idLogement`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `equipement`
--

INSERT INTO `equipement` (`id`, `libelle`, `idPiece`, `idLogement`) VALUES
(1, 'Lit double', 1, 1),
(2, 'Cuisinière', 2, 1),
(3, 'Canapé-lit', 3, 1),
(4, 'Douche', 4, 1),
(5, 'Lit simple', 5, 2);

-- --------------------------------------------------------

--
-- Structure de la table `logement`
--

DROP TABLE IF EXISTS `logement`;
CREATE TABLE IF NOT EXISTS `logement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rue` varchar(200) NOT NULL,
  `codePostal` varchar(10) NOT NULL,
  `ville` varchar(150) NOT NULL,
  `description` varchar(255) NOT NULL,
  `idUtilisateur` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Logement_Utilisateur_FK` (`idUtilisateur`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `logement`
--

INSERT INTO `logement` (`id`, `rue`, `codePostal`, `ville`, `description`, `idUtilisateur`) VALUES
(1, '20 rue de la Liberté', '75001', 'Paris', 'Bel appartement près de la Tour Eiffel', 1),
(2, '5 avenue des Champs-Élysées', '75008', 'Paris', 'Studio moderne au cœur de la ville', 2),
(3, '10 rue du Vieux Port', '13001', 'Marseille', 'Maison avec vue sur la mer', 3),
(4, '25 rue de la République', '69001', 'Lyon', 'Appartement en plein centre-ville', 4),
(5, '8 rue Saint-Michel', '33000', 'Bordeaux', 'Duplex élégant près de la Garonne', 5);

-- --------------------------------------------------------

--
-- Structure de la table `photo`
--

DROP TABLE IF EXISTS `photo`;
CREATE TABLE IF NOT EXISTS `photo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `taille` int(11) NOT NULL,
  `type` varchar(20) NOT NULL,
  `lien` varchar(300) NOT NULL,
  `idEquipement` int(11) DEFAULT NULL,
  `idLogement` int(11) DEFAULT NULL,
  `idPiece` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Photo_Equipement_FK` (`idEquipement`),
  KEY `Photo_Logement0_FK` (`idLogement`),
  KEY `Photo_Piece1_FK` (`idPiece`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `piece`
--

DROP TABLE IF EXISTS `piece`;
CREATE TABLE IF NOT EXISTS `piece` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `surface` int(11) NOT NULL,
  `type` varchar(255) NOT NULL,
  `idLogement` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Piece_Logement_FK` (`idLogement`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `piece`
--

INSERT INTO `piece` (`id`, `surface`, `type`, `idLogement`) VALUES
(1, 25, 'Chambre', 1),
(2, 40, 'Cuisine', 1),
(3, 30, 'Salon', 1),
(4, 20, 'Salle de bain', 1),
(5, 35, 'Chambre', 2);

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

DROP TABLE IF EXISTS `reservation`;
CREATE TABLE IF NOT EXISTS `reservation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dateDebut` date NOT NULL,
  `dateFin` date NOT NULL,
  `idLogement` int(11) NOT NULL,
  `idClient` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `idLogement` (`idLogement`),
  KEY `idClient` (`idClient`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`id`, `dateDebut`, `dateFin`, `idLogement`, `idClient`) VALUES
(1, '2023-12-01', '2023-12-07', 1, 3),
(2, '2023-11-25', '2023-11-30', 2, 1),
(3, '2024-01-12', '2024-01-18', 3, 4),
(4, '2023-12-18', '2023-12-22', 4, 2),
(5, '2024-02-05', '2024-02-08', 5, 5);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mdp` varchar(300) NOT NULL,
  `nom` varchar(150) NOT NULL,
  `prenom` varchar(150) NOT NULL,
  `mail` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id`, `mdp`, `nom`, `prenom`, `mail`) VALUES
(1, 'motdepasse1', 'Dupont', 'Pierre', 'pierre.dupont@gmail.com'),
(2, 'motdepasse2', 'Varin', 'Mael', 'mael.varin@gmail.com'),
(3, 'motdepasse3', 'Savea', 'Erwann', 'erwann.savea@gmail.com'),
(4, 'motdepasse4', 'Martin', 'Sophie', 'sophie.martin@gmail.com'),
(5, 'motdepasse5', 'Lefevre', 'Emma', 'emma.lefevre@gmail.com');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
