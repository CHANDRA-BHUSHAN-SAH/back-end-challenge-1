-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.19-log - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL Version:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping structure for table script_db.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(60) NOT NULL,
  `gender` enum('M','F') NOT NULL DEFAULT 'M',
  `notes` varchar(120) NOT NULL,
  `active_status` enum('Y','N') NOT NULL DEFAULT 'Y',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `active_status` (`active_status`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- Dumping data for table script_db.categories: ~3 rows (approximately)
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` (`id`, `name`, `gender`, `notes`, `active_status`, `created_at`, `updated_at`) VALUES
	(1, 'T-Shirts', 'M', 'Men Tshirts', 'Y', '2018-07-18 00:52:48', '2018-07-18 00:52:48'),
	(2, 'Trousers', 'M', 'Men Trousers', 'Y', '2018-07-18 22:00:57', '2018-07-18 22:00:57'),
	(3, 'Shirts', 'M', 'Men Shirts', 'Y', '2018-07-18 22:04:52', '2018-07-18 22:04:52');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;

-- Dumping structure for table script_db.products
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `descriptions` varchar(300) DEFAULT NULL,
  `available_size` varchar(6) NOT NULL,
  `price` decimal(6,2) NOT NULL,
  `image_url` varchar(250) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `active_status` enum('Y','N') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `active_status` (`active_status`),
  KEY `category_fk` (`category_id`),
  CONSTRAINT `category_fk` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

-- Dumping data for table script_db.products: ~7 rows (approximately)
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` (`id`, `name`, `descriptions`, `available_size`, `price`, `image_url`, `category_id`, `active_status`, `created_at`, `updated_at`) VALUES
	(2, 'Black n White T-shirt', '100 % cotton. Slim Fit.', 'L', 329.00, NULL, 1, 'Y', '2018-07-18 01:47:18', '2018-07-18 12:21:18'),
	(4, 'White T-shirt', '100 % cotton. Regural Fit', 'S', 219.00, 'https://i.ebayimg.com/images/g/vTwAAOxydlFS-loL/s-l300.jpg', 1, 'Y', '2018-07-18 02:08:48', '2018-07-18 23:54:54'),
	(5, 'BlueTrouser', '100%cottonReguralFitBlueTrousers', '34', 799.00, '', 2, 'Y', '2018-07-18 22:03:09', '2018-07-18 22:03:09'),
	(6, 'Formal Shirt', '100 % cotton. Regural Fit. White Formal Shirt.', '40', 999.00, NULL, 3, 'Y', '2018-07-19 00:07:11', '2018-07-19 00:07:35'),
	(7, 'Casual Shirt', 'Casual Fit.', '42', 509.00, NULL, 3, 'Y', '2018-07-19 00:18:12', '2018-07-19 00:19:08'),
	(8, 'Flat-Front Slim Fit Chinos', 'Designed with flat-front styling, these versatile chinos make for the perfect dapper option.<ul><li>Insert pockets, back welt pockets</li><li>Mid Rise</li><li>Slim Fit</li><li>The model is wearing a size larger for a comfortable fit</li><li>99% cotton, 1% Lycra</li><li>Machine Wash</li></ul>.', '34', 999.00, 'https://www.reliancetrends.com/medias/sys_master/root/h53/hf8/8997003886622/netplay-flat-front-slim-fit-chinos.jpg', 2, 'Y', '2018-07-19 00:26:00', '2018-07-19 00:27:40'),
	(9, 'Mast & Harbour Men Blue Linen Blend Casual Trousers', 'A pair of blue mid-rise casual trousers in a patterned weave, has four pockets, a zip fly with a button closure, a waistband with belt loops and a drawstring fastening<br><br><h5>Material & Care</h5>75% cotton, 25% linen<br>Machine-wash', '28', 1379.00, 'https://assets.myntassets.com/h_640,q_90,w_480/v1/assets/images/1735987/2017/4/13/11492071605841-Mast--Harbour-Men-Blue-Trousers-9541492071605544-1.jpg', 2, 'Y', '2018-07-19 00:30:34', '2018-07-19 00:30:34');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
