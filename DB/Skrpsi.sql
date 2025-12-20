CREATE DATABASE  IF NOT EXISTS `dapursehatkeluarga` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `dapursehatkeluarga`;
-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: dapursehatkeluarga
-- ------------------------------------------------------
-- Server version	8.0.35

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bahan`
--

DROP TABLE IF EXISTS `bahan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bahan` (
  `bahan_id` int NOT NULL AUTO_INCREMENT,
  `nama_bahan` varchar(45) DEFAULT NULL,
  `deskripsi` varchar(45) DEFAULT NULL,
  `is_active` varchar(45) NOT NULL,
  PRIMARY KEY (`bahan_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bahan`
--

LOCK TABLES `bahan` WRITE;
/*!40000 ALTER TABLE `bahan` DISABLE KEYS */;
INSERT INTO `bahan` VALUES (1,'316Ti Stainless Steel','Baja tahan panas dan karat.','yes'),(2,'Stainless Steel','Baja tahan karat umum.','yes'),(3,'High-Carbon Stainless Steel','Baja kuat dan tajam.','yes'),(4,'Stainless Steel & Silikon','Kombinasi logam dan silikon.','yes'),(5,'Kayu / Komposit','Material kayu campuran.','yes'),(12,'test bahan','test bahan','no'),(13,'rop tes','rop tes','no');
/*!40000 ALTER TABLE `bahan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `barang_keluar`
--

DROP TABLE IF EXISTS `barang_keluar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `barang_keluar` (
  `transaksi_keluar_id` int NOT NULL AUTO_INCREMENT,
  `user_id` varchar(45) DEFAULT NULL,
  `keterangan` varchar(45) DEFAULT NULL,
  `tanggal_keluar` datetime DEFAULT NULL,
  PRIMARY KEY (`transaksi_keluar_id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barang_keluar`
--

LOCK TABLES `barang_keluar` WRITE;
/*!40000 ALTER TABLE `barang_keluar` DISABLE KEYS */;
INSERT INTO `barang_keluar` VALUES (1,'5','tes-1','2025-09-01 22:02:59'),(2,'5',NULL,'2025-10-14 22:03:40'),(3,'5',NULL,'2025-10-18 10:36:22'),(4,'5','tes aja 123','2025-10-19 12:27:03'),(5,'5','penjulan ke A','2025-10-22 12:43:34'),(6,'5',NULL,'2025-10-22 14:00:24'),(7,'5',NULL,'2025-10-24 01:19:52'),(8,'5','testing','2025-10-24 01:30:05'),(9,'9',NULL,'2025-10-24 11:19:18'),(10,'9',NULL,'2025-10-24 11:22:22'),(11,'9',NULL,'2025-10-24 11:23:37'),(12,'9',NULL,'2025-10-24 16:02:13'),(13,'9',NULL,'2025-10-24 16:03:23'),(14,'9',NULL,'2025-09-24 16:03:23'),(15,'5',NULL,'2025-10-26 21:52:12'),(16,'5',NULL,'2025-10-26 21:57:11'),(17,'5',NULL,'2025-09-26 21:57:28'),(18,'5',NULL,'2025-10-26 21:59:01'),(19,'5',NULL,'2025-10-31 15:08:59'),(20,'5',NULL,'2025-11-02 16:12:39'),(21,'5',NULL,'2025-11-02 17:18:16'),(22,'5',NULL,'2025-11-02 19:15:37'),(23,'5',NULL,'2025-11-02 20:09:46'),(24,'5',NULL,'2025-11-02 20:10:01'),(25,'5',NULL,'2025-11-02 20:11:26'),(26,'5',NULL,'2025-11-04 11:22:42'),(27,'5',NULL,'2025-11-04 11:23:58'),(30,'1',NULL,'2025-11-17 19:51:03'),(31,'1',NULL,'2025-11-17 19:52:44'),(32,'1',NULL,'2025-11-17 19:53:55'),(33,'1',NULL,'2025-11-17 19:54:26'),(34,'1',NULL,'2025-11-17 19:55:38'),(35,'1',NULL,'2025-11-17 19:55:52'),(36,'1',NULL,'2025-11-17 19:56:26'),(37,'1',NULL,'2025-11-17 20:42:55'),(38,'1',NULL,'2025-11-17 20:45:38'),(39,'13','penjualan tes','2025-11-19 12:21:41'),(40,'13',NULL,'2025-11-26 20:03:50'),(41,'13','test','2025-12-05 13:36:25'),(51,'13',NULL,'2025-12-08 09:04:29'),(52,'13',NULL,'2025-12-09 18:57:23'),(53,'13',NULL,'2025-12-09 19:01:05'),(54,'13',NULL,'2025-12-09 19:05:25'),(55,'13',NULL,'2025-12-09 19:06:00'),(56,'13',NULL,'2025-12-09 19:06:42'),(57,'13',NULL,'2025-12-09 19:26:33');
/*!40000 ALTER TABLE `barang_keluar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `barang_masuk`
--

