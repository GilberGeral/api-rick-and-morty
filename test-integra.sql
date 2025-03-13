/*
SQLyog Ultimate v11.33 (64 bit)
MySQL - 10.6.18-MariaDB-0ubuntu0.22.04.1 : Database - test_integra
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`test_integra` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `test_integra`;

/*Table structure for table `characters` */

DROP TABLE IF EXISTS `characters`;

CREATE TABLE `characters` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_externo` int(10) unsigned NOT NULL,
  `name` varchar(64) NOT NULL,
  `status` varchar(64) NOT NULL,
  `species` varchar(64) NOT NULL,
  `type` varchar(32) DEFAULT NULL,
  `gender` varchar(32) NOT NULL,
  `origin` tinytext NOT NULL,
  `image` varchar(32) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `created_by` varchar(16) NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `characters` */

insert  into `characters`(`id`,`id_externo`,`name`,`status`,`species`,`type`,`gender`,`origin`,`image`,`created_at`,`created_by`,`updated_at`,`updated_by`) values (7,1,'Rick Sanchez','Alive','Human','human e','Male','Earth (C-137)','character/avatar/1.jpeg','2025-03-13 02:16:08','user','2025-03-13 02:16:43','user');

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values (2,'2025_03_12_203355_tabla_personajes_inicio',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
