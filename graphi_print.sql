-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mar. 07 mai 2024 à 10:17
-- Version du serveur : 8.2.0
-- Version de PHP : 8.2.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `graphi_print`
--

-- --------------------------------------------------------

--
-- Structure de la table `appartenir`
--

DROP TABLE IF EXISTS `appartenir`;
CREATE TABLE IF NOT EXISTS `appartenir` (
  `id_app` int NOT NULL AUTO_INCREMENT,
  `id_com` int NOT NULL,
  `id_cons` int NOT NULL,
  `qte_com` int DEFAULT NULL,
  PRIMARY KEY (`id_app`),
  KEY `appartient_consommable_fk` (`id_cons`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `appartenir`
--

INSERT INTO `appartenir` (`id_app`, `id_com`, `id_cons`, `qte_com`) VALUES
(1, 1, 1, 20),
(2, 1, 2, 12),
(3, 1, 14, 18),
(4, 1, 20, 11),
(5, 1, 17, 5),
(6, 2, 1, 250),
(7, 2, 2, 30),
(8, 2, 7, 500),
(9, 2, 10, 200),
(10, 2, 19, 30),
(11, 2, 27, 10),
(12, 3, 1, 100),
(13, 3, 3, 50),
(14, 3, 5, 25),
(15, 3, 7, 5),
(16, 3, 8, 3),
(17, 3, 18, 14),
(25, 4, 1, 12),
(26, 4, 2, 10);

--
-- Déclencheurs `appartenir`
--
DROP TRIGGER IF EXISTS `ajout_appartenir`;
DELIMITER $$
CREATE TRIGGER `ajout_appartenir` BEFORE INSERT ON `appartenir` FOR EACH ROW BEGIN
    IF NEW.id_com IS NOT NULL AND NEW.id_cons IS NOT NULL THEN
        -- Mettre à jour le nombre_com
        UPDATE Commande 
        SET nombre_com = nombre_com + 1
        WHERE id_com = NEW.id_com;

        -- Mettre à jour le montant_com
        UPDATE Commande 
        SET montant_com = montant_com + (SELECT prix_unitaire_cons FROM Consommable WHERE id_cons = NEW.id_cons) * NEW.qte_com
        WHERE id_com = NEW.id_com;
        
        -- Mettre à jour le qtestock_cons
        UPDATE Consommable
        SET qtestock_cons = qtestock_cons + NEW.qte_com
        WHERE id_cons = NEW.id_cons;
    END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `supprimer_appartenir`;
DELIMITER $$
CREATE TRIGGER `supprimer_appartenir` BEFORE DELETE ON `appartenir` FOR EACH ROW BEGIN
    -- Décrément le nombre_com de 1
    IF OLD.id_com IS NOT NULL AND OLD.id_cons IS NOT NULL THEN
        UPDATE Commande 
        SET nombre_com = nombre_com - 1 
        WHERE id_com = OLD.id_com;

        -- Réduire le montant_com en déduisant le prix de la consommable à supprimer
        UPDATE Commande 
        SET montant_com = montant_com - (SELECT prix_unitaire_cons FROM Consommable WHERE id_cons = OLD.id_cons)*OLD.qte_com 
        WHERE id_com = OLD.id_com;

        -- Augmenter la quantité du consommable
        UPDATE Consommable 
        SET qtestock_cons = qtestock_cons - OLD.qte_com 
        WHERE id_cons = OLD.id_cons;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id_cat` int NOT NULL AUTO_INCREMENT,
  `nom_cat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_cat`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id_cat`, `nom_cat`) VALUES
(1, 'Papeteries'),
(2, 'Encre'),
(3, 'Produits chimiques'),
(4, 'Toners'),
(5, 'Ruban'),
(6, 'EPI'),
(7, 'Produit de maintenance'),
(8, 'Stylos'),
(9, 'crayons'),
(10, 'Nettoyeur');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `id_com` int NOT NULL AUTO_INCREMENT,
  `date_com` date NOT NULL,
  `nombre_com` int NOT NULL DEFAULT '0',
  `montant_com` decimal(10,0) NOT NULL DEFAULT '0',
  `id_emp` int NOT NULL,
  `id_four` int DEFAULT NULL,
  PRIMARY KEY (`id_com`),
  KEY `commande_employe_fk` (`id_emp`),
  KEY `commande_fournisseur_fk` (`id_four`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`id_com`, `date_com`, `nombre_com`, `montant_com`, `id_emp`, `id_four`) VALUES
(1, '2024-02-11', 5, 66000, 3, 1),
(2, '2024-01-05', 6, 1020000, 4, 1),
(3, '2024-04-29', 6, 197000, 2, 1),
(4, '2024-05-07', 2, 22000, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `consommable`
--

DROP TABLE IF EXISTS `consommable`;
CREATE TABLE IF NOT EXISTS `consommable` (
  `id_cons` int NOT NULL AUTO_INCREMENT,
  `nom_cons` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `qtestock_cons` int NOT NULL,
  `qteseuil_cons` int NOT NULL,
  `id_cat` int NOT NULL,
  `prix_unitaire_cons` int DEFAULT '1000',
  `image` varchar(255) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_cons`),
  KEY `consommable_categorie_fk` (`id_cat`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `consommable`
--

INSERT INTO `consommable` (`id_cons`, `nom_cons`, `qtestock_cons`, `qteseuil_cons`, `id_cat`, `prix_unitaire_cons`, `image`) VALUES
(1, 'Papier A4', 82, 10, 1, 4000, 'C:\\wamp64\\www\\DEV\\image\\image_consommable\\papierA4.jpeg'),
(2, 'Papier A3', 12, 10, 1, 1000, NULL),
(3, 'Papier photo satiné', 6, 5, 1, 1000, NULL),
(4, 'Papier photo brillant', 18, 5, 1, 1000, NULL),
(5, 'Papier photo mat', 45, 5, 1, 1000, NULL),
(6, 'Papier photo lustré', 20, 5, 1, 1000, NULL),
(7, 'Encres acryliques à haut extrait sec (HSA)', 515, 2, 2, 1000, NULL),
(8, 'Encres prêtes à l\'emploi (RFU)', 3, 3, 2, 1000, NULL),
(9, 'INKTRONIC AG/AGCL 65:35', 5, 4, 2, 1000, NULL),
(10, 'INKTRONIC AG/AGCL 80:20', 203, 5, 2, 1000, NULL),
(11, 'Encres pour des applications spéciales UV', 25, 6, 2, 1000, NULL),
(12, 'Encres flexographiques UV', 35, 5, 2, 1000, NULL),
(13, 'Encres métalliques offset UV', 40, 4, 2, 1000, NULL),
(14, 'Encres blanches impression offset UV', 63, 3, 2, 1200, NULL),
(15, 'Encres à base d\'algues', 50, 4, 2, 1000, NULL),
(16, 'Encres pour le jet d’encre continu dévié (CIJ)', 55, 6, 2, 1000, NULL),
(17, 'Encres pour la goutte à la demande (DOD)', 65, 5, 2, 1000, NULL),
(18, 'Brother TN3480', 34, 5, 4, 1000, NULL),
(19, 'HP 44A CF244A Toner authentique noir', 50, 5, 4, 1000, NULL),
(20, 'Cartouche d\'encre générique équivalent à CANON 541XL', 31, 5, 4, 1000, NULL),
(21, 'Cartouche d\'encre FranceToner équivalent à CANON PG540XL', 20, 5, 4, 1000, NULL),
(22, 'Cartouches toner remanufacturée compatible avec BROTHER TN-2421', 20, 5, 4, 1000, NULL),
(23, 'Cartouches toner remanufacturée compatible avec HP CF259X', 20, 5, 4, 1000, NULL),
(24, 'Brother TN-243 CMYK', 20, 5, 4, 1000, NULL),
(25, 'Samsung CLT-P404C pack de 4 toners authentique', 20, 5, 4, 1000, NULL),
(26, 'Toner pour HP N°98A 92298 A', 12, 5, 4, 1000, NULL),
(27, 'LxTek TN1050', 30, 5, 4, 1000, NULL),
(28, 'HP 83A (CF283A) - Noir', 20, 5, 4, 1000, NULL),
(29, 'HP 30X (CF230X) - Noir haute capacité', 20, 5, 4, 1000, NULL),
(30, 'Cartouche de toner cyan Canon 067', 20, 5, 4, 1000, NULL),
(31, 'HP 220X (W2201X) - Cyan Haute Capacité', 20, 5, 4, 1000, NULL),
(32, 'Canon 718 - Magenta', 20, 5, 4, 1000, NULL),
(33, 'Brother TN-247 - Magenta', 20, 5, 4, 1000, NULL),
(34, 'Cartouche de toner jaune Canon 067H', 20, 5, 4, 1000, NULL),
(35, 'HP 117A (W2073A) - Jaune', 20, 5, 4, 1000, NULL),
(36, 'Acide nitrique', 10, 2, 2, 5000, NULL),
(37, 'Schneider Chinua Blue', 50, 15, 8, 2250, NULL),
(38, 'Schneider Chinua Red', 50, 15, 8, 2250, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `demander`
--

DROP TABLE IF EXISTS `demander`;
CREATE TABLE IF NOT EXISTS `demander` (
  `id_dem` int NOT NULL AUTO_INCREMENT,
  `id_emp` int NOT NULL,
  `id_cons` int NOT NULL,
  `qte_demande` int DEFAULT NULL,
  `date_demande` date DEFAULT NULL,
  PRIMARY KEY (`id_dem`),
  KEY `demande_consommable_fk` (`id_cons`)
) ENGINE=MyISAM AUTO_INCREMENT=42 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `demander`
--

INSERT INTO `demander` (`id_dem`, `id_emp`, `id_cons`, `qte_demande`, `date_demande`) VALUES
(1, 1, 1, 15, '2024-04-04'),
(5, 1, 2, 11, '2024-04-14'),
(4, 1, 1, 10, '2024-04-14'),
(6, 1, 3, 12, '2024-04-14'),
(7, 3, 4, 12, '2024-04-14'),
(8, 3, 5, 14, '2024-04-14'),
(9, 3, 4, 19, '2024-04-14'),
(10, 3, 5, 19, '2024-04-14'),
(11, 3, 4, 19, '2024-04-14'),
(12, 3, 5, 19, '2024-04-14'),
(13, 1, 1, 40, '2024-04-14'),
(14, 4, 2, 45, '2024-04-14'),
(15, 4, 3, 5, '2024-04-14'),
(16, 3, 2, 3, '2024-04-14'),
(17, 3, 3, 2, '2024-04-14'),
(18, 1, 1, 4, '2024-04-14'),
(19, 2, 4, 20, '2024-04-14'),
(20, 4, 9, 15, '2024-04-14'),
(21, 1, 1, 14, '2024-04-16'),
(22, 1, 2, 14, '2024-04-16'),
(23, 1, 10, 14, '2024-04-16'),
(24, 3, 4, 12, '0000-00-00'),
(25, 3, 11, 5, '0000-00-00'),
(26, 3, 26, 8, '0000-00-00'),
(27, 4, 1, 38, '2024-04-05'),
(28, 4, 5, 50, '2024-04-05'),
(29, 1, 1, 100, '2024-04-05'),
(30, 1, 2, 10, '2024-04-05'),
(31, 1, 3, 40, '2024-04-05'),
(32, 1, 4, 10, '2024-04-05'),
(33, 2, 1, 10, '2024-04-05'),
(34, 2, 2, 2, '2024-04-05'),
(35, 2, 8, 15, '2024-04-05'),
(36, 3, 1, 10, '2024-04-05'),
(37, 3, 3, 5, '2024-04-05'),
(38, 1, 1, 99, '2024-06-05'),
(39, 1, 10, 8, '2024-06-05'),
(40, 2, 1, 10, '2024-06-05'),
(41, 2, 2, 5, '2024-06-05');

--
-- Déclencheurs `demander`
--
DROP TRIGGER IF EXISTS `ajout_demande`;
DELIMITER $$
CREATE TRIGGER `ajout_demande` BEFORE INSERT ON `demander` FOR EACH ROW BEGIN
    DECLARE qte_stock INT;
    
    SELECT qtestock_cons INTO qte_stock FROM consommable WHERE id_cons = NEW.id_cons;
    
    IF NEW.qte_demande > qte_stock THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'La quantité en stock est insuffisante.';
    ELSE
        UPDATE consommable SET qtestock_cons = qtestock_cons - NEW.qte_demande WHERE id_cons = NEW.id_cons;
    END IF;
END
$$
DELIMITER ;
DROP TRIGGER IF EXISTS `supprime_demande`;
DELIMITER $$
CREATE TRIGGER `supprime_demande` BEFORE DELETE ON `demander` FOR EACH ROW BEGIN
    -- Augmenter la quantité du consommable en stock
    UPDATE Consommable
    SET qtestock_cons = qtestock_cons + OLD.qte_demande
    WHERE id_cons = OLD.id_cons;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `employe`
--

DROP TABLE IF EXISTS `employe`;
CREATE TABLE IF NOT EXISTS `employe` (
  `id_emp` int NOT NULL AUTO_INCREMENT,
  `nom_emp` varchar(75) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `prenom_emp` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_nais_emp` date NOT NULL,
  `date_embau_emp` date NOT NULL,
  `nationalite_emp` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `niveau_etu_emp` varchar(580) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `salaire_emp` decimal(10,2) NOT NULL,
  `lieu_res_emp` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email_emp` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `contact_emp` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `photo_emp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_serv` int DEFAULT NULL,
  `Sexe` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id_emp`),
  KEY `employe_service_fk` (`id_serv`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `employe`
--

INSERT INTO `employe` (`id_emp`, `nom_emp`, `prenom_emp`, `date_nais_emp`, `date_embau_emp`, `nationalite_emp`, `niveau_etu_emp`, `salaire_emp`, `lieu_res_emp`, `email_emp`, `contact_emp`, `photo_emp`, `id_serv`, `Sexe`) VALUES
(1, 'HELOU', 'Komlan Mawulé Mathias', '1996-05-14', '2022-02-01', 'Togolaise', 'Licence', 10000000.00, 'Libreville-Gabon', 'heloumawule@gmail.com', '+24174630473', 'C:\\wamp64\\www\\DEV\\image\\photo_employe\\IMG-20240330-WA0001.jpg', 3, 'Masculin'),
(2, 'HELOU', 'Kodjo Jules', '1991-04-08', '2019-11-05', 'Togolaise', 'CAP Electicité', 200000.00, 'Lomé', 'heloukodjododji@gmail.com', '+22893669653', 'C:\\wamp64\\www\\DEV\\image\\photo_employe\\frederic.jpg', 2, 'Masculin'),
(3, 'DONYO', 'Afivi Mawupémo Irène', '2000-06-28', '2023-10-07', 'Togolaise', ' BAC 2', 300000.00, 'Lomé_Togo', 'donyoreine@gmail.com', '+22893643213', 'C:\\wamp64\\www\\DEV\\image\\photo_employe\\reine.jpg', 1, 'Féminin'),
(4, 'DZIDJINYO', 'Komlan Maurice Yann', '1998-10-19', '2023-10-22', 'Togolaise', 'BAC D + 2', 300000.00, 'Lomé', 'mauriceyann05@gmail.com', '+22897821183', 'C:\\wamp64\\www\\DEV\\image\\photo_employe\\maurice.jpg', 4, 'Masculin');

-- --------------------------------------------------------

--
-- Structure de la table `fournisseur`
--

DROP TABLE IF EXISTS `fournisseur`;
CREATE TABLE IF NOT EXISTS `fournisseur` (
  `id_four` int NOT NULL AUTO_INCREMENT,
  `nom_four` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `adresse_four` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `contact_four` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`id_four`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `fournisseur`
--

INSERT INTO `fournisseur` (`id_four`, `nom_four`, `adresse_four`, `contact_four`) VALUES
(1, 'LARENA Enterprise', 'Paris Saclay Rue des Oliviers', '+3178453695');

-- --------------------------------------------------------

--
-- Structure de la table `service`
--

DROP TABLE IF EXISTS `service`;
CREATE TABLE IF NOT EXISTS `service` (
  `id_serv` int NOT NULL AUTO_INCREMENT,
  `nom_serv` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `description_serv` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `date_serv` date NOT NULL,
  `id_emp_resp` int DEFAULT NULL,
  PRIMARY KEY (`id_serv`),
  KEY `service_employe_2_fk` (`id_emp_resp`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `service`
--

INSERT INTO `service` (`id_serv`, `nom_serv`, `description_serv`, `date_serv`, `id_emp_resp`) VALUES
(1, 'Secrétariat', 'Il s\'occupe des toute la documentation de la société\n\n', '2022-01-01', 3),
(2, 'Maintenance', NULL, '2022-01-01', 2),
(3, 'Direction', '                                                                                                                                                                                                                                                                                                                                    ', '2024-04-24', 1),
(4, 'Production', '  Il est en charge de la production ( l\'accomplissement des tâches demandés par les clients de la société).                                                              ', '2022-01-01', 4),
(5, 'Comptabilité', 'Créer pour la suivie des dépenses et des revenues\n', '2024-04-29', 1),
(6, 'Cantine', '\n', '2024-04-29', 3),
(7, 'Publication', 'Organiser les campagnes de publicité sur les réseaux sociaux et les chaînes de télévisions                                                                        ', '2024-04-30', 3);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
