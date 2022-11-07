-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 07 nov. 2022 à 06:22
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ged`
--

-- --------------------------------------------------------

--
-- Structure de la table `assoc_client_collabo`
--

CREATE TABLE `assoc_client_collabo` (
  `id_assoc_client_collabo` int(11) NOT NULL,
  `role_assoc_client_collabo` enum('cm','am') NOT NULL,
  `statut_assoc_client_collabo` enum('actif','inactif') NOT NULL,
  `date_debut_assoc_client_collabo` datetime NOT NULL,
  `date_fin_assoc_client_collabo` datetime DEFAULT NULL,
  `created_at_assoc_client_collabo` datetime NOT NULL,
  `updated_at_assoc_client_collabo` datetime NOT NULL,
  `id_client` int(11) NOT NULL,
  `id_collaborateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `assoc_client_collabo`
--

INSERT INTO `assoc_client_collabo` (`id_assoc_client_collabo`, `role_assoc_client_collabo`, `statut_assoc_client_collabo`, `date_debut_assoc_client_collabo`, `date_fin_assoc_client_collabo`, `created_at_assoc_client_collabo`, `updated_at_assoc_client_collabo`, `id_client`, `id_collaborateur`) VALUES
(1, 'cm', 'inactif', '2022-11-03 17:33:25', '2022-11-04 08:48:53', '2022-11-03 17:33:25', '2022-11-04 08:48:53', 1, 2),
(2, 'cm', 'inactif', '2022-11-03 17:36:58', '2022-11-04 08:48:53', '2022-11-03 17:36:58', '2022-11-04 08:48:53', 3, 2),
(3, 'cm', 'inactif', '2022-11-04 08:23:32', '2022-11-06 23:15:46', '2022-11-04 08:23:32', '2022-11-06 23:15:46', 2, 6),
(4, 'cm', 'inactif', '2022-11-04 08:23:43', '2022-11-04 15:49:54', '2022-11-04 08:23:43', '2022-11-04 15:49:54', 1, 6),
(5, 'cm', 'inactif', '2022-11-04 08:23:54', '2022-11-04 15:49:54', '2022-11-04 08:23:54', '2022-11-04 15:49:54', 3, 6),
(6, 'cm', 'inactif', '2022-11-04 08:30:26', '2022-11-04 15:49:54', '2022-11-04 08:30:26', '2022-11-04 15:49:54', 1, 6),
(7, 'cm', 'inactif', '2022-11-04 08:31:09', '2022-11-04 15:49:54', '2022-11-04 08:31:09', '2022-11-04 15:49:54', 3, 6),
(8, 'cm', 'inactif', '2022-11-04 08:38:57', '2022-11-06 23:15:46', '2022-11-04 08:38:57', '2022-11-06 23:15:46', 2, 6),
(9, 'cm', 'inactif', '2022-11-04 08:40:31', '2022-11-04 15:49:54', '2022-11-04 08:40:31', '2022-11-04 15:49:54', 1, 6),
(10, 'cm', 'inactif', '2022-11-04 08:43:19', '2022-11-06 23:15:46', '2022-11-04 08:43:19', '2022-11-06 23:15:46', 2, 6),
(11, 'cm', 'inactif', '2022-11-04 08:46:07', '2022-11-04 15:49:54', '2022-11-04 08:46:07', '2022-11-04 15:49:54', 3, 6),
(12, 'cm', 'inactif', '2022-11-04 08:46:37', '2022-11-06 23:43:31', '2022-11-04 08:46:37', '2022-11-06 23:43:31', 4, 6),
(13, 'cm', 'inactif', '2022-11-04 08:47:23', '2022-11-06 23:15:51', '2022-11-04 08:47:23', '2022-11-06 23:15:51', 5, 6),
(14, 'cm', 'inactif', '2022-11-04 08:48:07', '2022-11-04 15:49:54', '2022-11-04 08:48:07', '2022-11-04 15:49:54', 6, 6),
(15, 'cm', 'inactif', '2022-11-04 08:57:34', '2022-11-04 15:49:54', '2022-11-04 08:57:34', '2022-11-04 15:49:54', 1, 6),
(16, 'cm', 'inactif', '2022-11-04 09:17:06', '2022-11-06 23:15:46', '2022-11-04 09:17:06', '2022-11-06 23:15:46', 2, 6),
(17, 'cm', 'inactif', '2022-11-04 13:44:56', '2022-11-04 15:49:54', '2022-11-04 13:44:56', '2022-11-04 15:49:54', 3, 6),
(18, 'cm', 'inactif', '2022-11-04 14:05:37', '2022-11-06 23:43:31', '2022-11-04 14:05:37', '2022-11-06 23:43:31', 4, 6),
(19, 'cm', 'inactif', '2022-11-04 14:07:38', '2022-11-04 15:49:54', '2022-11-04 14:07:38', '2022-11-04 15:49:54', 1, 6),
(20, 'cm', 'inactif', '2022-11-04 14:10:03', '2022-11-04 15:49:54', '2022-11-04 14:10:03', '2022-11-04 15:49:54', 1, 6),
(21, 'cm', 'inactif', '2022-11-04 14:12:25', '2022-11-06 23:15:46', '2022-11-04 14:12:25', '2022-11-06 23:15:46', 2, 6),
(22, 'cm', 'inactif', '2022-11-04 14:17:34', '2022-11-04 15:49:54', '2022-11-04 14:17:34', '2022-11-04 15:49:54', 1, 6),
(23, 'cm', 'inactif', '2022-11-04 14:21:25', '2022-11-04 15:49:54', '2022-11-04 14:21:25', '2022-11-04 15:49:54', 1, 6),
(24, 'cm', 'inactif', '2022-11-04 14:21:39', '2022-11-04 15:49:54', '2022-11-04 14:21:39', '2022-11-04 15:49:54', 3, 6),
(25, 'cm', 'inactif', '2022-11-04 14:21:55', '2022-11-06 23:15:46', '2022-11-04 14:21:55', '2022-11-06 23:15:46', 2, 6),
(26, 'cm', 'inactif', '2022-11-04 14:32:39', '2022-11-04 15:49:54', '2022-11-04 14:32:39', '2022-11-04 15:49:54', 1, 6),
(27, 'cm', 'inactif', '2022-11-04 14:32:53', '2022-11-04 15:49:54', '2022-11-04 14:32:53', '2022-11-04 15:49:54', 6, 6),
(28, 'cm', 'inactif', '2022-11-04 14:33:05', '2022-11-06 23:43:31', '2022-11-04 14:33:05', '2022-11-06 23:43:31', 4, 6),
(29, 'cm', 'inactif', '2022-11-04 15:49:13', '2022-11-04 15:49:54', '2022-11-04 15:49:13', '2022-11-04 15:49:54', 1, 6),
(30, 'cm', 'inactif', '2022-11-04 15:49:33', '2022-11-06 23:15:46', '2022-11-04 15:49:33', '2022-11-06 23:15:46', 2, 6),
(31, 'cm', 'inactif', '2022-11-04 15:50:16', '2022-11-06 23:15:46', '2022-11-04 15:50:16', '2022-11-06 23:15:46', 2, 6),
(32, 'cm', 'inactif', '2022-11-04 15:50:32', '2022-11-06 23:43:31', '2022-11-04 15:50:32', '2022-11-06 23:43:31', 4, 6),
(33, 'cm', 'actif', '2022-11-04 16:01:36', NULL, '2022-11-04 16:01:36', '2022-11-04 16:01:36', 1, 6),
(34, 'cm', 'inactif', '2022-11-05 01:30:58', '2022-11-05 12:37:18', '2022-11-05 01:30:58', '2022-11-05 12:37:18', 3, 1),
(35, 'cm', 'inactif', '2022-11-05 10:39:30', '2022-11-05 11:30:52', '2022-11-05 10:39:30', '2022-11-05 11:30:52', 3, 3),
(36, 'cm', 'inactif', '2022-11-05 11:15:20', '2022-11-05 11:30:52', '2022-11-05 11:15:20', '2022-11-05 11:30:52', 2, 3),
(37, 'cm', 'inactif', '2022-11-05 11:30:59', '2022-11-06 23:15:46', '2022-11-05 11:30:59', '2022-11-06 23:15:46', 2, 6),
(38, 'cm', 'inactif', '2022-11-05 12:32:02', '2022-11-05 12:37:18', '2022-11-05 12:32:02', '2022-11-05 12:37:18', 3, 1),
(39, 'cm', 'inactif', '2022-11-06 23:15:07', '2022-11-06 23:43:31', '2022-11-06 23:15:07', '2022-11-06 23:43:31', 4, 6),
(40, 'cm', 'inactif', '2022-11-06 23:15:16', '2022-11-06 23:15:51', '2022-11-06 23:15:16', '2022-11-06 23:15:51', 5, 6),
(41, 'cm', 'actif', '2022-11-06 23:15:26', NULL, '2022-11-06 23:15:26', '2022-11-06 23:15:26', 6, 6);

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id_client` int(11) NOT NULL,
  `matricule_client` varchar(255) NOT NULL,
  `code_view_client` varchar(255) NOT NULL,
  `prise_en_charge_client` enum('oui','non') NOT NULL,
  `id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id_client`, `matricule_client`, `code_view_client`, `prise_en_charge_client`, `id_utilisateur`) VALUES
(1, 'DEC-12001', 'wgfshghhdgfKJHFGSss', 'oui', 9),
(2, 'DEC-12002', 'wgfshghhdgfKJHFGSss', 'non', 10),
(3, 'DEC-12003', 'hgfgfhhdgfKJHFGSss', 'non', 11),
(4, 'DEC-12004', 'kjgfuyftgfKjkkgHFGSss', 'non', 12),
(5, 'DEC-12005', 'kjhghfgfhdgfKJHFGSss', 'non', 13),
(6, 'DEC-12006', '1fdg5fd64f6hdgfKJHFGSss', 'oui', 14);

-- --------------------------------------------------------

--
-- Structure de la table `collaborateur`
--

CREATE TABLE `collaborateur` (
  `id_collaborateur` int(11) NOT NULL,
  `code_collaborateur` int(11) NOT NULL,
  `code_view_collaborateur` varchar(255) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `id_departement` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `collaborateur`
--

INSERT INTO `collaborateur` (`id_collaborateur`, `code_collaborateur`, `code_view_collaborateur`, `id_utilisateur`, `id_departement`) VALUES
(1, 11001, 'JKGgJHJGTDFughuvbik', 3, 1),
(2, 11002, '4fg5dHJGTDFughuvbik', 4, 1),
(3, 11003, 'SKJHERZJGTDFughuvbik', 5, 1),
(4, 11004, 'zertyGTDFughuvbik', 6, 1),
(5, 11005, 'dhfiozJGTDFughuvbik', 7, 1),
(6, 11006, 'jfhozGTDFughuvbik', 8, 1);

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

CREATE TABLE `compte` (
  `id_compte` int(11) NOT NULL,
  `pseudo_compte` varchar(255) NOT NULL,
  `email_compte` varchar(255) NOT NULL,
  `mdp_compte` varchar(255) NOT NULL,
  `statut_compte` enum('actif','inactif','supprime') NOT NULL,
  `type_compte` enum('ag','dd','dm','cm','am','stg','client') NOT NULL,
  `auth_means_compte` enum('EMAIL_AND_PASSWORD','GOOGLE_OAUTH2.0','FACEBOOK_OAUTH2.0') NOT NULL,
  `created_at_compte` datetime NOT NULL,
  `updated_at_compte` datetime NOT NULL,
  `deleted_at_compte` datetime NOT NULL,
  `id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `compte`
