-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : lun. 31 oct. 2022 à 18:32
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
-- Structure de la table `compte`
--

CREATE TABLE `compte` (
  `id_compte` int(11) NOT NULL,
  `pseudo_compte` varchar(255) NOT NULL,
  `email_compte` varchar(255) NOT NULL,
  `mdp_compte` varchar(255) NOT NULL,
  `statut_compte` enum('actif','inactif','supprime') NOT NULL,
  `type_compte` enum('dg','dd','dm','cm','am','stg') NOT NULL,
  `created_at_compte` datetime NOT NULL,
  `updated_at_compte` datetime NOT NULL,
  `deleted_at_compte` datetime NOT NULL,
  `id_utilisateur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `compte`
--

INSERT INTO `compte` (`id_compte`, `pseudo_compte`, `email_compte`, `mdp_compte`, `statut_compte`, `type_compte`, `created_at_compte`, `updated_at_compte`, `deleted_at_compte`, `id_utilisateur`) VALUES
(1, 'Arnaud', 'arnaudadjovi274@gmail.com', '5551666', 'actif', 'dg', '2022-08-19 22:47:46', '2022-08-19 22:47:46', '2022-08-19 22:47:46', 1),
(2, 'Eustache', 'g_eustache@yahoo.fr', '12345', 'actif', 'dg', '2022-08-19 22:47:46', '2022-08-19 22:47:46', '2022-08-19 22:47:46', 2),
(3, 'M. Mamavi', 'jgamamavi@gmx.fr', '12345', 'actif', 'dd', '2022-08-19 22:47:46', '2022-08-19 22:47:46', '2022-08-19 22:47:46', 3),
(4, 'Ismael', 'badarouismael@yahoo.com', '12345', 'actif', 'cm', '2022-08-19 22:47:46', '2022-08-19 22:47:46', '2022-08-19 22:47:46', 4),
(5, 'Vinolia', 'kinyidonadine@gmail.com', '12345', 'actif', 'cm', '2022-10-31 18:26:33', '2022-10-31 18:26:33', '2022-10-31 18:26:33', 5),
(6, 'Roméo', 'romeobakpe@gmail.com', '12345', 'actif', 'cm', '2022-10-31 18:26:33', '2022-10-31 18:26:33', '2022-10-31 18:26:33', 6),
(7, 'Sévérin', 'ssewade9@gmail.com', '12345', 'actif', 'cm', '2022-10-31 18:26:33', '2022-10-31 18:26:33', '2022-10-31 18:26:33', 7),
(8, 'Théophilia', 'theolatedjou@gmail.com', '12345', 'actif', 'cm', '2022-10-31 18:26:33', '2022-10-31 18:26:33', '2022-10-31 18:26:33', 8);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `nom_utilisateur` varchar(255) NOT NULL,
  `prenom_utilisateur` varchar(255) NOT NULL,
  `date_naiss_utilisateur` date NOT NULL,
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
(1, 'Adjovi', 'Arnaud', '2002-02-10', 'masculin', '+22968980983', 'blank.png', 'arnaudadjovi274@gmail.com', 'Cotonou/Gbenoukpo', '2022-08-19 22:45:05', '2022-08-19 22:45:05'),
(2, 'GBEHINTO', 'Eustache', '0000-00-00', 'masculin', ' + 22997221985', 'blank.png', 'g_eustache@yahoo.fr', '03 BP 4196 Jéricho', '2022-08-19 22:45:05', '2022-08-19 22:45:05'),
(3, 'Mamavi', 'Armand', '0000-00-00', 'masculin', '+22995968611', 'blank.png', 'jgamamavi@gmx.fr', 'Cotonou', '2022-08-19 22:45:05', '2022-08-19 22:45:05'),
(4, 'Badarou', 'Ismael', '0000-00-00', 'masculin', '+22997757587', 'blank.png', 'badarouismael@yahoo.com', 'Cotonou', '2022-08-19 22:45:05', '2022-08-19 22:45:05'),
(5, 'KINYIDO', 'Vinolia', '0000-00-00', 'feminin', '+22996539160', 'blank.png', 'kinyidonadine@gmail.com', 'Cotonou', '2022-10-31 17:49:00', '2022-10-31 17:49:00'),
(6, 'BAKPE', 'Roméo', '0000-00-00', 'masculin', '+22997153629', 'blank.png', 'romeobakpe@gmail.com', 'Cotonou', '2022-10-31 17:49:00', '2022-10-31 17:49:00'),
(7, 'SEWADE', 'Sévérin', '0000-00-00', 'masculin', '+22997153629', 'blank.png', 'ssewade9@gmail.com', 'Cotonou', '2022-10-31 17:49:00', '2022-10-31 17:49:00'),
(8, 'LATEDJOU', 'Théophilia', '0000-00-00', 'feminin', '+22963904744', 'blank.png', 'theolatedjou@gmail.com', 'Cotonou', '2022-10-31 17:49:00', '2022-10-31 17:49:00');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `compte`
--
ALTER TABLE `compte`
  ADD PRIMARY KEY (`id_compte`),
  ADD UNIQUE KEY `email_compte` (`email_compte`),
  ADD KEY `id_utilisateur` (`id_utilisateur`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_utilisateur`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `compte`
--
ALTER TABLE `compte`
  MODIFY `id_compte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `compte`
--
ALTER TABLE `compte`
  ADD CONSTRAINT `fk_compte_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id_utilisateur`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
