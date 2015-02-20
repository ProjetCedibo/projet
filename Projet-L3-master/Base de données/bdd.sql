-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Client :  localhost:8889
-- Généré le :  Lun 16 Février 2015 à 19:10
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
  `AdminPseudo` varchar(50) CHARACTER SET utf8 NOT NULL,
  `AdminPassWord` varchar(50) CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Admin`
--

INSERT INTO `Admin` (`AdminId`, `AdminPseudo`, `AdminPassWord`) VALUES
(1, 'Admin', '4e7afebcfbae000b22c7c85e5560f89a2a0280b4');

-- --------------------------------------------------------

--
-- Structure de la table `Agenda`
--

CREATE TABLE `Agenda` (
`AgendaId` int(11) NOT NULL,
  `AgendaDate` date NOT NULL,
  `AgendaWeek` int(11) NOT NULL,
  `AgendaTitle` text NOT NULL,
  `AgendaMessage` longtext NOT NULL,
  `AgendaType` varchar(100) NOT NULL,
  `AgendaAuthor` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Agenda`
--

INSERT INTO `Agenda` (`AgendaId`, `AgendaDate`, `AgendaWeek`, `AgendaTitle`, `AgendaMessage`, `AgendaType`, `AgendaAuthor`) VALUES
(1, '2015-02-13', 7, 'test', 'ceci est un test\r\ntest ligne 2\r\ntest ligne 3\r\ntest ligne 4\r\ntest ligne 5\r\ntest ligne 6', 'sjepg', 1),
(2, '2015-02-14', 7, 'pout', 'cioneaipubcieabcvpiueablbzabciziuizoc', '', 7);

-- --------------------------------------------------------

--
-- Structure de la table `Connection`
--