--

INSERT INTO `compte` (`id_compte`, `pseudo_compte`, `email_compte`, `mdp_compte`, `statut_compte`, `type_compte`, `auth_means_compte`, `created_at_compte`, `updated_at_compte`, `deleted_at_compte`, `id_utilisateur`) VALUES
(1, 'Arnaud', 'arnaudadjovi274@gmail.com', '5551666', 'actif', 'ag', 'EMAIL_AND_PASSWORD', '2022-08-19 22:47:46', '2022-08-19 22:47:46', '2022-08-19 22:47:46', 1),
(2, 'Eustache', 'g_eustache@yahoo.fr', '12345', 'actif', 'ag', 'EMAIL_AND_PASSWORD', '2022-08-19 22:47:46', '2022-08-19 22:47:46', '2022-08-19 22:47:46', 2),
(3, 'M. Mamavi', 'jgamamavi@gmx.fr', '12345', 'actif', 'dd', 'EMAIL_AND_PASSWORD', '2022-08-19 22:47:46', '2022-08-19 22:47:46', '2022-08-19 22:47:46', 3),
(4, 'Ismael', 'badarouismael@yahoo.com', '12345', 'inactif', 'cm', 'EMAIL_AND_PASSWORD', '2022-08-19 22:47:46', '2022-08-19 22:47:46', '2022-08-19 22:47:46', 4),
(5, 'Vinolia', 'kinyidonadine@gmail.com', '12345', 'inactif', 'cm', 'EMAIL_AND_PASSWORD', '2022-10-31 18:26:33', '2022-10-31 18:26:33', '2022-10-31 18:26:33', 5),
(6, 'Roméo', 'romeobakpe@gmail.com', '12345', 'actif', 'cm', 'EMAIL_AND_PASSWORD', '2022-10-31 18:26:33', '2022-10-31 18:26:33', '2022-10-31 18:26:33', 6),
(7, 'Sévérin', 'ssewade9@gmail.com', '12345', 'actif', 'cm', 'EMAIL_AND_PASSWORD', '2022-10-31 18:26:33', '2022-10-31 18:26:33', '2022-10-31 18:26:33', 7),
(8, 'Théophilia', 'theolatedjou@gmail.com', '12345', 'actif', 'cm', 'EMAIL_AND_PASSWORD', '2022-10-31 18:26:33', '2022-10-31 18:26:33', '2022-10-31 18:26:33', 8),
(9, 'Pylones', 'pharmacielespylones@gmail.com', '12345', 'actif', 'client', 'EMAIL_AND_PASSWORD', '2022-11-02 12:22:28', '2022-11-02 12:22:28', '2022-11-02 12:22:28', 9),
(10, 'ATV', 'afriquetransportv@gmail.com', '12345', 'actif', 'client', 'EMAIL_AND_PASSWORD', '2022-11-02 12:23:20', '2022-11-02 12:23:20', '2022-11-02 12:23:20', 10),
(11, 'Aigles', 'lesaigles@gmail.com', '12345', 'inactif', 'client', 'EMAIL_AND_PASSWORD', '2022-11-02 12:23:59', '2022-11-02 12:23:59', '2022-11-02 12:23:59', 11),
(12, 'Neurotech', 'contact@groupeneurotech.com', '12345', 'actif', 'client', 'EMAIL_AND_PASSWORD', '2022-11-02 12:24:54', '2022-11-02 12:24:54', '2022-11-02 12:24:54', 12),
(13, 'Bera', 'contact@bera.com', '12345', 'actif', 'client', 'EMAIL_AND_PASSWORD', '2022-11-02 12:25:47', '2022-11-02 12:25:47', '2022-11-02 12:25:47', 13),
(14, 'Hermes', 'contact@hermes.com', '12345', 'actif', 'client', 'EMAIL_AND_PASSWORD', '2022-11-02 12:26:34', '2022-11-02 12:26:34', '2022-11-02 12:26:34', 14);

