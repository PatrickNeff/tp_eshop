-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Ven 29 Mai 2015 à 16:26
-- Version du serveur: 5.5.41-0ubuntu0.14.04.1
-- Version de PHP: 5.5.9-1ubuntu4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `eshop`
--

-- --------------------------------------------------------

--
-- Structure de la table `adresse`
--

CREATE TABLE IF NOT EXISTS `adresse` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identifiant adresse',
  `client_id` int(5) NOT NULL COMMENT 'lien vers l''identifiant du client',
  `street` varchar(128) COLLATE utf8_bin NOT NULL COMMENT 'numéro et nom de rue',
  `zipcode` int(16) NOT NULL COMMENT 'code postal',
  `city` varchar(32) COLLATE utf8_bin NOT NULL COMMENT 'ville',
  `country` varchar(32) COLLATE utf8_bin NOT NULL COMMENT 'pays',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='table des adresses de nos client' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `id_category` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identifiant de la catégorie',
  `name` varchar(64) COLLATE utf8_bin NOT NULL COMMENT 'nom de la catégorie',
  `description` varchar(512) COLLATE utf8_bin NOT NULL COMMENT 'description de la catégorie',
  `time_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT 'date de la dzernière mAJ des catégories',
  PRIMARY KEY (`id_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='catégorie des produits de notre catalogue' AUTO_INCREMENT=9 ;

--
-- Contenu de la table `category`
--

INSERT INTO `category` (`id_category`, `name`, `description`, `time_update`) VALUES
(1, 'fruits', 'sérieux? vous savez pas ce que c''est qu''un fruit??? ', '2015-05-29 11:47:57'),
(2, 'legumes', 'sérieux? vous savez pas ce que c''est qu''un légume???', '2015-05-29 11:47:28'),
(5, 'fruits exotiques', 'des fruits pas de chez nous ', '2015-05-29 11:48:04'),
(6, 'fruits secs', 'des fruits pas très humides ', '2015-05-29 11:48:12');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `civility` varchar(4) COLLATE utf8_bin NOT NULL,
  `pseudo` varchar(32) COLLATE utf8_bin NOT NULL,
  `firstname` varchar(32) COLLATE utf8_bin NOT NULL,
  `lastname` varchar(32) COLLATE utf8_bin NOT NULL,
  `password` varchar(512) COLLATE utf8_bin NOT NULL,
  `email` varchar(64) COLLATE utf8_bin NOT NULL,
  `phone` int(20) NOT NULL,
  `groupe_id` int(2) NOT NULL,
  `permission_id` int(2) NOT NULL COMMENT 'lien vers la table des permissions',
  `time_register` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `time_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=75 ;

-- --------------------------------------------------------

--
-- Structure de la table `favorite`
--

CREATE TABLE IF NOT EXISTS `favorite` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identifiant du favori',
  `client_id` int(5) NOT NULL COMMENT 'lien vers l''identifiant du client',
  `product_id` int(5) NOT NULL COMMENT 'lien vers l''article préféré',
  `time_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'date de mise à jour des favoris',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='table des favoris' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `groupe`
--

CREATE TABLE IF NOT EXISTS `groupe` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identifiants de groupe de client',
  `name` varchar(64) COLLATE utf8_bin NOT NULL COMMENT 'nom du groupe de client',
  `description` varchar(512) COLLATE utf8_bin NOT NULL COMMENT 'description du groupe de client',
  `discount_rate` int(6) NOT NULL COMMENT 'taux de réduction en %',
  `discount_category` int(3) NOT NULL COMMENT 'lien vers la categorie concernée par la réduction',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='groupe de client auquel on peux affecter une réduction' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `note`
--

CREATE TABLE IF NOT EXISTS `note` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identifiants de la note',
  `client_id` int(3) NOT NULL COMMENT 'lien vers le client qui a posté la note',
  `product_id` int(3) NOT NULL COMMENT 'lien vers le produit concerné',
  `satisfaction` int(1) NOT NULL COMMENT 'note de 1 à 5 (5 : génial)',
  `comment` varchar(512) COLLATE utf8_bin NOT NULL COMMENT 'explications sur la note',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='commentaires sur les produits déposés par les clients' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `order`
