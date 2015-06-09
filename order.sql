-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Généré le: Ven 05 Juin 2015 à 14:33
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
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT 'date de la commande',
  `payment_id` int(2) NOT NULL COMMENT 'moyen de payement',
  `order_rate` decimal(6,2) NOT NULL COMMENT 'taux global de réduction de la commande',
  `HT_price` decimal(8,2) NOT NULL COMMENT 'prix hors taxe',
  `TTC_price` decimal(8,2) NOT NULL COMMENT 'prix toutes taxes comprises',
  `status` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='commande' AUTO_INCREMENT=8 ;

--
-- Contenu de la table `orders`
--

INSERT INTO `orders` (`id`, `client_id`, `order_date`, `payment_id`, `order_rate`, `HT_price`, `TTC_price`, `status`) VALUES
(1, 1, '2015-06-04 12:27:39', 0, 0.00, 45.00, 49.00, 0),
(5, 4, '2015-06-04 12:26:51', 0, 0.00, 46.00, 50.00, 1),
(6, 4, '2015-06-04 12:26:58', 0, 0.00, 22.00, 24.00, 2),
(7, 5, '2015-06-04 12:27:05', 0, 0.00, 33.37, 36.21, 1);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
