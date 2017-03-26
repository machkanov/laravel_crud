-- --------------------------------------------------------
-- ????:                         127.0.0.1
-- Server version:               5.6.16 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL ??????:              9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Dumping database structure for adcash
CREATE DATABASE IF NOT EXISTS `adcash` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `adcash`;


-- Dumping structure for table adcash.order
CREATE TABLE IF NOT EXISTS `order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) DEFAULT '0',
  `user_id` int(11) DEFAULT '0',
  `quantity` int(11) DEFAULT '0',
  `bought_for` float DEFAULT '0',
  `total` float DEFAULT '0',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`order_id`),
  KEY `FK_order_product` (`product_id`),
  KEY `FK_order_user` (`user_id`),
  CONSTRAINT `FK_order_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  CONSTRAINT `FK_order_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- Dumping data for table adcash.order: ~2 rows (approximately)
DELETE FROM `order`;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` (`order_id`, `product_id`, `user_id`, `quantity`, `bought_for`, `total`, `created_at`) VALUES
	(1, 2, 4, 3, 1.6, 3.84, '2017-03-26 15:11:06'),
	(2, 8, 2, 3, 1.7, 5.1, '2017-03-26 15:11:17');
/*!40000 ALTER TABLE `order` ENABLE KEYS */;


-- Dumping structure for table adcash.product
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product` varchar(50) DEFAULT NULL,
  `price` float DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

-- Dumping data for table adcash.product: ~8 rows (approximately)
DELETE FROM `product`;
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` (`id`, `product`, `price`) VALUES
	(1, 'Coca Cola', 1.7),
	(2, 'Pepsi Cola', 1.6),
	(3, 'Fanta', 1.7),
	(4, 'Mirinda', 1.2),
	(5, 'Fanta Lemon', 1.7),
	(6, 'Sprite', 1.2),
	(7, 'Nestea', 1.6),
	(8, 'Tonic', 1.7);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;


-- Dumping structure for table adcash.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- Dumping data for table adcash.user: ~5 rows (approximately)
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `name`) VALUES
	(1, 'John Smith'),
	(2, 'Laura Stone'),
	(3, 'Jon Olsson'),
	(4, 'Jony Monini'),
	(5, 'Anna Johnson');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
