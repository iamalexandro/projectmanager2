-- MySQL dump 10.13  Distrib 5.7.18, for Win64 (x86_64)
--
-- Host: localhost    Database: projectmanager
-- ------------------------------------------------------
-- Server version	5.7.18-log

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
-- Table structure for table `administrador`
--

DROP TABLE IF EXISTS `administrador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `administrador` (
  `id_docente` int(10) NOT NULL,
  `estado` varchar(20) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  PRIMARY KEY (`id_docente`),
  CONSTRAINT `administrador_pfk` FOREIGN KEY (`id_docente`) REFERENCES `docente` (`id_docente`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Tabla que guarda los datos de los administradores';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `administrador`
--

LOCK TABLES `administrador` WRITE;
/*!40000 ALTER TABLE `administrador` DISABLE KEYS */;
INSERT INTO `administrador` VALUES (1,'Activo','2017-06-13',NULL),(4,'Activo','2017-06-14',NULL),(16,'Activo','2017-06-21',NULL);
/*!40000 ALTER TABLE `administrador` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `curso`
--

DROP TABLE IF EXISTS `curso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `curso` (
  `id_curso` int(10) NOT NULL AUTO_INCREMENT,
  `codigo` varchar(100) DEFAULT NULL,
  `nombre` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_curso`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='Tabla que guarda los datos de los cursos';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `curso`
--

LOCK TABLES `curso` WRITE;
/*!40000 ALTER TABLE `curso` DISABLE KEYS */;
INSERT INTO `curso` VALUES (1,'1150605','Analisis y diseno de sistemas'),(2,'1150606','Seminario de investigacion II'),(3,'11500704','Teoria General de las Comunicaciones'),(4,'1150809','Formulacion y evaluacion de proyectos'),(5,'1150705','Ingenieria de software'),(6,'1150804','Redes de computadores'),(7,'1150604','Sistemas operativos'),(9,'1150817','Gestion de bases de datos');
/*!40000 ALTER TABLE `curso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `curso_docente`
--

DROP TABLE IF EXISTS `curso_docente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `curso_docente` (
  `id_curso_docente` int(10) NOT NULL AUTO_INCREMENT,
  `id_curso` int(10) NOT NULL,
  `id_docente` int(11) DEFAULT NULL,
  `grupo` varchar(1) DEFAULT NULL,
  `anio` int(4) DEFAULT NULL,
  `periodo` int(1) DEFAULT NULL,
  PRIMARY KEY (`id_curso_docente`),
  KEY `curso_docente_docente_fk` (`id_docente`),
  KEY `curso_docente_curso_fk` (`id_curso`),
  CONSTRAINT `curso_docente_curso_fk` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id_curso`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `curso_docente_docente_fk` FOREIGN KEY (`id_docente`) REFERENCES `docente` (`id_docente`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Tabla que guarda los datos de los docentes_cursos';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `curso_docente`
--

LOCK TABLES `curso_docente` WRITE;
/*!40000 ALTER TABLE `curso_docente` DISABLE KEYS */;
INSERT INTO `curso_docente` VALUES (1,1,1,'A',2017,1),(2,3,4,'A',2017,1);
/*!40000 ALTER TABLE `curso_docente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `curso_estudiante`
--

DROP TABLE IF EXISTS `curso_estudiante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `curso_estudiante` (
  `id_curso_estudiante` int(10) NOT NULL AUTO_INCREMENT,
  `id_curso` int(10) NOT NULL,
  `id_estudiante` int(10) NOT NULL,
  `grupo` varchar(1) NOT NULL,
  `anio` int(4) NOT NULL,
  `periodo` int(1) NOT NULL,
  PRIMARY KEY (`id_curso_estudiante`),
  KEY `curso_estudiante_curso_fk` (`id_curso`),
  CONSTRAINT `curso_estudiante_curso_fk` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id_curso`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `curso_estudiante`
--

LOCK TABLES `curso_estudiante` WRITE;
/*!40000 ALTER TABLE `curso_estudiante` DISABLE KEYS */;
/*!40000 ALTER TABLE `curso_estudiante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `docente`
--

DROP TABLE IF EXISTS `docente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `docente` (
  `id_docente` int(10) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `correo` varchar(100) NOT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `contrasena` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_docente`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='Tabla que guarda los datos de los docentes';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `docente`
--

LOCK TABLES `docente` WRITE;
/*!40000 ALTER TABLE `docente` DISABLE KEYS */;
INSERT INTO `docente` VALUES (1,'Carlos Tapias','carlosalexistr@ufps.edu.co','3213332323','$2y$10$ska9rqTEaTzFi7fkQdBw9eNDP8keFIQ1LAzCioRZKSn74ciTOm.ki'),(4,'Brayam Mora','brayamalbertoma@ufps.edu.co','3213342362','$2y$10$/2yQIoPCDbMf4cB6p.wR3OlNM824ycMTj2Qkvdu0IUxNWSFvGShAK'),(5,'Julian Olarte','fredyjulianot@ufps.edu.co','5755656','$2y$10$m5WWiMfoMDIxotM8sZ/6uucnGYoSYn/1.1VYyIikhla8XPNVd14Q2'),(14,'Janeth Parada','janethpc@ufps.edu.co','3243342333','$2y$10$kzv289hlAsjSo.wQXCPCAOz3xghfLK3O.8BZhu9Lr.NukRJNqhk5C'),(15,'Martin Calixto','mcalixto@ufps.edu.co','3155432213','$2y$10$MKF4IBF3rQVWKSFFxzwAZu4KVeceo8bCYFiOO2sdirQJ1hrAM3ake'),(16,'Pilar Rodriguez','judithdelpilart@ufps.edu.co','32111123232','$2y$10$XEhgrr4s/d1YbtmCqXg3H.oIWlPXCLbaoYNcDF7FrewZj0cKhgyou');
/*!40000 ALTER TABLE `docente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estudiante`
--

DROP TABLE IF EXISTS `estudiante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `estudiante` (
  `id_estudiante` int(10) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `correo` varchar(100) DEFAULT NULL,
  `telefono` varchar(50) DEFAULT NULL,
  `contrasena` varchar(100) DEFAULT NULL,
  `codigo` int(11) NOT NULL,
  PRIMARY KEY (`id_estudiante`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='Tabla que guarda los datos de los estudiantes';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estudiante`
--

LOCK TABLES `estudiante` WRITE;
/*!40000 ALTER TABLE `estudiante` DISABLE KEYS */;
INSERT INTO `estudiante` VALUES (8,'Cristhian Leon','cristian@ufps.edu.co','5555555','123456',1151023),(12,'Cristiano Ronaldo','cristianor@ufps.edu.co','777776','$2y$10$Llasxzy79dv3ZNPGiKmyQ.lIf0XtkOfF7WKYtgUkwC8xoWBG9IZIO',1151010);
/*!40000 ALTER TABLE `estudiante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proyecto`
--

DROP TABLE IF EXISTS `proyecto`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proyecto` (
  `id_proyecto` int(10) NOT NULL AUTO_INCREMENT,
  `id_docente` int(11) DEFAULT NULL,
  `id_curso` int(10) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `descripcion` varchar(200) DEFAULT NULL,
  `url_app` varchar(200) DEFAULT NULL,
  `url_code` varchar(200) DEFAULT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  `archivo` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id_proyecto`),
  KEY `proyecto_docente_fk` (`id_docente`),
  KEY `proyecto_curso_fk` (`id_curso`),
  CONSTRAINT `proyect_curso_fk` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id_curso`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `proyecto_docente_fk` FOREIGN KEY (`id_docente`) REFERENCES `docente` (`id_docente`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='Tabla que guarda los datos de los proyectos';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyecto`
--

LOCK TABLES `proyecto` WRITE;
/*!40000 ALTER TABLE `proyecto` DISABLE KEYS */;
INSERT INTO `proyecto` VALUES (1,1,1,'Gestor de proyectos','Sistema gestor de proyectos del programa ingenieria de sistemas','gestordeproyectos.ufps.edu.co','codigoproyecto.ufps.edu.co','2017-06-15',NULL,'En desarrollo','C:xampphtdocsprojectmanagercontrolador/../archivos/Taller4.pdf'),(2,4,3,'Proyecto de Cableado Estructurado','Realizado con el fin de plantear un diseÃ±o de cableado estructurado.','www.cableadoEstructurado.com','github.com/brayammora/cableadoEstructurado','2017-06-21',NULL,'En desarrollo','C:xampphtdocsprojectmanagercontrolador/../archivos/'),(3,4,3,'Proyecto 2','Proyecto numero 2 jeje','www.proy.com','github.com/brayammora/proy','2017-06-21',NULL,'En desarrollo','C:xampphtdocsprojectmanagercontrolador/../archivos/'),(4,NULL,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `proyecto` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proyecto_estudiante`
--

DROP TABLE IF EXISTS `proyecto_estudiante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proyecto_estudiante` (
  `id_proyecto_estudiante` int(10) NOT NULL AUTO_INCREMENT,
  `id_proyecto` int(10) NOT NULL,
  `id_estudiante` int(10) NOT NULL,
  PRIMARY KEY (`id_proyecto_estudiante`),
  KEY `proyecto_estudiante_proyecto_fk` (`id_proyecto`),
  KEY `proyecto_estudiante_estudiante_fk` (`id_estudiante`),
  CONSTRAINT `proyecto_estudiante_estudiante_fk` FOREIGN KEY (`id_estudiante`) REFERENCES `estudiante` (`id_estudiante`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `proyecto_estudiante_proyecto_fk` FOREIGN KEY (`id_proyecto`) REFERENCES `proyecto` (`id_proyecto`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Tabla que guarda los datos de los proyectos_estudiantes';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyecto_estudiante`
--

LOCK TABLES `proyecto_estudiante` WRITE;
/*!40000 ALTER TABLE `proyecto_estudiante` DISABLE KEYS */;
INSERT INTO `proyecto_estudiante` VALUES (1,3,8);
/*!40000 ALTER TABLE `proyecto_estudiante` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-11-18 22:04:38