--

CREATE TABLE IF NOT EXISTS `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identifiant de la commande',
  `client_id` int(5) NOT NULL COMMENT 'liens vers l''identifiant du client',
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'date de la commande',
  `payment_id` int(2) NOT NULL COMMENT 'moyen de payement',
  `order_rate` decimal(6,2) NOT NULL COMMENT 'taux global de réduction de la commande',
  `HT_price` decimal(8,2) NOT NULL COMMENT 'prix hors taxe',
  `TTC_price` decimal(8,2) NOT NULL COMMENT 'prix toutes taxes comprises',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='commande' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `order_item`
--

CREATE TABLE IF NOT EXISTS `order_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identifiants de chaque ligne de commande',
  `id_order` int(5) NOT NULL COMMENT 'lien vers la commande',
  `id_product` int(5) NOT NULL COMMENT 'lien vers le produit commandé',
  `weight` decimal(8,3) NOT NULL COMMENT 'poids total au kilo',
  `price_per_kilo` decimal(6,2) NOT NULL COMMENT 'prix au kilo',
  `rate_article` decimal(6,2) NOT NULL COMMENT 'réduction sur le produit',
  `price_before_rate` decimal(8,2) NOT NULL COMMENT 'prix total avant réduction sur l''article',
  `price_total` decimal(8,2) NOT NULL COMMENT 'prix total du produit',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='lignes de la commandes' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id du type de payement',
  `type` varchar(64) COLLATE utf8mb4_bin NOT NULL COMMENT 'type du paiement',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin COMMENT='moyen de paiement' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `permission`
--

