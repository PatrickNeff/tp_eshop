-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Mar 09 Juin 2015 à 09:51
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
-- Structure de la table `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identifiant de la commande',
  `client_id` int(5) NOT NULL COMMENT 'liens vers l''identifiant du client',
  `adresse_id` int(11) NOT NULL COMMENT 'identifiant de l''adresse du client',
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'date de la commande',
  `payment_id` int(2) NOT NULL COMMENT 'moyen de payement',
  `order_rate` decimal(6,2) NOT NULL COMMENT 'taux global de réduction de la commande',
  `shipping_fees` decimal(8,2) NOT NULL COMMENT 'frais de port',
  `HT_price` decimal(8,2) NOT NULL COMMENT 'prix hors taxe',
  `TTC_price` decimal(8,2) NOT NULL COMMENT 'prix toutes taxes comprises',
  `TTC_price_with_fees` decimal(8,2) NOT NULL COMMENT 'prix avec frais de port',
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='commande' AUTO_INCREMENT=8 ;

--
-- Contenu de la table `orders`
--

INSERT INTO `orders` (`id`, `client_id`, `adresse_id`, `order_date`, `payment_id`, `order_rate`, `shipping_fees`, `HT_price`, `TTC_price`, `TTC_price_with_fees`, `status`) VALUES
(1, 1, 0, '2015-06-04 12:27:39', 0, 0.00, 0.00, 45.00, 49.00, 0.00, 0),
(5, 4, 0, '2015-06-04 12:26:51', 0, 0.00, 0.00, 46.00, 50.00, 0.00, 1),
(6, 4, 0, '2015-06-04 12:26:58', 0, 0.00, 0.00, 22.00, 24.00, 0.00, 2),
(7, 5, 0, '2015-06-04 12:27:05', 0, 0.00, 0.00, 33.37, 36.21, 0.00, 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='lignes de la commandes' AUTO_INCREMENT=5 ;

--
-- Contenu de la table `order_item`
--

INSERT INTO `order_item` (`id`, `id_order`, `id_product`, `weight`, `price_per_kilo`, `rate_article`, `price_before_rate`, `price_total`) VALUES
(1, 1, 8, 4.000, 2.20, 0.00, 0.00, 8.80),
(2, 6, 2, 48.000, 2.00, 0.00, 0.00, 96.00),
(3, 1, 4, 25.000, 2.00, 0.00, 0.00, 50.00),
(4, 6, 11, 37.000, 1.60, 0.00, 0.00, 59.20);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
