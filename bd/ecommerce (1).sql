-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 27 avr. 2021 à 23:06
-- Version du serveur :  8.0.21
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `ecommerce`
--
CREATE DATABASE IF NOT EXISTS `ecommerce` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `ecommerce`;

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id` int NOT NULL AUTO_INCREMENT,
  `prenom` varchar(150) NOT NULL,
  `nom` varchar(200) NOT NULL,
  `adresse` text NOT NULL,
  `ville` varchar(150) NOT NULL,
  `province` varchar(100) NOT NULL,
  `code_postal` varchar(6) NOT NULL,
  `usager` varchar(50) NOT NULL,
  `mot_passe` varchar(255) NOT NULL,
  `courriel` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usager` (`usager`),
  UNIQUE KEY `courriel` (`courriel`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id`, `prenom`, `nom`, `adresse`, `ville`, `province`, `code_postal`, `usager`, `mot_passe`, `courriel`) VALUES
(4, 'sdfsdf', 'fsdfsdf', 'sdfsdfsdfsdf', 'Sainte-Foy', 'sdfsdfsd', 'H0H0H0', '67458675856786', '123456', 'masterjim11@gmail.com'),
(5, 'Paul2', 'Houde', 'dasfsdfsad', 'Sainte-Foy', 'sadfsafd', 'H0H0H0', '45634564357465756745647', '123456', 'msdgfsdgsdfgsdfgsdfgm@gmail.com'),
(45, 'Yo', 'Bob', '2345 rue truc', 'L\'Ancienne-Lorette', 'QC', 'a1a1a1', 'SOS', '1', 'salu@hshs.s');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id` int NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `statut` enum('livré','erreur','en cours','') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `type_paiement` enum('chèque','comptant','crédit','paypal') CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `id_client` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_client` (`id_client`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(150) NOT NULL,
  `description` text NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `quantite` smallint NOT NULL,
  `date` date NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `nom`, `description`, `prix`, `quantite`, `date`, `image`) VALUES
(3, 'Bakemonogatari #01', 'Koyomi était un lycéen banal jusqu\'à sa rencontre avec une vampire légendaire qui, en le mordant, lui a transmis les mêmes pouvoirs qu\'elle. Un jour, il réalise qu\'une entité chimérique a pris possession d\'une de ses camarades, Hitagi, et qu\'il est le seul à pouvoir l\'aider !', '12.95', 0, '2018-03-14', 'Bakemonogatari_01.jpg'),
(4, 'Chainsaw Man #01', 'Pour rembourser ses dettes, Denji, jeune homme dans la dèche la plus totale, est exploité en tant que Devil Hunter avec son chien-démon-tronçonneuse, “Pochita”. Mais suite à une cruelle trahison, il voit enfin une possibilité de se tirer des bas-fonds où il croupit ! Devenu surpuissant après sa fusion avec Pochita, Denji est recruté par une organisation et part à la chasse aux démons…', '12.95', 2, '2019-03-14', 'ChainsawMan_01.png'),
(5, 'Death Note - Black Edition #01 (tome 1 & 2)', 'Light Yagami ramasse un étrange carnet oublié dans la cour de son lycée. Selon les instructions du carnet, la personne dont le nom est écrit dans les pages du Death Note mourra dans les 40 secondes !! Quelquesjours plus tard, Light fait la connaissance de l\'ancien propriétaire du carnet : Ryûk, un dieu de la mort ! Poussé par l\'ennui, il a fait entrer le carnet sur terre. Ryûk découvre alors que Light a déjà commencé à remplir son carnet...', '20.95', 5, '2010-12-28', 'DeathNote_BlackEdition_01.jpg'),
(6, 'Koe no Katachi #01', 'Shoya Ishida, habitant à Ōgaki dans la préfecture de Gifu, vit en combattant l\'ennui par les jeux les plus insensés qui lui viennent à l\'esprit. Un jour, Shoko Nishimiya rejoint sa classe d\'école primaire et essaie de s\'y faire une place, mais cette dernière est atteinte de surdité et va causer quelques soucis à ses camarades, ce qui va permettre au jeune Shoya de s\'occuper en profitant des faiblesses de celle-ci. Mais tout cet amusement se retournera contre lui. Une fois lycéen, Shoya, qui décide de revoir une dernière fois Shoko pour s\'excuser, va finalement se rapprocher d\'elle à travers la langue des signes.', '13.95', 6, '2015-01-22', 'KoeNoKatachi_01.jpg'),
(7, 'Tokyo Ghoul #01', 'À Tokyo, sévissent des goules, monstres cannibales se dissimulant parmi les humains pour mieux s\'en nourrir. Étudiant timide, Ken Kaneki est plus intéressé par la jolie fille qui partage ses goûts pour la lecture que par ces affaires sordides, jusqu\'au jour où il se faitattaquer par l\'une de ces fameuses créatures. Mortellement blessé, il survit grâce à la greffe des organes de son agresseur... Remis deson opération, il réalise peu à peu qu\'il est devenu incapable de se nourrir comme avant et commence à ressentir un appétit suspect envers ses congénères. C\'est le début d\'une descente aux enfers pour Kaneki, devenu malgré lui un hybride mi-humain, mi-goule.', '12.95', 11, '2016-12-19', 'TokyoGhoul_01.jpg'),
(8, 'Utsuro no Hako to Zero no Maria #01', 'Kazuki Hoshino chérit rien de plus que sa banale vie, et le 2 mars devait être un jour ordinaire. L\'arrivée d\'une étudiante transférée, la mystérieuse Aya Otonashi, ne devait pas bouleverser le monde qu\'il connaissait.\r\nAlors qu\'il n\'avait jamais vu cette fille auparavant, elle lui dit qu\'elle l\'a rencontré un millier de fois et déclare la \"guerre\" pour un crime dont il ne se souvient pas..', '18.95', 1, '2009-01-10', 'UtsuroNoHakoToZeroNoMaria_01.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `produit_commande`
--

DROP TABLE IF EXISTS `produit_commande`;
CREATE TABLE IF NOT EXISTS `produit_commande` (
  `id_produit` int NOT NULL,
  `id_commande` int NOT NULL,
  `quantite` smallint NOT NULL,
  PRIMARY KEY (`id_produit`,`id_commande`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