CREATE TABLE IF NOT EXISTS `permission` (
  `id_permission` int(2) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8_bin NOT NULL,
  `description` varchar(255) COLLATE utf8_bin NOT NULL,
  `perms` int(16) NOT NULL,
  PRIMARY KEY (`id_permission`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=14 ;

--
-- Contenu de la table `permission`
--

INSERT INTO `permission` (`id_permission`, `name`, `description`, `perms`) VALUES
(1, 'utilisateur', 'affichemoi', 3),
(2, 'modÃ©rateur', 'droits modÃ©rateur', 127),
(3, 'administrateur', 'droits administrateur', 127);

-- --------------------------------------------------------

--
-- Structure de la table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id_product` int(4) NOT NULL AUTO_INCREMENT COMMENT 'identifiant de notre produit',
  `name` varchar(64) COLLATE utf8_bin NOT NULL COMMENT 'nom du produit',
  `description` varchar(512) COLLATE utf8_bin NOT NULL COMMENT 'description du produit',
  `sub_category_id` int(3) NOT NULL COMMENT 'lien vers la sous categorie du produit',
  `price` decimal(8,2) NOT NULL COMMENT 'prix au kilos',
  `image` varchar(512) COLLATE utf8_bin NOT NULL COMMENT 'lien vers l''image du produit',
  `origine` varchar(64) COLLATE utf8_bin NOT NULL COMMENT 'origine de notre produit',
  `stock_quantity` int(5) NOT NULL COMMENT 'quantité en stock (en kilos)',
  `note_id` int(3) NOT NULL COMMENT 'lien vers les notes sur le produit',
  `supplier_id` int(3) NOT NULL COMMENT 'lien vers la table des fournisseurs',
  PRIMARY KEY (`id_product`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='répertoire des produits de notre e-commerce' AUTO_INCREMENT=26 ;

--
-- Contenu de la table `product`
--

INSERT INTO `product` (`id_product`, `name`, `description`, `sub_category_id`, `price`, `image`, `origine`, `stock_quantity`, `note_id`, `supplier_id`) VALUES
(1, 'reines des reinettes', 'une des variétés préférées des amateurs de pommes', 1, 2.00, 'images/pomme-reine-des-reinettes.jpg', 'sud de la France', 200, 0, 0),
(2, 'granny smith', 'pomme avec un goût assez acidulé, très fermes, croquantes, juteuses, excellentes à cuire ou à croquer', 1, 2.00, 'images/pomme-granny-smith.jpg', 'sud de la France', 150, 0, 0),
(4, 'golden', 'pomme la plus cultivée puisqu''elle représente plus d''un tiers de la production nationale', 1, 1.80, 'images/pomme-golden.jpg', 'france', 180, 0, 0),
(5, 'boskoop', 'pomme à chair est ferme, finement acidulée et légèrement jaune et sucrée', 1, 1.00, 'images/pomme-boskoop.jpg', 'sais pas', 250, 0, 0),
(6, 'jonagold', 'pomme à à peau moyennement fine, grosse et parfumée', 1, 1.00, 'images/pomme-jonagold.jpg', 'allemagne', 240, 0, 0),
(7, 'antares', 'pomme d’aspect rustique obtenue dans les années 1990', 1, 2.00, 'images/pomme-antares.jpg', 'france', 10, 0, 0),
(8, 'conference', 'poire à couteau allongée en forme de bouteille, de taille moyenne.', 2, 2.20, 'images/poire-conference.jpg', 'portugal', 50, 0, 0),
(9, 'rochas', 'poire portugaise découverte en 1836', 2, 2.20, 'images/poire-rochas.jpg', 'portugal', 5, 0, 0),
(10, 'williams', 'poire assez grosse, juteuse, sucrée avec une pointe d’acidité. Sa chair blanche non granuleuse est très aromatique.', 2, 1.80, 'images/poire-williams.jpg', 'france', 0, 0, 0),
(11, 'clementine', 'ne clémentine se divise généralement en une dizaine de quartiers. Un quartier est parfois appelé une cuisse, un grain ou un taillon', 3, 1.60, 'images/clementine.jpg', 'maroc', 50, 0, 0),
(12, 'clemenvilla', 'mandarine sans pépin', 3, 1.80, 'images/clemenvilla.jpg', 'maroc', 100, 0, 0),
(13, 'minneola', 'fruit orangé, au zeste brillant et granuleux, juteux, la pulpe est d''une couleur oranger saturée', 3, 1.50, 'images/minneola.jpg', 'france', 50, 0, 0),
(14, 'orange', 'fruit de couleur orange qui possède une peau épaisse et assez rugueuse', 3, 1.80, 'images/orange.jpg', 'maroc', 20, 0, 0),
(15, 'fraises', 'faux fruit : réceptacle charnu sur lequel sont disposés régulièrement des akènes dans des alvéoles plus ou moins profondes, la fraise étant donc un polyakène.', 4, 5.00, 'images/fraise.jpg', 'sud de la france', 20, 0, 0),
(16, 'framboises', 'fruit issu de la transformation de la quarantaine de minuscules carpelles d''une seule et même fleur, qui se transforment en drupéoles semi-soudées', 4, 4.00, 'images/framboises.jpg', 'sud de la france', 20, 0, 0),
(17, 'epinards', 'demande à popeye!', 5, 1.60, 'images/epinard.jpg', 'alsace', 20, 0, 0),
(18, 'petits-pois', 'des trucs verts tout petits', 5, 2.00, 'images/petits-pois.jpg', 'alsace', 20, 0, 0),
(19, 'haricots verts', 'Les haricots verts cultivés sont des variétés de Phaseolus vulgaris, le haricot commun.', 5, 2.00, 'images/haricots-verts.jpg', 'alsace', 5, 0, 0),
(20, 'choux fleurs', 'Les variétés de choux-fleur fleurissent toute l''année. On parle donc de chou-fleur de printemps, d''été, d''automne et d''hiver.', 6, 1.50, 'images/choufleur.jpg', 'france', 5, 0, 0),
(21, 'brocoli', 'Choux d''Italie défini aussi comme "le petit rejeton que le tronc d''un vieux chou pousse après l''hiver". ', 6, 1.20, 'images/brocoli.jpg', 'france', 5, 0, 0),
(22, 'mangue', 'Délicieusement parfumée, juteuse et tendre, la mangue est un fruit charnu.', 7, 1.50, 'images/mangue.jpg', 'îles paradisiaques', 5, 0, 0),
(23, 'kiwi', 'fruits de plusieurs espèces de lianes du genre Actinidia, famille des Actinidiaceae', 8, 6.00, 'images/kiwi.jpg', 'îles paradisiaques', 10, 0, 0),
(24, 'ananas', 'tu connais pas?', 8, 3.00, 'images/ananas', 'îles paradisiaques', 20, 0, 0),
(25, 'noisettes', 'coquille akène doté d’un péricarpe ligneux appelé involucre ou quelquefois, par erreur, écale et renfermant une seule2 graine (l''amande) qui occupe normalement3 toute la cavité interne du péricarpe', 9, 5.00, 'images/noisettes.jpg', 'mon jardin :-)', 25, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `promotion`
--

CREATE TABLE IF NOT EXISTS `promotion` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identifiants de la promotion',
  `name` varchar(64) COLLATE utf8_bin NOT NULL COMMENT 'nom de la promotion',
  `description` varchar(512) COLLATE utf8_bin NOT NULL COMMENT 'description de la promotion',
  `scategory_id` int(5) NOT NULL COMMENT 'lien vers la sous catégorie qui bénéficie de la promotion',
  `rate` decimal(6,2) NOT NULL COMMENT 'taux de la promotion',
  `date_begin` date NOT NULL COMMENT 'date de début de promotion',
  `date_end` date NOT NULL COMMENT 'date de fin de promotion',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='promotion' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `sub_category`
--

CREATE TABLE IF NOT EXISTS `sub_category` (
  `id_sub_category` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identifiant de la sous catégorie',
  `name` varchar(64) COLLATE utf8_bin NOT NULL COMMENT 'nom de la sous catégorie',
  `description` varchar(512) COLLATE utf8_bin NOT NULL COMMENT 'description de la sous categorie',
  `category_id` int(2) NOT NULL COMMENT 'lien vers identifiant de la category',
  `time_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP COMMENT 'date la dernière mise à jour',
  PRIMARY KEY (`id_sub_category`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='sous categorie du produit' AUTO_INCREMENT=11 ;

--
-- Contenu de la table `sub_category`
--

INSERT INTO `sub_category` (`id_sub_category`, `name`, `description`, `category_id`, `time_update`) VALUES
(1, 'pommes', 'ben des pommes pardi!', 1, '0000-00-00 00:00:00'),
(2, 'poires', 'ben des poires pardi', 1, '0000-00-00 00:00:00'),
(3, 'agrumes', 'un truc bien juteux qui t''en laisse plein les doigts', 1, '0000-00-00 00:00:00'),
(4, 'fruits rouges', 'du gros rouge qui tache', 1, '0000-00-00 00:00:00'),
(5, 'legumes verts', 'interdit aux daltoniens', 2, '0000-00-00 00:00:00'),
(6, 'fleurs', 'certaines fleurs se mangent, eh oui!', 2, '2015-05-29 12:45:00'),
(7, 'avec noyaux', 'au milieu il y a un truc qui s’appelle noyau', 5, '0000-00-00 00:00:00'),
(8, 'sans noyaux', 'si tu recherche un noyaux, court toujours', 5, '0000-00-00 00:00:00'),
(9, 'noix', 'des noix, des noisettes, des amandes...', 6, '0000-00-00 00:00:00'),
(10, 'autres', 'tout sauf les noix et descendant', 6, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `supplier`
--

CREATE TABLE IF NOT EXISTS `supplier` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `civility` varchar(4) COLLATE utf8_bin NOT NULL,
  `pseudo` varchar(32) COLLATE utf8_bin NOT NULL,
  `firstname` varchar(32) COLLATE utf8_bin NOT NULL,
  `lastname` varchar(32) COLLATE utf8_bin NOT NULL,
  `password` varchar(512) COLLATE utf8_bin NOT NULL,
  `email` varchar(64) COLLATE utf8_bin NOT NULL,
  `street` varchar(64) COLLATE utf8_bin NOT NULL,
  `zipcode` int(16) NOT NULL,
  `city` varchar(32) COLLATE utf8_bin NOT NULL,
  `country` varchar(32) COLLATE utf8_bin NOT NULL,
  `phone` int(20) NOT NULL,
  `groupe` int(2) NOT NULL,
  `time_register` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `time_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=75 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
