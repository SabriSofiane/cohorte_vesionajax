-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Jeu 05 Novembre 2020 à 14:01
-- Version du serveur :  10.1.41-MariaDB-0+deb9u1
-- Version de PHP :  7.0.33-0+deb9u6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `suiviFormulaire`
--

-- --------------------------------------------------------

--
-- Structure de la table `formationsPostbac`
--

CREATE TABLE `formationsPostbac` (
  `idFormationsPostbac` int(11) NOT NULL,
  `nomFormationsPostbac` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `formationsPostbac`
--

INSERT INTO `formationsPostbac` (`idFormationsPostbac`, `nomFormationsPostbac`) VALUES
(1, 'Formations courtes (BTS,DUT)'),
(2, 'Formations longues (licence,master,doctorat)'),
(3, 'Ecoles superieures'),
(4, 'Situation professionnelle'),
(5, 'Autres');

-- --------------------------------------------------------

--
-- Structure de la table `formationsPrebac`
--

CREATE TABLE `formationsPrebac` (
  `idFormationsPrebac` int(11) NOT NULL,
  `nomFormationsPrebac` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Contenu de la table `formationsPrebac`
--

INSERT INTO `formationsPrebac` (`idFormationsPrebac`, `nomFormationsPrebac`) VALUES
(1, 'TROISIEME-PM'),
(2, 'T-STI2D AC'),
(3, 'T-STI2D EE'),
(4, 'T-STI2D ITEC'),
(5, 'T-STI2D SIN'),
(6, 'T-S SI'),
(7, 'T-S SVT'),
(8, 'T-ES'),
(9, 'T-L'),
(10, 'T-STMG GF'),
(11, 'T-STMG M'),
(12, 'T-STMG RHC'),
(13, 'T-STMG SIG'),
(14, 'BACPRO-GA'),
(15, 'BACPRO-ARCU'),
(16, 'BACPRO-PDT'),
(17, 'BACPRO-SN'),
(18, 'BACPRO-TU'),
(19, 'BACPRO-PLP'),
(20, 'CAP-CIP');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `idUtilisateurs` int(11) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `prenom` varchar(100) DEFAULT NULL,
  `dateDeNaissance` date DEFAULT NULL,
  `numeroTel` varchar(15) DEFAULT NULL,
  `adresseEmail` varchar(150) DEFAULT NULL,
  `situationActuelle` int(11) DEFAULT NULL,
  `precisionSituation` varchar(150) NOT NULL,
  `classeFrequentee` int(11) DEFAULT NULL,
  `RGPD` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `vue_utilisateurs`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `vue_utilisateurs` (
`idUtilisateurs` int(11)
,`nom` varchar(100)
,`prenom` varchar(100)
,`dateDeNaissance` date
,`numeroTel` varchar(15)
,`adresseEmail` varchar(150)
,`nomFormationsPostbac` varchar(50)
,`nomFormationsPrebac` varchar(50)
,`precisionSituation` varchar(150)
);

-- --------------------------------------------------------

--
-- Structure de la vue `vue_utilisateurs`
--
DROP TABLE IF EXISTS `vue_utilisateurs`;

CREATE ALGORITHM=UNDEFINED DEFINER=`snir`@`localhost` SQL SECURITY DEFINER VIEW `vue_utilisateurs`  AS  select `utilisateurs`.`idUtilisateurs` AS `idUtilisateurs`,`utilisateurs`.`nom` AS `nom`,`utilisateurs`.`prenom` AS `prenom`,`utilisateurs`.`dateDeNaissance` AS `dateDeNaissance`,`utilisateurs`.`numeroTel` AS `numeroTel`,`utilisateurs`.`adresseEmail` AS `adresseEmail`,`formationsPostbac`.`nomFormationsPostbac` AS `nomFormationsPostbac`,`formationsPrebac`.`nomFormationsPrebac` AS `nomFormationsPrebac`,`utilisateurs`.`precisionSituation` AS `precisionSituation` from ((`utilisateurs` join `formationsPostbac`) join `formationsPrebac`) where ((`utilisateurs`.`situationActuelle` = `formationsPostbac`.`idFormationsPostbac`) and (`utilisateurs`.`classeFrequentee` = `formationsPrebac`.`idFormationsPrebac`)) ;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `formationsPostbac`
--
ALTER TABLE `formationsPostbac`
  ADD PRIMARY KEY (`idFormationsPostbac`);

--
-- Index pour la table `formationsPrebac`
--
ALTER TABLE `formationsPrebac`
  ADD PRIMARY KEY (`idFormationsPrebac`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`idUtilisateurs`),
  ADD UNIQUE KEY `utilisateur` (`nom`,`prenom`,`dateDeNaissance`),
  ADD KEY `classeFrequentee` (`classeFrequentee`),
  ADD KEY `situationActuelle` (`situationActuelle`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `formationsPostbac`
--
ALTER TABLE `formationsPostbac`
  MODIFY `idFormationsPostbac` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `formationsPrebac`
--
ALTER TABLE `formationsPrebac`
  MODIFY `idFormationsPrebac` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `idUtilisateurs` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD CONSTRAINT `utilisateurs_ibfk_1` FOREIGN KEY (`classeFrequentee`) REFERENCES `formationsPrebac` (`idFormationsPrebac`),
  ADD CONSTRAINT `utilisateurs_ibfk_2` FOREIGN KEY (`situationActuelle`) REFERENCES `formationsPostbac` (`idFormationsPostbac`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
