/*

SQLyog Ultimate v8.5 
MySQL - 5.5.27 : Database - show_room

*********************************************************************

*/



/*!40101 SET NAMES utf8 */;



/*!40101 SET SQL_MODE=''*/;



/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;

/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

CREATE DATABASE /*!32312 IF NOT EXISTS*/`show_room` /*!40100 DEFAULT CHARACTER SET utf8 */;



USE `show_room`;



/*Table structure for table `catagory` */



DROP TABLE IF EXISTS `catagory`;



CREATE TABLE `catagory` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `manager_id` int(11) unsigned NOT NULL,
  `created` date NOT NULL,
  `updated` date DEFAULT NULL,
  `parent` tinyint(2) unsigned DEFAULT '0',
  `status` enum('ENABLE','DISABLE','PENDING') DEFAULT 'PENDING',
  `alias` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_catagory` (`manager_id`),
  CONSTRAINT `FK_catagory` FOREIGN KEY (`manager_id`) REFERENCES `manager` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;



/*Data for the table `catagory` */



insert  into `catagory`(`id`,`name`,`manager_id`,`created`,`updated`,`parent`,`status`,`alias`) values (1,'cao ngựa',28,'0000-00-00',NULL,0,'ENABLE','cao-ngua');



/*Table structure for table `manager` */



DROP TABLE IF EXISTS `manager`;



CREATE TABLE `manager` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('ADMIN','MANAGER','STAFF','DISABLE') COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `yahoo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `skype` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reset_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UK__email_shop_id` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



/*Data for the table `manager` */



insert  into `manager`(`id`,`email`,`password`,`status`,`name`,`phone`,`yahoo`,`skype`,`reset_time`) values (4,'manhhaiphp@gmail.com','$P$BYdbbEdiHV/ByrvhWUPO6FS9RjKK8z0','ADMIN','Mạnh Hải','0989030623','','','2013-03-06 17:59:24'),(23,'test@gmail.com','$P$BYdbbEdiHV/ByrvhWUPO6FS9RjKK8z0','STAFF','','','','',NULL),(24,'anhthikhong86@gmail.com','$P$BYdbbEdiHV/ByrvhWUPO6FS9RjKK8z0','MANAGER','Ánh','','','',NULL),(25,'hunght@gmail.com','$P$BYdbbEdiHV/ByrvhWUPO6FS9RjKK8z0','MANAGER','Hùng','','','',NULL),(26,'p2045i@gmail.com','$P$BYdbbEdiHV/ByrvhWUPO6FS9RjKK8z0','MANAGER','Phi','','','',NULL),(28,'tunglv.1990@gmail.com','$P$BYdbbEdiHV/ByrvhWUPO6FS9RjKK8z0','MANAGER','Tùng',NULL,NULL,NULL,NULL),(29,'phuonggs88@gmail.com','$P$BYdbbEdiHV/ByrvhWUPO6FS9RjKK8z0','MANAGER','Phương',NULL,NULL,NULL,NULL),(30,'tunglv_90@yahoo.com.vn','$P$B0kmANx11Qi2A.kuIaG/X8HxUztdVo0','STAFF','','','','',NULL);



/*Table structure for table `object` */



DROP TABLE IF EXISTS `product`;



CREATE TABLE `product` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `desc` varchar(300) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(100) NOT NULL,
  `created` date NOT NULL,
  `update` date DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `manager_id` int(11) DEFAULT NULL,
  `catagory` int(11) unsigned NOT NULL,
  `status` enum('ENABLE','DISABLE','PENDING') DEFAULT 'PENDING',
  `alias` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_product` (`catagory`),
  CONSTRAINT `FK_product` FOREIGN KEY (`catagory`) REFERENCES `catagory` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;



/*Data for the table `object` */



insert  into `product`(`id`,`name`,`desc`,`content`,`image`,`created`,`update`,`user_id`,`manager_id`,`catagory`,`status`,`alias`) values (1,'Cao ngựa bạch','Cao ngựa bạch đặt biệt thơm ngon','Cao ngua bach duoc triet xuat tu ngua bach noi chung là tuyet voi ong mat troi. Moi ba con mau chong mua ngay keo het','defaul.jpg','0000-00-00',NULL,NULL,28,1,'ENABLE','cao-ngua-bach');



/*Table structure for table `user` */



DROP TABLE IF EXISTS `user`;



CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `created` date NOT NULL,
  `status` enum('ENABLE','DISABLE','PENDING') DEFAULT 'PENDING',
  `manager_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_user` (`manager_id`),
  CONSTRAINT `FK_user` FOREIGN KEY (`manager_id`) REFERENCES `manager` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



/*Data for the table `user` */



/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;

/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;

/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;

/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