DROP TABLE IF EXISTS `barang_masuk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `barang_masuk` (
  `transaksi_masuk_id` int NOT NULL AUTO_INCREMENT,
  `user_id` varchar(45) DEFAULT NULL,
  `supplier_id` varchar(45) DEFAULT NULL,
  `tanggal_masuk` datetime DEFAULT NULL,
  `keterangan` varchar(45) DEFAULT NULL,
  `tanggal_pesanan_dibuat` varchar(45) DEFAULT NULL,
  `selisih_waktu` int GENERATED ALWAYS AS (((to_days(`tanggal_masuk`) - to_days(`tanggal_pesanan_dibuat`)) + 1)) VIRTUAL,
  PRIMARY KEY (`transaksi_masuk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barang_masuk`
--

LOCK TABLES `barang_masuk` WRITE;
/*!40000 ALTER TABLE `barang_masuk` DISABLE KEYS */;
INSERT INTO `barang_masuk` (`transaksi_masuk_id`, `user_id`, `supplier_id`, `tanggal_masuk`, `keterangan`, `tanggal_pesanan_dibuat`) VALUES (1,'13','1','2025-10-15 14:28:18','beli baru','2025-10-15 14:28:18'),(2,'13','1','2025-10-18 10:33:41',NULL,'2025-10-15 14:28:18'),(3,'13','1','2025-10-18 10:36:03',NULL,'2025-10-15 14:28:18'),(4,'13','1','2025-10-22 12:44:33','tets','2025-10-15 14:28:18'),(5,'13','1','2025-10-22 12:45:08','test','2025-10-15 14:28:18'),(6,'13','2','2025-10-23 04:04:12','pembelian bulanan','2025-10-15 14:28:18'),(7,'13','2','2025-10-23 04:37:08',NULL,'2025-10-15 14:28:18'),(8,'13','1','2025-10-24 16:01:55',NULL,'2025-10-15 14:28:18'),(9,'13','1','2025-10-24 16:03:01',NULL,'2025-10-15 14:28:18'),(10,'13','1','2025-11-02 19:14:47',NULL,'2025-10-15 14:28:18'),(11,'13','3','2025-11-02 19:15:13',NULL,'2025-10-15 14:28:18'),(12,'13','1','2025-11-02 22:36:10',NULL,'2025-10-15 14:28:18'),(13,'13','3','2025-11-03 15:23:46','pembelian bulanan','2025-10-15 14:28:18'),(14,'13','1','2025-11-04 11:21:33',NULL,'2025-10-15 14:28:18'),(15,'13','2','2025-11-17 15:42:38',NULL,'2025-10-15 14:28:18'),(16,'13','2','2025-11-17 15:44:16',NULL,'2025-10-15 14:28:18'),(17,'13','1','2025-11-17 19:31:26',NULL,'2025-10-15 14:28:18'),(18,'13','7','2025-11-19 12:01:09',NULL,'2025-10-15 14:28:18'),(19,'13','7','2025-11-19 12:20:47','test masuk','2025-10-15 14:28:18'),(20,'13','1','2025-11-26 20:04:09',NULL,'2025-10-15 14:28:18'),(21,'13','1','2025-12-08 09:06:14','tes skripsi','2025-10-15 14:28:18'),(22,'13','1','2025-12-12 17:53:02','pembelian tambahan','2025-11-01 17:53:02'),(23,'13','1','2025-12-14 12:54:25','beli tes','2025-12-14 12:54:25'),(24,'13','1','2025-12-14 15:45:14','tes bahan','2025-12-01 15:45:14');
/*!40000 ALTER TABLE `barang_masuk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detail_barang_keluar`
--

DROP TABLE IF EXISTS `detail_barang_keluar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detail_barang_keluar` (
  `transaksi_keluar_id` int NOT NULL AUTO_INCREMENT,
  `produk_id` int NOT NULL,
  `jumlah` int NOT NULL,
  PRIMARY KEY (`transaksi_keluar_id`,`produk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=58 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_barang_keluar`
--

LOCK TABLES `detail_barang_keluar` WRITE;
/*!40000 ALTER TABLE `detail_barang_keluar` DISABLE KEYS */;
INSERT INTO `detail_barang_keluar` VALUES (1,1,1),(1,15,5),(2,1,10),(2,15,10),(3,1,1),(4,1,1),(4,2,2),(4,15,2),(5,1,4),(5,15,4),(6,1,1),(7,5,5),(7,15,10),(8,11,12),(8,15,10),(9,9,20),(10,2,10),(11,2,15),(12,26,2),(13,26,5),(14,26,100),(15,26,1),(16,10,1),(17,10,98),(18,10,1),(19,26,10),(20,1,1),(21,1,1),(22,1,1),(23,6,1),(24,15,1),(25,1,10),(26,26,7),(27,1,100),(27,26,10),(30,1,1),(30,3,1),(31,1,1),(32,1,1),(32,6,1),(33,1,1),(33,2,1),(33,5,1),(34,1,1),(34,15,1),(35,1,1),(35,15,1),(36,1,1),(36,15,1),(37,1,50),(38,1,1000),(38,18,1),(39,29,5),(40,18,1),(41,30,5),(51,26,20),(52,30,40),(53,15,2),(54,2,10),(54,3,10),(55,2,5),(55,3,2),(56,2,30),(56,3,20),(57,29,10);
/*!40000 ALTER TABLE `detail_barang_keluar` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8mb4 */ ;
/*!50003 SET character_set_results = utf8mb4 */ ;
/*!50003 SET collation_connection  = utf8mb4_0900_ai_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = 'ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`root`@`localhost`*/ /*!50003 TRIGGER `ROP_trigger` AFTER INSERT ON `detail_barang_keluar` FOR EACH ROW BEGIN
    DECLARE penjualan_maks_harian INT DEFAULT 0;
    DECLARE total_penjualan INT DEFAULT 0;
    DECLARE tanggal_awal DATE;
    DECLARE tanggal_akhir DATE;
    DECLARE total_hari INT DEFAULT 1;
    DECLARE penjualan_rata FLOAT DEFAULT 1;

    DECLARE leadtime_maks INT DEFAULT 1;
    DECLARE leadtime_rata FLOAT DEFAULT 1;

    DECLARE safety_stock_val FLOAT DEFAULT 0;

    DECLARE record_exists INT DEFAULT 0;


    
    -- 1. HITUNG PENJUALAN MAKSIMAL & RATA-RATA PER HARI (30 HARI)

    SELECT 
        MAX(dbk.jumlah),
        SUM(dbk.jumlah),
        MIN(bk.tanggal_keluar),
        MAX(bk.tanggal_keluar)
    INTO
        penjualan_maks_harian,
        total_penjualan,
        tanggal_awal,
        tanggal_akhir
    FROM detail_barang_keluar dbk
    JOIN barang_keluar bk 
        ON dbk.transaksi_keluar_id = bk.transaksi_keluar_id
    WHERE dbk.produk_id = NEW.produk_id
      AND bk.tanggal_keluar >= (CURDATE() - INTERVAL 30 DAY);

    IF tanggal_awal IS NOT NULL AND tanggal_akhir IS NOT NULL THEN
        SET total_hari = DATEDIFF(tanggal_akhir, tanggal_awal) + 1;
    ELSE
        SET total_hari = 1;
    END IF;

    SET penjualan_rata = total_penjualan / total_hari;


  
    -- 2. HITUNG LEAD TIME MAKSIMUM & RATA-RATA (30 HARI)
  
    SELECT 
        MAX(bm.selisih_waktu),
        AVG(bm.selisih_waktu)
    INTO
        leadtime_maks,
        leadtime_rata
    FROM detail_barang_masuk dbm
    JOIN barang_masuk bm
        ON dbm.transaksi_masuk_id = bm.transaksi_masuk_id
    WHERE dbm.produk_id = NEW.produk_id
      AND bm.tanggal_masuk >= (CURDATE() - INTERVAL 30 DAY);

    -- Antisipasi NULL
    IF leadtime_maks IS NULL THEN SET leadtime_maks = 1; END IF;
    IF leadtime_rata IS NULL THEN SET leadtime_rata = 1; END IF;
    IF penjualan_rata < 1 THEN SET penjualan_rata = 1; END IF;



    -- 3. HITUNG SAFETY STOCK
 
    SET safety_stock_val = 
          (penjualan_maks_harian * leadtime_maks)
        - (penjualan_rata * leadtime_rata);

    IF safety_stock_val < 0 THEN 
        SET safety_stock_val = 0; 
    END IF;



    -- 4. CEK DATA HARI INI

    SELECT COUNT(*)
    INTO record_exists
    FROM rop
    WHERE produk_id = NEW.produk_id
      AND tanggal = CURDATE();


 
    -- 5. UPDATE / INSERT ROP

    IF record_exists > 0 THEN
        UPDATE rop
        SET 
            tingkat_permintaan = penjualan_rata,
            safety_stock = safety_stock_val,
            lead_time = leadtime_rata,
            transaksi_keluar_id = NEW.transaksi_keluar_id
        WHERE produk_id = NEW.produk_id
          AND tanggal = CURDATE();
    ELSE
        INSERT INTO rop (produk_id, tanggal, tingkat_permintaan, safety_stock, lead_time, transaksi_keluar_id)
        VALUES (
            NEW.produk_id,
            CURDATE(),
            penjualan_rata,
            safety_stock_val,
            leadtime_rata,
            NEW.transaksi_keluar_id
        );
    END IF;

END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `detail_barang_masuk`
--

DROP TABLE IF EXISTS `detail_barang_masuk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detail_barang_masuk` (
  `transaksi_masuk_id` int NOT NULL AUTO_INCREMENT,
  `produk_id` int NOT NULL,
  `jumlah` int NOT NULL,
  PRIMARY KEY (`transaksi_masuk_id`,`produk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_barang_masuk`
--

LOCK TABLES `detail_barang_masuk` WRITE;
/*!40000 ALTER TABLE `detail_barang_masuk` DISABLE KEYS */;
INSERT INTO `detail_barang_masuk` VALUES (1,9,10),(1,11,9),(1,15,10),(2,5,5),(2,23,6),(3,1,1),(4,15,8),(5,1,1),(5,7,1),(5,10,1),(6,1,40),(6,15,40),(7,1,20),(7,15,20),(8,27,10),(9,28,10),(10,1,1),(11,15,1),(12,3,1),(13,5,10),(14,26,50),(15,26,10),(16,26,15),(17,26,1),(18,10,1),(19,12,1),(19,29,100),(20,12,1),(21,26,100),(22,12,50),(23,12,10),(24,12,40);
/*!40000 ALTER TABLE `detail_barang_masuk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kategori`
--

DROP TABLE IF EXISTS `kategori`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `kategori` (
  `kategori_id` int NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(45) DEFAULT NULL,
  `deskripsi` varchar(45) DEFAULT NULL,
  `is_active` varchar(45) NOT NULL,
  PRIMARY KEY (`kategori_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kategori`
--

LOCK TABLES `kategori` WRITE;
/*!40000 ALTER TABLE `kategori` DISABLE KEYS */;
INSERT INTO `kategori` VALUES (1,'Alat Masak Utama','Peralatan utama untuk memasak.','yes'),(2,'Sistem Memasak','Peralatan masak dengan sistem khusus.','yes'),(3,'Peralatan Makan','Alat untuk menyajikan dan makan.','yes'),(4,'Peralatan Pendukung Dapur','Alat bantu kegiatan dapur.','yes'),(5,'Peralatan Panggang','Peralatan untuk memanggang.','yes'),(9,'test kategori','test kategori','yes'),(10,'jbb',NULL,'no'),(11,'j',NULL,'no'),(12,'rop tes',NULL,'no');
/*!40000 ALTER TABLE `kategori` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `master_produk`
--

DROP TABLE IF EXISTS `master_produk`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `master_produk` (
  `produk_id` int NOT NULL AUTO_INCREMENT,
  `kategori_id` int NOT NULL,
  `tipe_id` int NOT NULL,
  `satuan_id` int NOT NULL,
  `bahan_id` int NOT NULL,
  `nama_produk` varchar(45) DEFAULT NULL,
  `stock` int DEFAULT NULL,
  `is_active` varchar(5) NOT NULL,
  `deskripsi` varchar(400) DEFAULT NULL,
  `gambar` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`produk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `master_produk`
