-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Client :  localhost:8889
-- Généré le :  Sam 07 Février 2015 à 20:09
-- Version du serveur :  5.5.38
-- Version de PHP :  5.5.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Base de données :  `sjepg`
--

-- --------------------------------------------------------

--
-- Structure de la table `Admin`
--

CREATE TABLE `Admin` (
`AdminId` int(11) NOT NULL,
  `AdminPseudo` varchar(50) CHARACTER SET utf32 NOT NULL,
  `AdminPassWord` varchar(50) CHARACTER SET utf16 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Admin`
--

INSERT INTO `Admin` (`AdminId`, `AdminPseudo`, `AdminPassWord`) VALUES
(1, 'Admin', '4e7afebcfbae000b22c7c85e5560f89a2a0280b4');

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Structure de la table `User`
--

CREATE TABLE `User` (
`UserId` int(11) NOT NULL,
  `UserDevice` varchar(255) NOT NULL,
  `UserModel` varchar(100) DEFAULT NULL,
  `UserLogin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `User`
--

INSERT INTO `User` (`UserId`, `UserDevice`, `UserModel`, `UserLogin`) VALUES
(19, '3DADFF63-7831-472E-AE9C-48D149806A2F', NULL, 0);

-- --------------------------------------------------------

--
-- Structure de la table `Connection`
--

CREATE TABLE `Connection` (
`ConnectionId` int(11) NOT NULL,
  `ConnectionDate` date DEFAULT NULL,
  `ConnectionHour` time DEFAULT NULL,
  `ConnectionUser` int(11) NOT NULL REFERENCES User (UserId)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Connection`
--

INSERT INTO `Connection` (`ConnectionId`, `ConnectionDate`, `ConnectionHour`, `ConnectionUser`) VALUES
(33, '2015-02-07', '19:38:02', 0),
(34, '2015-02-07', '19:38:52', 0),
(35, '2015-02-07', '19:52:25', 0),
(36, '2015-02-07', '19:54:31', 19),
(37, '2015-02-07', '19:58:54', 19);

-- --------------------------------------------------------

--
-- Structure de la table `Notification`
--

CREATE TABLE `Notification` (
`NotificationID` int(11) NOT NULL,
  `NotifiactionText` varchar(255) NOT NULL,
  `NotificationBadge` int(11) NOT NULL,
  `AdminID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------


--
-- Index pour les tables exportées
--

--
-- Index pour la table `Admin`
--
ALTER TABLE `Admin`
 ADD PRIMARY KEY (`AdminId`);

--
-- Index pour la table `Connection`
--
ALTER TABLE `Connection`
 ADD PRIMARY KEY (`ConnectionId`);

--
-- Index pour la table `Notification`
--
ALTER TABLE `Notification`
 ADD PRIMARY KEY (`NotificationID`);

--
-- Index pour la table `User`
--
ALTER TABLE `User`
 ADD PRIMARY KEY (`UserId`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `Admin`
--
ALTER TABLE `Admin`
MODIFY `AdminId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `Connection`
--
ALTER TABLE `Connection`
MODIFY `ConnectionId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT pour la table `Notification`
--
ALTER TABLE `Notification`
MODIFY `NotificationID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `User`
--
ALTER TABLE `User`
MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;