CREATE TABLE `Connection` (
`ConnectionId` int(11) NOT NULL,
  `ConnectionDate` date DEFAULT NULL,
  `ConnectionHour` time DEFAULT NULL,
  `ConnectionUser` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=130 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `Connection`
--

INSERT INTO `Connection` (`ConnectionId`, `ConnectionDate`, `ConnectionHour`, `ConnectionUser`) VALUES
(59, '2015-02-09', '01:08:05', 23),
(60, '2015-02-09', '01:10:43', 23),
(61, '2015-02-09', '01:11:08', 24),
(62, '2015-02-09', '12:40:45', 24),
(63, '2015-02-09', '12:59:03', 24),
(64, '2015-02-09', '15:22:36', 23),
(65, '2015-02-09', '17:27:44', 25),
(66, '2015-02-09', '17:35:31', 23),
(67, '2015-02-09', '17:48:33', 23),
(68, '2015-02-10', '00:10:57', 23),
(69, '2015-02-10', '00:11:29', 23),
(70, '2015-02-10', '00:12:07', 23),
(71, '2015-02-10', '00:12:53', 23),
(72, '2015-02-10', '02:42:28', 23),
(73, '2015-02-10', '02:43:10', 26),
(74, '2015-02-10', '02:48:02', 23),
(75, '2015-02-10', '02:49:23', 23),
(76, '2015-02-10', '08:18:35', 23),
(77, '2015-02-10', '22:04:16', 23),
(78, '2015-02-10', '22:13:33', 23),
(79, '2015-02-10', '22:18:20', 23),
(80, '2015-02-10', '22:44:21', 23),
(81, '2015-02-10', '22:53:36', 23),
(82, '2015-02-10', '23:15:38', 23),
(83, '2015-02-10', '23:17:08', 23),
(84, '2015-02-11', '09:32:26', 23),
(85, '2015-02-11', '09:32:53', 23),
(86, '2015-02-11', '10:37:25', 23),
(87, '2015-02-11', '10:37:36', 26),
(88, '2015-02-11', '10:38:09', 23),
(89, '2015-02-13', '00:12:06', 23),
(90, '2015-02-13', '10:17:22', 23),
(91, '2015-02-13', '10:17:59', 23),
(92, '2015-02-13', '10:30:59', 23),
(93, '2015-02-13', '10:31:17', 26),
(94, '2015-02-13', '10:34:03', 23),
(95, '2015-02-13', '10:35:19', 23),
(96, '2015-02-13', '10:38:57', 23),
(97, '2015-02-13', '10:39:15', 23),
(98, '2015-02-13', '11:56:25', 23),
(99, '2015-02-13', '11:57:08', 23),
(100, '2015-02-16', '01:09:31', 23),
(101, '2015-02-16', '01:10:51', 23),
(102, '2015-02-16', '01:11:46', 23),
(103, '2015-02-16', '01:12:28', 23),
(104, '2015-02-16', '01:19:26', 23),
(105, '2015-02-16', '01:20:26', 23),
(106, '2015-02-16', '01:22:31', 23),
(107, '2015-02-16', '01:23:17', 23),
(108, '2015-02-16', '01:23:55', 23),
(109, '2015-02-16', '01:24:26', 24),
(110, '2015-02-16', '01:24:44', 25),
(111, '2015-02-16', '01:25:13', 25),
(112, '2015-02-16', '01:25:26', 24),
(113, '2015-02-16', '01:25:50', 24),
(114, '2015-02-16', '01:27:45', 23),
(115, '2015-02-16', '01:30:11', 23),
(116, '2015-02-16', '01:30:52', 23),
(117, '2015-02-16', '01:33:38', 23),
(118, '2015-02-16', '01:33:53', 23),
(119, '2015-02-16', '01:34:34', 23),
(120, '2015-02-16', '01:41:35', 23),
(121, '2015-02-16', '01:41:49', 23),
(122, '2015-02-16', '01:55:15', 23),
(123, '2015-02-16', '01:55:56', 23),
(124, '2015-02-16', '01:56:11', 23),
(125, '2015-02-16', '01:56:29', 23),
(126, '2015-02-16', '15:35:45', 26),
(127, '2015-02-16', '15:36:10', 23),
(128, '2015-02-16', '15:36:21', 23),
(129, '2015-02-16', '15:44:53', 23);

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
-- Structure de la table `NotifSubscribers`
--

CREATE TABLE `NotifSubscribers` (
`idNotifSubscribers` int(11) NOT NULL,
  `NotifSubscribersToken` varchar(255) DEFAULT NULL,
  `UserId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `User`
--

CREATE TABLE `User` (
`UserId` int(11) NOT NULL,
  `UserDevice` varchar(255) NOT NULL,
  `UserModel` varchar(100) DEFAULT NULL,
  `UserOs` double DEFAULT NULL,
  `UserLogin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

--
-- Contenu de la table `User`
--

INSERT INTO `User` (`UserId`, `UserDevice`, `UserModel`, `UserOs`, `UserLogin`) VALUES
(23, '27A10E7B-897A-4BDA-B508-8F78972F144E', 'iPhone Simulator', 8.1, 1),
(24, '505FACBF-B778-4F36-9D0E-5C82113690C8', 'iPhone Simulator', 8.1, 1),
(25, 'CF680C62-A69E-4F56-8F2F-7CDFF2E50A01', 'iPhone Simulator', 8.1, 0),
(26, '84081C09-333B-4A2B-AB37-117FEC6298C3', 'iPhone Simulator', 8.1, 1);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `Admin`
--
ALTER TABLE `Admin`
 ADD PRIMARY KEY (`AdminId`);

--
-- Index pour la table `Agenda`
--
ALTER TABLE `Agenda`
 ADD PRIMARY KEY (`AgendaId`);

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
-- Index pour la table `NotifSubscribers`
--
ALTER TABLE `NotifSubscribers`
 ADD PRIMARY KEY (`idNotifSubscribers`);

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
-- AUTO_INCREMENT pour la table `Agenda`
--
ALTER TABLE `Agenda`
MODIFY `AgendaId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `Connection`
--
ALTER TABLE `Connection`
MODIFY `ConnectionId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=130;
--
-- AUTO_INCREMENT pour la table `Notification`
--
ALTER TABLE `Notification`
MODIFY `NotificationID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `NotifSubscribers`
--
ALTER TABLE `NotifSubscribers`
MODIFY `idNotifSubscribers` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `User`
--
ALTER TABLE `User`
MODIFY `UserId` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=27;