--

LOCK TABLES `master_produk` WRITE;
/*!40000 ALTER TABLE `master_produk` DISABLE KEYS */;
INSERT INTO `master_produk` VALUES (1,1,1,1,1,'Sauce Pan Rumah Tangga',0,'yes',NULL,NULL),(2,1,1,1,1,'Sauce Pan Rumah Tangga Plus',5,'yes',NULL,NULL),(3,1,1,1,1,'Sauce Pan chef',18,'yes',NULL,NULL),(4,1,2,1,1,'Skillet Rumah Tangga',50,'yes',NULL,NULL),(5,1,2,1,1,'Skillet Rumah Tangga Plus',50,'yes',NULL,NULL),(6,1,2,1,1,'Skillet chef',50,'yes',NULL,NULL),(7,1,3,1,1,'Roaster Rumah Tangga',50,'yes',NULL,NULL),(8,1,3,1,1,'Roaster Chef',50,'yes',NULL,NULL),(9,1,4,1,1,'Stockpot Rumah Tangga',50,'yes',NULL,NULL),(10,1,4,1,1,'Stockpot Rumah Tangga Plus',51,'yes',NULL,NULL),(11,1,4,1,1,'Stockpot Chef',50,'yes',NULL,NULL),(12,1,5,1,1,'Wok',152,'yes',NULL,NULL),(13,2,6,1,1,'MP5',50,'yes',NULL,NULL),(14,2,6,1,1,'Electric Oil Core Skillet',50,'yes',NULL,NULL),(15,2,7,1,2,'Culinary Basket',48,'yes',NULL,NULL),(16,2,8,1,2,'Steamer/Grater Insets',50,'yes',NULL,NULL),(17,3,9,2,3,'Professional Knife Set',50,'yes',NULL,NULL),(18,3,10,2,2,'(Sendok/Garpu)',48,'yes',NULL,NULL),(19,4,11,2,2,'Mixing Bowl Set',50,'yes',NULL,NULL),(20,4,12,1,2,'Colander (Saringan)',50,'yes',NULL,NULL),(21,4,13,2,4,'Kitchen Tool Set',50,'yes',NULL,NULL),(22,4,14,1,5,'Cutting Board',50,'yes',NULL,NULL),(23,5,15,1,2,'Rectangular Bake Pan',50,'yes',NULL,NULL),(24,5,15,1,2,'Square Bake Pan',50,'yes',NULL,NULL),(25,5,15,1,2,'Cookie Sheet',50,'yes',NULL,NULL),(26,5,15,1,2,'Pie Pan',130,'yes',NULL,NULL),(29,9,19,8,12,'test produk',85,'yes',NULL,NULL),(30,11,19,8,12,'test akhir',5,'yes',NULL,NULL),(31,12,20,9,13,'rop tes',2000,'no',NULL,NULL),(32,5,10,1,1,'tes',10,'yes','testingg',NULL),(40,9,12,2,4,'tes barang',100,'yes','tes baang gambar','storage/images/C3qeAHyOvFWfemxslVkfSlrxv6IpDhR9dSTePymG.png'),(41,9,14,2,5,'gamabr produk',100,'no','tes','storage/images/k6cRKPRPILUhGGn2lYOgMYVWOCRTDVBsnwX3o8BF.jpg'),(42,9,15,3,5,'gambar coba',200,'yes','barang untuk percobaan','storage/images/vx45Kj6ZIFUVZXpbyRQwmHrnolUZRQDrUThNjYOs.png');
/*!40000 ALTER TABLE `master_produk` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary view structure for view `master_tag`
--

DROP TABLE IF EXISTS `master_tag`;
/*!50001 DROP VIEW IF EXISTS `master_tag`*/;
SET @saved_cs_client     = @@character_set_client;
/*!50503 SET character_set_client = utf8mb4 */;
/*!50001 CREATE VIEW `master_tag` AS SELECT 
 1 AS `tag_id`,
 1 AS `nama_tag`,
 1 AS `deskripsi`,
 1 AS `is_active`*/;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (4,'0001_01_01_000000_create_users_table',1),(5,'0001_01_01_000001_create_cache_table',1),(6,'0001_01_01_000002_create_jobs_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rop`
--

DROP TABLE IF EXISTS `rop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rop` (
  `rop_id` int NOT NULL AUTO_INCREMENT,
  `produk_id` int DEFAULT NULL,
  `lead_time` int DEFAULT '0',
  `safety_stock` int DEFAULT '0',
  `tingkat_permintaan` int DEFAULT '0',
  `tanggal` datetime DEFAULT NULL,
  `rop` int GENERATED ALWAYS AS (((`tingkat_permintaan` * `lead_time`) + `safety_stock`)) STORED,
  `transaksi_keluar_id` int DEFAULT NULL,
  PRIMARY KEY (`rop_id`),
  KEY `idx_produk_tanggal` (`produk_id`,`tanggal`)
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rop`
--

LOCK TABLES `rop` WRITE;
/*!40000 ALTER TABLE `rop` DISABLE KEYS */;
INSERT INTO `rop` (`rop_id`, `produk_id`, `lead_time`, `safety_stock`, `tingkat_permintaan`, `tanggal`, `transaksi_keluar_id`) VALUES (7,1,7,10,15,'2025-10-14 00:00:00',NULL),(8,15,1,0,15,'2025-10-14 00:00:00',NULL),(9,9,10,0,0,'2025-10-14 00:00:00',NULL),(10,2,7,10,0,'2025-10-14 00:00:00',NULL),(11,18,7,50,0,'2025-10-14 00:00:00',NULL),(12,1,7,10,0,'2025-10-18 00:00:00',NULL),(13,15,1,0,0,'2025-10-19 00:00:00',NULL),(14,2,7,10,2,'2025-10-19 00:00:00',NULL),(15,1,7,10,0,'2025-10-22 00:00:00',NULL),(16,15,1,0,0,'2025-10-22 00:00:00',NULL),(17,5,10,10,5,'2025-10-24 00:00:00',NULL),(18,15,9,10,1,'2025-10-24 00:00:00',NULL),(19,11,1,0,12,'2025-10-24 00:00:00',NULL),(20,9,30,5,20,'2025-10-24 00:00:00',NULL),(21,2,7,10,4,'2025-10-24 00:00:00',NULL),(22,10,10,10,0,'2025-10-24 00:00:00',NULL),(23,26,10,10,0,'2025-10-24 00:00:00',NULL),(24,3,10,10,0,'2025-10-24 00:00:00',NULL),(25,23,10,10,0,'2025-10-24 00:00:00',NULL),(26,26,10,10,5,'2025-10-24 00:00:00',NULL),(27,23,1,0,2,'2025-10-24 00:00:00',NULL),(28,26,10,10,3,'2025-10-26 00:00:00',NULL),(29,10,10,10,3,'2025-10-26 00:00:00',NULL),(30,29,1,0,10,'2025-10-31 00:00:00',NULL),(31,29,10,10,0,'2025-10-31 00:00:00',NULL),(32,1,7,10,1,'2025-11-02 00:00:00',NULL),(33,6,1,0,1,'2025-11-02 00:00:00',NULL),(34,15,9,10,1,'2025-11-02 00:00:00',NULL),(35,26,14,25,2,'2025-11-04 00:00:00',NULL),(36,22,10,10,0,'2025-11-05 00:00:00',NULL),(41,22,1,1,5,'2025-11-17 00:00:00',NULL),(42,1,7,10,15,'2025-11-17 00:00:00',NULL),(43,3,10,10,1,'2025-11-17 00:00:00',NULL),(44,6,1,0,0,'2025-11-17 00:00:00',NULL),(45,5,10,10,0,'2025-11-17 00:00:00',NULL),(46,2,7,10,1,'2025-11-17 00:00:00',NULL),(47,15,9,10,1,'2025-11-17 00:00:00',NULL),(48,18,7,50,1,'2025-11-17 00:00:00',NULL),(52,29,7,5,5,'2025-11-19 00:00:00',NULL),(53,18,7,50,0,'2025-11-26 00:00:00',NULL),(54,10,30,0,3,'2025-12-05 00:00:00',NULL),(55,30,1,0,5,'2025-12-05 00:00:00',NULL),(57,26,14,25,2,'2025-12-08 00:00:00',NULL),(58,30,1,31,9,'2025-12-09 00:00:00',NULL),(59,15,1,1,1,'2025-12-09 00:00:00',NULL),(60,3,1,19,1,'2025-12-09 00:00:00',NULL),(61,2,1,28,2,'2025-12-09 00:00:00',NULL),(62,29,35,315,1,'2025-12-09 00:00:00',57);
/*!40000 ALTER TABLE `rop` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `satuan`
--

DROP TABLE IF EXISTS `satuan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `satuan` (
  `satuan_id` int NOT NULL AUTO_INCREMENT,
  `nama_satuan` varchar(45) DEFAULT NULL,
  `is_active` varchar(45) NOT NULL,
  PRIMARY KEY (`satuan_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1011 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `satuan`
--

LOCK TABLES `satuan` WRITE;
/*!40000 ALTER TABLE `satuan` DISABLE KEYS */;
INSERT INTO `satuan` VALUES (1,'Unit','yes'),(2,'Lusinan','yes'),(3,'Set','yes'),(8,'test satuan','no'),(9,'rop tes','no');
/*!40000 ALTER TABLE `satuan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('03nbrSVf6ZwrshSiheEVlXHbcO4BR1TYjUBhl7mb',13,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:145.0) Gecko/20100101 Firefox/145.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiZTAweUUzUnU2RDdXZ2lFZzZ6ZTVyUFVsUUFUWGt4UjhvUTFlVlVPZSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjU6Imh0dHA6Ly9pbnZlbnRvcnlkYXB1cnNlaGF0a2VsdWFyZ2Euc2tyaXBzaS9iYXJhbmctbWFzdWsvZGV0YWlsLzI0Ijt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTM7fQ==',1765701937);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `suppliers` (
  `supplier_id` int NOT NULL AUTO_INCREMENT,
  `nama_supplier` varchar(45) DEFAULT NULL,
  `nomor_telepon` varchar(45) DEFAULT NULL,
  `alamat` varchar(100) DEFAULT NULL,
  `is_active` varchar(5) NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'PT Panci Utama','12345678','10900 Richmond Avenue, Houston, Texas 77042, United States of America','yes'),(7,'test supplier','123456','test supplier','no');
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tabel_tes`
--

DROP TABLE IF EXISTS `tabel_tes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tabel_tes` (
  `tes_id` int NOT NULL AUTO_INCREMENT,
  `colom1` varchar(45) DEFAULT NULL,
  `colom2` varchar(45) DEFAULT NULL,
  `is_active` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`tes_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tabel_tes`
--

LOCK TABLES `tabel_tes` WRITE;
/*!40000 ALTER TABLE `tabel_tes` DISABLE KEYS */;
INSERT INTO `tabel_tes` VALUES (1,'colom1tes','colom2tes','yes'),(2,'colom2tes','colom2tes','yes');
/*!40000 ALTER TABLE `tabel_tes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag_latihan`
--

DROP TABLE IF EXISTS `tag_latihan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tag_latihan` (
  `tag_id` int NOT NULL,
  `produk_id` int NOT NULL,
  `is_active` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`tag_id`,`produk_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag_latihan`
--

LOCK TABLES `tag_latihan` WRITE;
/*!40000 ALTER TABLE `tag_latihan` DISABLE KEYS */;
INSERT INTO `tag_latihan` VALUES (2,12,'yes');
/*!40000 ALTER TABLE `tag_latihan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tipe`
--

DROP TABLE IF EXISTS `tipe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tipe` (
  `tipe_id` int NOT NULL AUTO_INCREMENT,
  `nama_tipe` varchar(45) DEFAULT NULL,
  `deskripsi` varchar(45) DEFAULT NULL,
  `is_active` varchar(45) NOT NULL,
  PRIMARY KEY (`tipe_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tipe`
--

LOCK TABLES `tipe` WRITE;
/*!40000 ALTER TABLE `tipe` DISABLE KEYS */;
INSERT INTO `tipe` VALUES (1,'Panci Saus (Sauce Pan)','Untuk membuat saus atau rebusan kecil.','yes'),(2,'Penggorengan (Skillet)','Untuk menggoreng dan menumis.','yes'),(3,'Panci Panggang (Roaster)','Untuk memanggang atau memasak besar.','yes'),(4,'Panci Sup (Stockpot)','Untuk membuat sup atau kaldu.','yes'),(5,'Wajan (Wok)','Untuk menumis dengan cepat.','yes'),(6,'Elektrik','Peralatan masak bertenaga listrik.','yes'),(7,'Keranjang Saring/Kukus','Untuk menyaring atau mengukus.','yes'),(8,'Parutan/Kukusan Dalam','Untuk parut dan kukus.','yes'),(9,'Set Pisau','Kumpulan pisau dapur.','yes'),(10,'Set Alat Makan','Sendok dan garpu satu set.','yes'),(11,'Mangkok Adonan','Untuk mencampur adonan.','yes'),(12,'Saringan Bilas','Untuk menyaring bahan basah.','yes'),(13,'Set Spatula & Sendok','Peralatan masak dasar.','yes'),(14,'Talenan','Untuk memotong bahan.','yes'),(15,'Loyang','Untuk memanggang kue.','yes'),(19,'test tipe','test tipe','no'),(20,'rop test',NULL,'no');
/*!40000 ALTER TABLE `tipe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `user_id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_telepon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Fabio','owner','fabio','08765432','$2y$12$nm2laylPQlaVPm2na.gikeQ7kEh7XtXhYeaFwyg2vqYS08ss1RbAK','yes'),(10,'Pemilik 1','owner','Pemilik 1','1234567','$2y$12$5JBU/d7AD/mx8Vfx.lvySekOuJk6v74ddB3jOwx7l0biMk4asksfi','yes'),(11,'Pemilik 1 (backup)','owner','Pemilik 1 (backup)','12121313','$2y$12$ewQ0GWW21vYckRwQ/M2KmeNlXwhgyhdvEVfrOYF0zgR3WZk94Y1Be','yes'),(12,'Pemilik as admin','admin','Pemilik 1 as admin','1312123','$2y$12$EkI5MTLys9REv6sDuNkFzOHG8U1YKwRqYiACR1js1UEKrX22jxzUG','yes'),(13,'Admin','admin','Admin Gudang','12345678','$2y$12$vOgDoJzxBEMtM47rC5vvrO5HMqmCS0LjhJj/SbiX7Jl0WQyYIeFm6','yes'),(14,'Fabio','admin','Fabio test','123456','$2y$12$xDpo1cJ0KloS17XearhSwuP0YC3zxswfZpiWo6KuHAceBaywpMymm','yes'),(15,'skripsi','admin','skripsi','12345678','$2y$12$yZEAciAxCqpWQ.bnY/99guH5BbdSbNMlPqvvaTPFqcJLgUil311.u','yes');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'dapursehatkeluarga'
--

--
-- Dumping routines for database 'dapursehatkeluarga'
--

--
-- Final view structure for view `master_tag`
--

/*!50001 DROP VIEW IF EXISTS `master_tag`*/;
/*!50001 SET @saved_cs_client          = @@character_set_client */;
/*!50001 SET @saved_cs_results         = @@character_set_results */;
/*!50001 SET @saved_col_connection     = @@collation_connection */;
/*!50001 SET character_set_client      = utf8mb4 */;
/*!50001 SET character_set_results     = utf8mb4 */;
/*!50001 SET collation_connection      = utf8mb4_0900_ai_ci */;
/*!50001 CREATE ALGORITHM=UNDEFINED */
/*!50013 DEFINER=`root`@`localhost` SQL SECURITY DEFINER */
/*!50001 VIEW `master_tag` AS select `tabel_tes`.`tes_id` AS `tag_id`,`tabel_tes`.`colom1` AS `nama_tag`,`tabel_tes`.`colom2` AS `deskripsi`,`tabel_tes`.`is_active` AS `is_active` from `tabel_tes` */;
/*!50001 SET character_set_client      = @saved_cs_client */;
/*!50001 SET character_set_results     = @saved_cs_results */;
/*!50001 SET collation_connection      = @saved_col_connection */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-12-20 19:08:51