-- --------------------------------------------------------

--
-- Structure de la table `departement`
--

CREATE TABLE `departement` (
  `id_departement` int(11) NOT NULL,
  `sigle_departement` varchar(11) NOT NULL,
  `nom_departement` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `departement`
--

INSERT INTO `departement` (`id_departement`, `sigle_departement`, `nom_departement`) VALUES
(1, 'DEC', 'Département d\'expertise comptable'),
(2, 'DAC', 'Département d\'audit et de commissariat aux comptes'),
(3, 'DC', 'Département conseils');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `nom_utilisateur` varchar(255) NOT NULL,
  `prenom_utilisateur` varchar(255) NOT NULL,
  `date_naiss_utilisateur` date DEFAULT NULL,
  `sexe_utilisateur` enum('masculin','feminin') NOT NULL,
  `tel_utilisateur` varchar(255) NOT NULL,
  `avatar_utilisateur` varchar(255) NOT NULL,
  `email_utilisateur` varchar(255) NOT NULL,
  `adresse_utilisateur` text NOT NULL,
  `created_at_utilisateur` datetime NOT NULL,
  `updated_at_utilisateur` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `nom_utilisateur`, `prenom_utilisateur`, `date_naiss_utilisateur`, `sexe_utilisateur`, `tel_utilisateur`, `avatar_utilisateur`, `email_utilisateur`, `adresse_utilisateur`, `created_at_utilisateur`, `updated_at_utilisateur`) VALUES
