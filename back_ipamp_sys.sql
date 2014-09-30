-- MySQL dump 10.13  Distrib 5.5.28, for osx10.6 (i386)
--
-- Host: localhost    Database: ipamp_sys
-- ------------------------------------------------------
-- Server version	5.5.28

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `mod_cliente`
--

DROP TABLE IF EXISTS `mod_cliente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mod_cliente` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(512) NOT NULL DEFAULT '',
  `nascimento` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `cpf` int(13) NOT NULL,
  `endereco` varchar(512) DEFAULT NULL,
  `cidade` varchar(128) DEFAULT NULL,
  `uf` char(2) DEFAULT NULL,
  `bairro` varchar(256) DEFAULT NULL,
  `cep` int(8) DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT '',
  `complemento` varchar(512) DEFAULT NULL,
  `email` varchar(256) DEFAULT NULL,
  `facebook` varchar(256) DEFAULT NULL,
  `skype` varchar(256) DEFAULT NULL,
  `telefonefixo` int(15) DEFAULT NULL,
  `telefonecelular` int(15) DEFAULT NULL,
  `telefoneempresa` int(15) DEFAULT NULL,
  `rg` int(15) DEFAULT NULL,
  `pais` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf_key` (`cpf`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mod_cliente`
--

LOCK TABLES `mod_cliente` WRITE;
/*!40000 ALTER TABLE `mod_cliente` DISABLE KEYS */;
INSERT INTO `mod_cliente` VALUES (1,'cesar Filho','1981-10-31 03:00:00',2147483647,'serv. jatoba ','florianopolis','SC','ingleses',88330332,'A','n 41 apto 02','cesarpamplonafilho@gmail.com',NULL,NULL,NULL,2147483647,NULL,34905345,'Brasil'),(2,'marquitt','1980-05-16 03:00:00',454545454,'rua pode ser qlquer uma','floripa','SC','ingleses',88945944,'A','n 344 3434','kitt@hot.com.br',NULL,NULL,NULL,786876,NULL,NULL,'Argentina');
/*!40000 ALTER TABLE `mod_cliente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mod_notafiscal`
--

DROP TABLE IF EXISTS `mod_notafiscal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mod_notafiscal` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mod_notafiscal`
--

LOCK TABLES `mod_notafiscal` WRITE;
/*!40000 ALTER TABLE `mod_notafiscal` DISABLE KEYS */;
/*!40000 ALTER TABLE `mod_notafiscal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mod_orcamentos`
--

DROP TABLE IF EXISTS `mod_orcamentos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mod_orcamentos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mod_orcamentos`
--

LOCK TABLES `mod_orcamentos` WRITE;
/*!40000 ALTER TABLE `mod_orcamentos` DISABLE KEYS */;
/*!40000 ALTER TABLE `mod_orcamentos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mod_veiculos`
--

DROP TABLE IF EXISTS `mod_veiculos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `mod_veiculos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mod_veiculos`
--

LOCK TABLES `mod_veiculos` WRITE;
/*!40000 ALTER TABLE `mod_veiculos` DISABLE KEYS */;
/*!40000 ALTER TABLE `mod_veiculos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sys_user`
--

DROP TABLE IF EXISTS `sys_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sys_user` (
  `id` int(10) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `grupo` int(11) NOT NULL,
  `codigo` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `tipo` int(11) NOT NULL,
  `pass` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id_UNIQUE` (`id`),
  UNIQUE KEY `codigo_UNIQUE` (`codigo`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sys_user`
--

LOCK TABLES `sys_user` WRITE;
/*!40000 ALTER TABLE `sys_user` DISABLE KEYS */;
INSERT INTO `sys_user` VALUES (0000000001,1,1,'cesar filho',1,'1234');
/*!40000 ALTER TABLE `sys_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-07-23 20:59:56
