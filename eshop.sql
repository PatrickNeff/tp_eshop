-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='catégorie des produits de notre catalogue' AUTO_INCREMENT=1 ;
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
`groupe` int(2) NOT NULL,
`time_register` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
`time_update` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=75 ;
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
`order_rate` decimal(6,0) NOT NULL COMMENT 'taux global de réduction de la commande',
`HT_price` decimal(10,0) NOT NULL COMMENT 'prix hors taxe',
`TTC_price` decimal(10,0) NOT NULL COMMENT 'prix toutes taxes comprises',
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
`weight` decimal(8,0) NOT NULL COMMENT 'poids total au kilo',
`price_per_kilo` decimal(8,0) NOT NULL COMMENT 'prix au kilo',
`rate_article` decimal(8,0) NOT NULL COMMENT 'réduction sur le produit',
`price_before_rate` decimal(8,0) NOT NULL COMMENT 'prix total avant réduction sur l''article',
`price_total` decimal(8,0) NOT NULL COMMENT 'prix total du produit',
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
-- Structure de la table `product`
-- 
CREATE TABLE IF NOT EXISTS `product` (
`id_product` int(4) NOT NULL AUTO_INCREMENT COMMENT 'identifiant de notre produit',
`name` varchar(64) COLLATE utf8_bin NOT NULL COMMENT 'nom du produit',
`description` varchar(512) COLLATE utf8_bin NOT NULL COMMENT 'description du produit',
`sub_category_id` int(3) NOT NULL COMMENT 'lien vers la sous categorie du produit',
`price` decimal(10,0) NOT NULL COMMENT 'prix au kilos',
`image` varchar(512) COLLATE utf8_bin NOT NULL COMMENT 'lien vers l''image du produit',
`origine` varchar(64) COLLATE utf8_bin NOT NULL COMMENT 'origine de notre produit',
`stock_quantity` int(5) NOT NULL COMMENT 'quantité en stock (en kilos)',
`note_id` int(3) NOT NULL COMMENT 'lien vers les notes sur le produit',
`supplier_id` int(3) NOT NULL COMMENT 'lien vers la table des fournisseurs',
PRIMARY KEY (`id_product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='répertoire des produits de notre e-commerce' AUTO_INCREMENT=1 ;
-- --------------------------------------------------------
-- 
-- Structure de la table `promotion`
-- 
CREATE TABLE IF NOT EXISTS `promotion` (
`id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identifiants de la promotion',
`name` varchar(64) COLLATE utf8_bin NOT NULL COMMENT 'nom de la promotion',
`description` varchar(512) COLLATE utf8_bin NOT NULL COMMENT 'description de la promotion',
`scategory_id` int(5) NOT NULL COMMENT 'lien vers la sous catégorie qui bénéficie de la promotion',
`rate` decimal(8,0) NOT NULL COMMENT 'taux de la promotion',
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='sous categorie du produit' AUTO_INCREMENT=1 ;
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=75 ;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
=======

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='catégorie des produits de notre catalogue' AUTO_INCREMENT=1 ;

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
  `groupe` int(2) NOT NULL,
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
  `order_rate` decimal(6,0) NOT NULL COMMENT 'taux global de réduction de la commande',
  `HT_price` decimal(10,0) NOT NULL COMMENT 'prix hors taxe',
  `TTC_price` decimal(10,0) NOT NULL COMMENT 'prix toutes taxes comprises',
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
  `weight` decimal(8,0) NOT NULL COMMENT 'poids total au kilo',
  `price_per_kilo` decimal(8,0) NOT NULL COMMENT 'prix au kilo',
  `rate_article` decimal(8,0) NOT NULL COMMENT 'réduction sur le produit',
  `price_before_rate` decimal(8,0) NOT NULL COMMENT 'prix total avant réduction sur l''article',
  `price_total` decimal(8,0) NOT NULL COMMENT 'prix total du produit',
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
-- Structure de la table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `id_product` int(4) NOT NULL AUTO_INCREMENT COMMENT 'identifiant de notre produit',
  `name` varchar(64) COLLATE utf8_bin NOT NULL COMMENT 'nom du produit',
  `description` varchar(512) COLLATE utf8_bin NOT NULL COMMENT 'description du produit',
  `sub_category_id` int(3) NOT NULL COMMENT 'lien vers la sous categorie du produit',
  `price` decimal(10,0) NOT NULL COMMENT 'prix au kilos',
  `image` varchar(512) COLLATE utf8_bin NOT NULL COMMENT 'lien vers l''image du produit',
  `origine` varchar(64) COLLATE utf8_bin NOT NULL COMMENT 'origine de notre produit',
  `stock_quantity` int(5) NOT NULL COMMENT 'quantité en stock (en kilos)',
  `note_id` int(3) NOT NULL COMMENT 'lien vers les notes sur le produit',
  `supplier_id` int(3) NOT NULL COMMENT 'lien vers la table des fournisseurs',
  PRIMARY KEY (`id_product`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='répertoire des produits de notre e-commerce' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `promotion`
--

CREATE TABLE IF NOT EXISTS `promotion` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identifiants de la promotion',
  `name` varchar(64) COLLATE utf8_bin NOT NULL COMMENT 'nom de la promotion',
  `description` varchar(512) COLLATE utf8_bin NOT NULL COMMENT 'description de la promotion',
  `scategory_id` int(5) NOT NULL COMMENT 'lien vers la sous catégorie qui bénéficie de la promotion',
  `rate` decimal(8,0) NOT NULL COMMENT 'taux de la promotion',
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='sous categorie du produit' AUTO_INCREMENT=1 ;

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