(1, 'ADJOVI', 'Arnaud', '2002-02-10', 'masculin', '+22968980983', 'blank.png', 'arnaudadjovi274@gmail.com', 'Cotonou/Gbenoukpo', '2022-08-19 22:45:05', '2022-08-19 22:45:05'),
(2, 'GBEHINTO', 'Eustache', NULL, 'masculin', ' + 22997221985', 'blank.png', 'g_eustache@yahoo.fr', '03 BP 4196 Jéricho', '2022-08-19 22:45:05', '2022-08-19 22:45:05'),
(3, 'MAMAVI', 'Armand', NULL, 'masculin', '+22995968611', 'blank.png', 'jgamamavi@gmx.fr', 'Cotonou', '2022-08-19 22:45:05', '2022-08-19 22:45:05'),
(4, 'BADAROU', 'Ismael', NULL, 'masculin', '+22997757587', 'blank.png', 'badarouismael@yahoo.com', 'Cotonou', '2022-08-19 22:45:05', '2022-08-19 22:45:05'),
(5, 'KINYIDO', 'Vinolia', NULL, 'feminin', '+22996539160', 'blank.png', 'kinyidonadine@gmail.com', 'Cotonou', '2022-10-31 17:49:00', '2022-10-31 17:49:00'),
(6, 'BAKPE', 'Roméo', NULL, 'masculin', '+22997153629', 'blank.png', 'romeobakpe@gmail.com', 'Cotonou', '2022-10-31 17:49:00', '2022-10-31 17:49:00'),
(7, 'SEWADE', 'Sévérin', NULL, 'masculin', '+22997153629', 'blank.png', 'ssewade9@gmail.com', 'Cotonou', '2022-10-31 17:49:00', '2022-10-31 17:49:00'),
(8, 'LATEDJOU', 'Théophilia', NULL, 'feminin', '+22963904744', 'blank.png', 'theolatedjou@gmail.com', 'Cotonou', '2022-10-31 17:49:00', '2022-10-31 17:49:00'),
(9, 'PHARMACIE LES PYLONES', '', NULL, '', '(+229)21381514', '', 'pharmacielespylones@gmail.com', 'Lot 3478, Trafic local Godomè, Kouhounou\r\nAgla - 10 BP 156\r\nCotonou - Bénin', '2022-11-02 11:50:16', '2022-11-02 11:50:16'),
(10, 'ATV (AFRIQUE TRANSPORT VOYAGE)', '', NULL, '', '(+229)67842525', '', 'afriquetransportv@gmail.com', 'Lot pharmacie de l’étoile rouge (Presque en face de la BOA – Etoile)\nCotonou - Bénin', '2022-11-02 11:50:16', '2022-11-02 11:50:16'),
(11, 'LES AIGLES', '', NULL, '', '(+229)67842525', '', 'lesaigles@gmail.com', 'Cotonou - Bénin', '2022-11-02 11:50:16', '2022-11-02 11:50:16'),
(12, 'NEUROTECH', '', NULL, '', '(+221)338699090', '', 'contact@groupeneurotech.com', 'Siège Dakar: 8, Boulevard du Sud - Point E - BP : 14 276 - Dakar – Sénégal', '2022-11-02 11:50:16', '2022-11-02 11:50:16'),
(13, 'BERAKAH PLUS', '', NULL, '', '(+229)12345678', '', 'contact@bera.com', 'Cotonou - Benin', '2022-11-02 11:50:16', '2022-11-02 11:50:16'),
(14, 'HERMES COMMUNICATION', '', NULL, '', '(+229)12345678', '', 'contact@hermes.com', 'Cotonou - Benin', '2022-11-02 11:50:16', '2022-11-02 11:50:16');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `assoc_client_collabo`
--
ALTER TABLE `assoc_client_collabo`
  ADD PRIMARY KEY (`id_assoc_client_collabo`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `id_collaborateur` (`id_collaborateur`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id_client`),
  ADD KEY `fk_client_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `collaborateur`
--
ALTER TABLE `collaborateur`
  ADD PRIMARY KEY (`id_collaborateur`),
  ADD KEY `id_utilisateur` (`id_utilisateur`),
  ADD KEY `id_departement` (`id_departement`);

--
-- Index pour la table `compte`
--
ALTER TABLE `compte`
  ADD PRIMARY KEY (`id_compte`),
  ADD UNIQUE KEY `email_compte` (`email_compte`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `departement`
--
ALTER TABLE `departement`
  ADD PRIMARY KEY (`id_departement`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_utilisateur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `assoc_client_collabo`
--
ALTER TABLE `assoc_client_collabo`
  MODIFY `id_assoc_client_collabo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `collaborateur`
--
ALTER TABLE `collaborateur`
  MODIFY `id_collaborateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `compte`
--
ALTER TABLE `compte`
  MODIFY `id_compte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `departement`
--
ALTER TABLE `departement`
  MODIFY `id_departement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `assoc_client_collabo`
--
ALTER TABLE `assoc_client_collabo`
  ADD CONSTRAINT `fk_assoc_client_collabo_client` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`),
  ADD CONSTRAINT `fk_assoc_client_collabo_collaborateur` FOREIGN KEY (`id_collaborateur`) REFERENCES `collaborateur` (`id_collaborateur`);

--
-- Contraintes pour la table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `fk_client_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `collaborateur`
--
ALTER TABLE `collaborateur`
  ADD CONSTRAINT `fk_collaborateur_departement` FOREIGN KEY (`id_departement`) REFERENCES `departement` (`id_departement`),
  ADD CONSTRAINT `fk_collaborateur_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `compte`
--
ALTER TABLE `compte`
  ADD CONSTRAINT `fk_compte_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
