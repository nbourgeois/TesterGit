-- phpMyAdmin SQL Dump
-- version 3.4.2
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le : Ven 05 Juillet 2013 à 11:50
-- Version du serveur: 5.1.55
-- Version de PHP: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `GESTAGE`
--

-- --------------------------------------------------------

--
-- Structure de la table `ANNEESCOL`
--

CREATE TABLE IF NOT EXISTS `ANNEESCOL` (
  `ANNEESCOL` char(9) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`ANNEESCOL`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `ANNEESCOL`
--

INSERT INTO `ANNEESCOL` (`ANNEESCOL`) VALUES
('2008-2009'),
('2009-2010'),
('2010-2011'),
('2011-2012'),
('2012-2013');

-- --------------------------------------------------------

--
-- Structure de la table `CLASSE`
--

CREATE TABLE IF NOT EXISTS `CLASSE` (
  `NUMCLASSE` char(32) CHARACTER SET latin1 NOT NULL,
  `IDSPECIALITE` smallint(6) DEFAULT NULL,
  `NUMFILIERE` int(11) NOT NULL,
  `NOMCLASSE` char(150) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`NUMCLASSE`),
  KEY `I_FK_CLASSE_SPECIALITE` (`IDSPECIALITE`),
  KEY `NUMFILIERE` (`NUMFILIERE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `CLASSE`
--

INSERT INTO `CLASSE` (`NUMCLASSE`, `IDSPECIALITE`, `NUMFILIERE`, `NOMCLASSE`) VALUES
('1SIOA', NULL, 4, '1ére année BTS Service Informatique auxOrganisation'),
('1SIOB', NULL, 4, '1ére année BTS Service Informatique auxOrganisation'),
('2SISR', 2, 4, '2ème année BTS Service Informatique auxOrganisation'),
('2SLAM', 1, 4, '2ème année BTS Service Informatique auxOrganisation');

-- --------------------------------------------------------

--
-- Structure de la table `CONTACT_ORGANISATION`
--

CREATE TABLE IF NOT EXISTS `CONTACT_ORGANISATION` (
  `IDORGANISATION` varchar(10) CHARACTER SET latin1 NOT NULL,
  `IDCONTACT` varchar(10) CHARACTER SET latin1 NOT NULL,
  `FONCTION` varchar(128) CHARACTER SET latin1 DEFAULT NULL,
  PRIMARY KEY (`IDORGANISATION`,`IDCONTACT`),
  KEY `I_FK_CONTACT_ORGANISATION_PERSONNE` (`IDCONTACT`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `FILIERE`
--

CREATE TABLE IF NOT EXISTS `FILIERE` (
  `NUMFILIERE` int(11) NOT NULL,
  `LIBELLEFILIERE` varchar(50) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`NUMFILIERE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `FILIERE`
--

INSERT INTO `FILIERE` (`NUMFILIERE`, `LIBELLEFILIERE`) VALUES
(1, 'Management des Unités Commerciales'),
(2, 'Comptabilité et Gestion des Organisations'),
(3, 'Informatique de Gestion'),
(4, 'Services Informatiques aux Organisations'),
(5, 'Diplôme de Comptabilité et de Gestion'),
(6, 'Formation Complémentaire d''Initiative Locale');

-- --------------------------------------------------------

--
-- Structure de la table `ORGANISATION`
--

CREATE TABLE IF NOT EXISTS `ORGANISATION` (
  `IDORGANISATION` int(10) NOT NULL AUTO_INCREMENT,
  `NOM_ORGANISATION` varchar(255) NOT NULL,
  `VILLE_ORGANISATION` varchar(128) NOT NULL,
  `ADRESSE_ORGANISATION` varchar(128) NOT NULL,
  `CP_ORGANISATION` bigint(5) NOT NULL,
  `TEL_ORGANISATION` varchar(10) NOT NULL,
  `FAX_ORGANISATION` varchar(10) DEFAULT 'NULL',
  `FORMEJURIDIQUE` varchar(10) NOT NULL,
  `ACTIVITE` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`IDORGANISATION`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `ORGANISATION`
--

INSERT INTO `ORGANISATION` (`IDORGANISATION`, `NOM_ORGANISATION`, `VILLE_ORGANISATION`, `ADRESSE_ORGANISATION`, `CP_ORGANISATION`, `TEL_ORGANISATION`, `FAX_ORGANISATION`, `FORMEJURIDIQUE`, `ACTIVITE`) VALUES
(1, 'ECOLES DES MINES', 'NANTES', '4 rue alfred kastler', 44300, '0251858100', '1574893129', 'SA', 'dev'),
(2, 'Info Transit', 'STHERBLAIN', 'rue de la roulette', 48520, '0305040207', '', 'SArl', 'res');

-- --------------------------------------------------------

--
-- Structure de la table `PERSONNE`
--

CREATE TABLE IF NOT EXISTS `PERSONNE` (
  `IDPERSONNE` int(11) NOT NULL AUTO_INCREMENT,
  `IDSPECIALITE` smallint(11) DEFAULT NULL,
  `IDROLE` smallint(6) NOT NULL,
  `CIVILITE` char(32) NOT NULL,
  `NOM` varchar(30) NOT NULL,
  `PRENOM` varchar(20) NOT NULL,
  `NUM_TEL` char(13) NOT NULL,
  `ADRESSE_MAIL` varchar(30) NOT NULL,
  `NUM_TEL_MOBILE` char(13) DEFAULT NULL,
  `ETUDES` varchar(40) DEFAULT 'NULL',
  `FORMATION` varchar(40) DEFAULT 'NULL',
  `LOGINUTILISATEUR` varchar(25) DEFAULT 'NULL',
  `MDPUTILISATEUR` varchar(40) DEFAULT 'NULL',
  PRIMARY KEY (`IDPERSONNE`),
  KEY `IDSPECIALITE` (`IDSPECIALITE`),
  KEY `IDROLE` (`IDROLE`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `PERSONNE`
--

INSERT INTO `PERSONNE` (`IDPERSONNE`, `IDSPECIALITE`, `IDROLE`, `CIVILITE`, `NOM`, `PRENOM`, `NUM_TEL`, `ADRESSE_MAIL`, `NUM_TEL_MOBILE`, `ETUDES`, `FORMATION`, `LOGINUTILISATEUR`, `MDPUTILISATEUR`) VALUES
(1, NULL, 1, 'Mr', 'Admin', 'admin', '0000000000', 'admin@gmail.com', '0000000000', 'NULL', 'NULL', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997'),
(2, 1, 4, 'Mr', 'DEMARLY', 'thomas', '0600000000', 'tdemarl@gmail.com', '0600000000', 'STI option ï¿½lectrotechnique', 'NULL', 'tdemarly', 'ff289fa7cd0ed8339f20a43fa5f032d32fedd1d8'),
(10, NULL, 3, 'Monsieur', 'test', 'test', '0000000000', 'test@gmail.com', '0000000000', NULL, NULL, 'prof', 'd4e0b39a9f9c10276357c6ece8a7e444fa2109cf'),
(12, NULL, 3, 'Monsieur', 'test1', 'test1', '0000000000', 'test1@gmail.com', '', '', '', 'prof32', 'd4e0b39a9f9c10276357c6ece8a7e444fa2109cf'),
(13, NULL, 4, 'Monsieur', 'test1', 'test1', '0000000000', 'test1@gmail.com', '', '', '', 'etudiant', '2df87b6c0bfbdb58b91c7a50ac9ca42b086db583');

-- --------------------------------------------------------

--
-- Structure de la table `PROMOTION`
--

CREATE TABLE IF NOT EXISTS `PROMOTION` (
  `ANNEESCOL` char(9) CHARACTER SET latin1 NOT NULL,
  `IDPERSONNE` int(11) NOT NULL,
  `NUMCLASSE` char(32) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`ANNEESCOL`,`IDPERSONNE`,`NUMCLASSE`),
  KEY `IDPERSONNE` (`IDPERSONNE`),
  KEY `NUMCLASSE` (`NUMCLASSE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ROLE`
--

CREATE TABLE IF NOT EXISTS `ROLE` (
  `IDROLE` smallint(6) NOT NULL,
  `RANG` smallint(6) NOT NULL,
  `LIBELLE` varchar(30) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`IDROLE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `ROLE`
--

INSERT INTO `ROLE` (`IDROLE`, `RANG`, `LIBELLE`) VALUES
(1, 1, 'Administrateur'),
(2, 2, 'Secrétaire'),
(3, 3, 'Professeur'),
(4, 4, 'Etudiant');

-- --------------------------------------------------------

--
-- Structure de la table `SPECIALITE`
--

CREATE TABLE IF NOT EXISTS `SPECIALITE` (
  `IDSPECIALITE` smallint(6) NOT NULL,
  `LIBELLECOURTSPECIALITE` varchar(10) CHARACTER SET latin1 NOT NULL,
  `LIBELLELONGSPECIALITE` varchar(50) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`IDSPECIALITE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `SPECIALITE`
--

INSERT INTO `SPECIALITE` (`IDSPECIALITE`, `LIBELLECOURTSPECIALITE`, `LIBELLELONGSPECIALITE`) VALUES
(1, 'SLAM', 'Solutions logicielles et applications métiers'),
(2, 'SISR', 'Solutions d''infrastructures systèmes et réseaux');

-- --------------------------------------------------------

--
-- Structure de la table `STAGE`
--

CREATE TABLE IF NOT EXISTS `STAGE` (
  `NUM_STAGE` int(11) NOT NULL,
  `ANNEESCOL` char(9) CHARACTER SET latin1 NOT NULL,
  `IDETUDIANT` int(11) NOT NULL,
  `IDPROFESSEUR` int(11) NOT NULL,
  `IDORGANISATION` varchar(10) CHARACTER SET latin1 NOT NULL,
  `IDMAITRESTAGE` int(11) NOT NULL,
  `DATEDEBUT` date NOT NULL,
  `DATEFIN` date NOT NULL,
  `DATEVISITESTAGE` date DEFAULT NULL,
  `VILLE` char(32) CHARACTER SET latin1 NOT NULL,
  `DIVERS` char(32) CHARACTER SET latin1 DEFAULT 'NULL',
  `BILANTRAVAUX` varchar(255) CHARACTER SET latin1 DEFAULT 'NULL',
  `RESSOURCESOUTILS` varchar(255) CHARACTER SET latin1 DEFAULT 'NULL',
  `COMMENTAIRES` varchar(255) CHARACTER SET latin1 DEFAULT 'NULL',
  `PARTICIPATIONCCF` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`NUM_STAGE`),
  KEY `I_FK_STAGE_ANNEESCOL` (`ANNEESCOL`),
  KEY `I_FK_STAGE_ORGANISATION` (`IDORGANISATION`),
  KEY `I_FK_STAGE_PERSONNE` (`IDMAITRESTAGE`),
  KEY `STAGE_IBFK_3` (`IDETUDIANT`),
  KEY `STAGE_IBFK_4` (`IDPROFESSEUR`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `CLASSE`
--
ALTER TABLE `CLASSE`
  ADD CONSTRAINT `CLASSE_ibfk_1` FOREIGN KEY (`IDSPECIALITE`) REFERENCES `SPECIALITE` (`IDSPECIALITE`),
  ADD CONSTRAINT `CLASSE_ibfk_2` FOREIGN KEY (`NUMFILIERE`) REFERENCES `FILIERE` (`NUMFILIERE`);

--
-- Contraintes pour la table `PERSONNE`
--
ALTER TABLE `PERSONNE`
  ADD CONSTRAINT `PERSONNE_ibfk_1` FOREIGN KEY (`IDSPECIALITE`) REFERENCES `SPECIALITE` (`IDSPECIALITE`),
  ADD CONSTRAINT `PERSONNE_ibfk_2` FOREIGN KEY (`IDROLE`) REFERENCES `ROLE` (`IDROLE`);

--
-- Contraintes pour la table `PROMOTION`
--
ALTER TABLE `PROMOTION`
  ADD CONSTRAINT `PROMOTION_ibfk_3` FOREIGN KEY (`ANNEESCOL`) REFERENCES `ANNEESCOL` (`ANNEESCOL`),
  ADD CONSTRAINT `PROMOTION_ibfk_4` FOREIGN KEY (`IDPERSONNE`) REFERENCES `PERSONNE` (`IDPERSONNE`),
  ADD CONSTRAINT `PROMOTION_ibfk_5` FOREIGN KEY (`NUMCLASSE`) REFERENCES `CLASSE` (`NUMCLASSE`);
