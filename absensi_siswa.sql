# SQL-Front 5.1  (Build 4.16)

/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE */;
/*!40101 SET SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES */;
/*!40103 SET SQL_NOTES='ON' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;


# Host: 127.0.0.1    Database: absensi_siswa
# ------------------------------------------------------
# Server version 5.5.5-10.4.32-MariaDB

#
# Source for table absensi
#

DROP TABLE IF EXISTS `absensi`;
CREATE TABLE `absensi` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nis` varchar(100) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `waktu` time DEFAULT NULL,
  `tanggal` date DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Dumping data for table absensi
#

LOCK TABLES `absensi` WRITE;
/*!40000 ALTER TABLE `absensi` DISABLE KEYS */;
INSERT INTO `absensi` VALUES (6,'123333',NULL,'17:39:52','2025-07-28');
/*!40000 ALTER TABLE `absensi` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table admin
#

DROP TABLE IF EXISTS `admin`;
CREATE TABLE `admin` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Dumping data for table admin
#

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'admintkj','tkj2025');
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table data_siswa
#

DROP TABLE IF EXISTS `data_siswa`;
CREATE TABLE `data_siswa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nis` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas` varchar(100) DEFAULT NULL,
  `foto` varchar(100) DEFAULT NULL,
  `id_kelas` int(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_siswa_kelas` (`id_kelas`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Dumping data for table data_siswa
#

LOCK TABLES `data_siswa` WRITE;
/*!40000 ALTER TABLE `data_siswa` DISABLE KEYS */;
/*!40000 ALTER TABLE `data_siswa` ENABLE KEYS */;
UNLOCK TABLES;

#
# Source for table kelas
#

DROP TABLE IF EXISTS `kelas`;
CREATE TABLE `kelas` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kelas` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

#
# Dumping data for table kelas
#

LOCK TABLES `kelas` WRITE;
/*!40000 ALTER TABLE `kelas` DISABLE KEYS */;
INSERT INTO `kelas` VALUES (1,'X-1');
INSERT INTO `kelas` VALUES (2,'X-2');
INSERT INTO `kelas` VALUES (3,'X-3');
/*!40000 ALTER TABLE `kelas` ENABLE KEYS */;
UNLOCK TABLES;

#
#  Foreign keys for table data_siswa
#

ALTER TABLE `data_siswa`
ADD CONSTRAINT `fk_siswa_kelas` FOREIGN KEY (`id_kelas`) REFERENCES `kelas` (`Id`);


/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
