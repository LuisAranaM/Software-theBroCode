CREATE DATABASE  IF NOT EXISTS `mydb` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `mydb`;
-- MySQL dump 10.13  Distrib 5.7.23, for Win64 (x86_64)
--
-- Host: localhost    Database: mydb
-- ------------------------------------------------------
-- Server version	5.7.20-log

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
-- Table structure for table `actas`
--

DROP TABLE IF EXISTS `actas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `actas` (
  `ID_ACTA` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ID_SEMESTRE` int(10) unsigned NOT NULL,
  `ID_ESPECIALIDAD` int(10) unsigned NOT NULL,
  `ACTA` mediumblob,
  `FECHA_REGISTRO` datetime DEFAULT NULL,
  `FECHA_ACTUALIZACION` datetime DEFAULT NULL,
  `USUARIO_MODIF` int(11) DEFAULT NULL,
  `ESTADO` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_ACTA`,`ID_SEMESTRE`,`ID_ESPECIALIDAD`),
  KEY `fk_Actas_Semestres1` (`ID_SEMESTRE`),
  KEY `fk_Actas_Especialidades1` (`ID_ESPECIALIDAD`),
  CONSTRAINT `fk_Actas_Especialidades1` FOREIGN KEY (`ID_ESPECIALIDAD`) REFERENCES `especialidades` (`id_especialidad`),
  CONSTRAINT `fk_Actas_Semestres1` FOREIGN KEY (`ID_SEMESTRE`) REFERENCES `semestres` (`id_semestre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `actas`
--

LOCK TABLES `actas` WRITE;
/*!40000 ALTER TABLE `actas` DISABLE KEYS */;
/*!40000 ALTER TABLE `actas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alumnos`
--

DROP TABLE IF EXISTS `alumnos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alumnos` (
  `ID_ALUMNO` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `NOMBRES` varchar(145) DEFAULT NULL,
  `APELLIDO_PATERNO` varchar(45) DEFAULT NULL,
  `APELLIDO_MATERNO` varchar(45) DEFAULT NULL,
  `CODIGO` varchar(45) DEFAULT NULL,
  `FECHA_REGISTRO` datetime DEFAULT NULL,
  `FECHA_ACTUALIZACION` datetime DEFAULT NULL,
  `USUARIO_MODIF` int(11) DEFAULT NULL,
  `ESTADO` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_ALUMNO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumnos`
--

LOCK TABLES `alumnos` WRITE;
/*!40000 ALTER TABLE `alumnos` DISABLE KEYS */;
/*!40000 ALTER TABLE `alumnos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `alumnos_has_horarios`
--

DROP TABLE IF EXISTS `alumnos_has_horarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alumnos_has_horarios` (
  `ID_ALUMNO` int(10) unsigned NOT NULL,
  `ID_HORARIO` int(10) unsigned NOT NULL,
  `ID_PROYECTO` int(10) unsigned NOT NULL,
  `semestres_ID_SEMESTRE` int(10) unsigned NOT NULL,
  `FECHA_REGISTRO` datetime DEFAULT NULL,
  `FECHA_ACTUALIZACION` datetime DEFAULT NULL,
  `USUARIO_MODIF` int(11) DEFAULT NULL,
  `ESTADO` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_ALUMNO`,`ID_HORARIO`,`ID_PROYECTO`,`semestres_ID_SEMESTRE`),
  KEY `fk_Alumnos_has_Horarios_Horarios1` (`ID_HORARIO`),
  KEY `fk_Alumnos_has_Horarios_Proyectos1` (`ID_PROYECTO`),
  KEY `fk_alumnos_has_horarios_semestres1_idx` (`semestres_ID_SEMESTRE`),
  CONSTRAINT `fk_Alumnos_has_Horarios_Alumnos1` FOREIGN KEY (`ID_ALUMNO`) REFERENCES `alumnos` (`ID_ALUMNO`),
  CONSTRAINT `fk_Alumnos_has_Horarios_Horarios1` FOREIGN KEY (`ID_HORARIO`) REFERENCES `horario` (`id_horario`),
  CONSTRAINT `fk_Alumnos_has_Horarios_Proyectos1` FOREIGN KEY (`ID_PROYECTO`) REFERENCES `proyectos` (`id_proyecto`),
  CONSTRAINT `fk_alumnos_has_horarios_semestres1` FOREIGN KEY (`semestres_ID_SEMESTRE`) REFERENCES `semestres` (`ID_SEMESTRE`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `alumnos_has_horarios`
--

LOCK TABLES `alumnos_has_horarios` WRITE;
/*!40000 ALTER TABLE `alumnos_has_horarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `alumnos_has_horarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `criterio`
--

DROP TABLE IF EXISTS `criterio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `criterio` (
  `ID_CRITERIO` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ID_ESPECIALIDAD` int(10) unsigned NOT NULL,
  `ID_SEMESTRE` int(10) unsigned NOT NULL,
  `NOMBRE` varchar(45) DEFAULT NULL,
  `FECHA_REGISTRO` datetime DEFAULT NULL,
  `FECHA_ACTUALIZACION` datetime DEFAULT NULL,
  `USUARIO_MODIF` int(11) DEFAULT NULL,
  `ESTADO` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_CRITERIO`,`ID_ESPECIALIDAD`,`ID_SEMESTRE`),
  KEY `fk_Criterios_Especialidades1` (`ID_ESPECIALIDAD`),
  KEY `fk_Criterios_Semestres1` (`ID_SEMESTRE`),
  CONSTRAINT `fk_Criterios_Especialidades1` FOREIGN KEY (`ID_ESPECIALIDAD`) REFERENCES `especialidades` (`id_especialidad`),
  CONSTRAINT `fk_Criterios_Semestres1` FOREIGN KEY (`ID_SEMESTRE`) REFERENCES `semestres` (`id_semestre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `criterio`
--

LOCK TABLES `criterio` WRITE;
/*!40000 ALTER TABLE `criterio` DISABLE KEYS */;
/*!40000 ALTER TABLE `criterio` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cursos`
--

DROP TABLE IF EXISTS `cursos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cursos` (
  `ID_CURSO` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ID_ESPECIALIDAD` int(10) unsigned NOT NULL,
  `semestres_ID_SEMESTRE` int(10) unsigned NOT NULL,
  `NOMBRE` varchar(45) DEFAULT NULL,
  `CODIGO_CURSO` varchar(45) DEFAULT NULL,
  `FECHA_REGISTRO` datetime DEFAULT NULL,
  `FECHA_ACTUALIZACION` datetime DEFAULT NULL,
  `ESTADO_ACREDITACION` int(11) DEFAULT NULL,
  `USUARIO_MODIF` int(11) DEFAULT NULL,
  `ESTADO` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_CURSO`,`ID_ESPECIALIDAD`,`semestres_ID_SEMESTRE`),
  KEY `fk_Cursos_Especialidades1` (`ID_ESPECIALIDAD`),
  KEY `fk_cursos_semestres1_idx` (`semestres_ID_SEMESTRE`),
  CONSTRAINT `fk_Cursos_Especialidades1` FOREIGN KEY (`ID_ESPECIALIDAD`) REFERENCES `especialidades` (`id_especialidad`),
  CONSTRAINT `fk_cursos_semestres1` FOREIGN KEY (`semestres_ID_SEMESTRE`) REFERENCES `semestres` (`ID_SEMESTRE`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cursos`
--

LOCK TABLES `cursos` WRITE;
/*!40000 ALTER TABLE `cursos` DISABLE KEYS */;
/*!40000 ALTER TABLE `cursos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eos`
--

DROP TABLE IF EXISTS `eos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `eos` (
  `ID_EOS` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ID_SEMESTRE` int(10) unsigned NOT NULL,
  `ID_ESPECIALIDAD` int(10) unsigned NOT NULL,
  `FECHA_REGISTRO` datetime DEFAULT NULL,
  `FECHA_ACTUALIZACION` datetime DEFAULT NULL,
  `USUARIO_MODIF` int(11) DEFAULT NULL,
  `ESTADO` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_EOS`,`ID_SEMESTRE`,`ID_ESPECIALIDAD`),
  KEY `fk_EOS_Semestres1` (`ID_SEMESTRE`),
  KEY `fk_EOS_Especialidades1` (`ID_ESPECIALIDAD`),
  CONSTRAINT `fk_EOS_Especialidades1` FOREIGN KEY (`ID_ESPECIALIDAD`) REFERENCES `especialidades` (`id_especialidad`),
  CONSTRAINT `fk_EOS_Semestres1` FOREIGN KEY (`ID_SEMESTRE`) REFERENCES `semestres` (`id_semestre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eos`
--

LOCK TABLES `eos` WRITE;
/*!40000 ALTER TABLE `eos` DISABLE KEYS */;
/*!40000 ALTER TABLE `eos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `escala_calificacion`
--

DROP TABLE IF EXISTS `escala_calificacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `escala_calificacion` (
  `ID_ESCALA` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(145) DEFAULT NULL,
  `FECHA_REGISTRO` datetime DEFAULT NULL,
  `FECHA_ACTUALIZACION` datetime DEFAULT NULL,
  `USUARIO_MODIF` int(11) DEFAULT NULL,
  `ESTADO` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_ESCALA`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `escala_calificacion`
--

LOCK TABLES `escala_calificacion` WRITE;
/*!40000 ALTER TABLE `escala_calificacion` DISABLE KEYS */;
/*!40000 ALTER TABLE `escala_calificacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `especialidades`
--

DROP TABLE IF EXISTS `especialidades`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `especialidades` (
  `ID_ESPECIALIDAD` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(45) DEFAULT NULL,
  `FECHA_REGISTRO` datetime DEFAULT NULL,
  `FECHA_ACTUALIZACION` datetime DEFAULT NULL,
  `USUARIO_MODIF` int(11) DEFAULT NULL,
  `ESTADO` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_ESPECIALIDAD`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `especialidades`
--

LOCK TABLES `especialidades` WRITE;
/*!40000 ALTER TABLE `especialidades` DISABLE KEYS */;
/*!40000 ALTER TABLE `especialidades` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `especialidades_has_profesores`
--

DROP TABLE IF EXISTS `especialidades_has_profesores`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `especialidades_has_profesores` (
  `ID_ESPECIALIDAD` int(10) unsigned NOT NULL,
  `ID_USUARIO` int(10) unsigned NOT NULL,
  `FECHA_REGISTRO` datetime DEFAULT NULL,
  `FECHA_ACTUALIZACION` datetime DEFAULT NULL,
  `USUARIO_MODIF` int(11) DEFAULT NULL,
  `ESTADO` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_ESPECIALIDAD`,`ID_USUARIO`),
  KEY `fk_ESPECIALIDADES_HAS_PROFESORES_USUARIOS1` (`ID_USUARIO`),
  CONSTRAINT `fk_ESPECIALIDADES_HAS_PROFESORES_USUARIOS1` FOREIGN KEY (`ID_USUARIO`) REFERENCES `usuarios` (`id_usuario`),
  CONSTRAINT `fk_Especialidades_has_Profesores_Especialidades1` FOREIGN KEY (`ID_ESPECIALIDAD`) REFERENCES `especialidades` (`ID_ESPECIALIDAD`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `especialidades_has_profesores`
--

LOCK TABLES `especialidades_has_profesores` WRITE;
/*!40000 ALTER TABLE `especialidades_has_profesores` DISABLE KEYS */;
/*!40000 ALTER TABLE `especialidades_has_profesores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `horario`
--

DROP TABLE IF EXISTS `horario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `horario` (
  `ID_HORARIO` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ID_CURSO` int(10) unsigned NOT NULL,
  `ID_ESPECIALIDAD` int(10) unsigned NOT NULL,
  `semestres_ID_SEMESTRE` int(10) unsigned NOT NULL,
  `NOMBRE` varchar(70) DEFAULT NULL,
  `FECHA_REGISTRO` datetime DEFAULT NULL,
  `FECHA_ACTUALIZACION` datetime DEFAULT NULL,
  `USUARIO_MODIF` int(11) DEFAULT NULL,
  `ESTADO` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_HORARIO`,`ID_CURSO`,`ID_ESPECIALIDAD`,`semestres_ID_SEMESTRE`),
  KEY `fk_Horarios_Cursos1` (`ID_CURSO`,`ID_ESPECIALIDAD`),
  KEY `fk_horario_semestres1_idx` (`semestres_ID_SEMESTRE`),
  CONSTRAINT `fk_Horarios_Cursos1` FOREIGN KEY (`ID_CURSO`, `ID_ESPECIALIDAD`) REFERENCES `cursos` (`ID_CURSO`, `ID_ESPECIALIDAD`),
  CONSTRAINT `fk_horario_semestres1` FOREIGN KEY (`semestres_ID_SEMESTRE`) REFERENCES `semestres` (`ID_SEMESTRE`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `horario`
--

LOCK TABLES `horario` WRITE;
/*!40000 ALTER TABLE `horario` DISABLE KEYS */;
/*!40000 ALTER TABLE `horario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu_has_rol`
--

DROP TABLE IF EXISTS `menu_has_rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_has_rol` (
  `ID_MENU` int(10) unsigned NOT NULL,
  `ID_ROL` int(10) unsigned NOT NULL,
  `FECHA_REGISTRO` datetime DEFAULT NULL,
  `FECHA_ACTUALIZACION` datetime DEFAULT NULL,
  `USUARIO_MODIF` int(11) DEFAULT NULL,
  `ESTADO` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_MENU`,`ID_ROL`),
  KEY `fk_Menu_has_Rol_Rol1` (`ID_ROL`),
  CONSTRAINT `fk_Menu_has_Rol_Menu` FOREIGN KEY (`ID_MENU`) REFERENCES `menus` (`id_menu`),
  CONSTRAINT `fk_Menu_has_Rol_Rol1` FOREIGN KEY (`ID_ROL`) REFERENCES `roles` (`id_rol`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_has_rol`
--

LOCK TABLES `menu_has_rol` WRITE;
/*!40000 ALTER TABLE `menu_has_rol` DISABLE KEYS */;
/*!40000 ALTER TABLE `menu_has_rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus` (
  `ID_MENU` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(45) DEFAULT NULL,
  `FECHA_REGISTRO` datetime DEFAULT NULL,
  `FECHA_ACTUALIZACION` datetime DEFAULT NULL,
  `USUARIO_MODIF` int(11) DEFAULT NULL,
  `ESTADO` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_MENU`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `planes_de_mejoras`
--

DROP TABLE IF EXISTS `planes_de_mejoras`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `planes_de_mejoras` (
  `ID_PLAN` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ID_SEMESTRE` int(10) unsigned NOT NULL,
  `ID_ESPECIALIDAD` int(10) unsigned NOT NULL,
  `PLAN` mediumblob,
  `FECHA_REGISTRO` datetime DEFAULT NULL,
  `FECHA_ACTUALIZACION` datetime DEFAULT NULL,
  `USUARIO_MODIF` int(11) DEFAULT NULL,
  `ESTADO` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_PLAN`,`ID_SEMESTRE`,`ID_ESPECIALIDAD`),
  KEY `fk_PlanDeMejoras_Semestres1` (`ID_SEMESTRE`),
  KEY `fk_PlanDeMejoras_Especialidades1` (`ID_ESPECIALIDAD`),
  CONSTRAINT `fk_PlanDeMejoras_Especialidades1` FOREIGN KEY (`ID_ESPECIALIDAD`) REFERENCES `especialidades` (`ID_ESPECIALIDAD`),
  CONSTRAINT `fk_PlanDeMejoras_Semestres1` FOREIGN KEY (`ID_SEMESTRE`) REFERENCES `semestres` (`id_semestre`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `planes_de_mejoras`
--

LOCK TABLES `planes_de_mejoras` WRITE;
/*!40000 ALTER TABLE `planes_de_mejoras` DISABLE KEYS */;
/*!40000 ALTER TABLE `planes_de_mejoras` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profesores_has_horarios`
--

DROP TABLE IF EXISTS `profesores_has_horarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profesores_has_horarios` (
  `ID_USUARIO` int(10) unsigned NOT NULL,
  `ID_HORARIO` int(10) unsigned NOT NULL,
  `FECHA_REGISTRO` datetime DEFAULT NULL,
  `FECHA_ACTUALIZACION` datetime DEFAULT NULL,
  `USUARIO_MODIF` int(11) DEFAULT NULL,
  `ESTADO` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_USUARIO`,`ID_HORARIO`),
  KEY `fk_Profesores_has_Horarios_Horarios1` (`ID_HORARIO`),
  CONSTRAINT `fk_PROFESORES_HAS_HORARIOS_USUARIOS1` FOREIGN KEY (`ID_USUARIO`) REFERENCES `usuarios` (`id_usuario`),
  CONSTRAINT `fk_Profesores_has_Horarios_Horarios1` FOREIGN KEY (`ID_HORARIO`) REFERENCES `horario` (`ID_HORARIO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profesores_has_horarios`
--

LOCK TABLES `profesores_has_horarios` WRITE;
/*!40000 ALTER TABLE `profesores_has_horarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `profesores_has_horarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `proyectos`
--

DROP TABLE IF EXISTS `proyectos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `proyectos` (
  `ID_PROYECTO` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `PROYECTO` mediumblob,
  `FECHA_REGISTRO` datetime DEFAULT NULL,
  `FECHA_ACTUALIZACION` datetime DEFAULT NULL,
  `USUARIO_MODIF` int(11) DEFAULT NULL,
  `ESTADO` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_PROYECTO`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `proyectos`
--

LOCK TABLES `proyectos` WRITE;
/*!40000 ALTER TABLE `proyectos` DISABLE KEYS */;
/*!40000 ALTER TABLE `proyectos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `ID_ROL` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `NOMBRE` varchar(50) DEFAULT NULL,
  `FECHA_REGISTRO` datetime DEFAULT NULL,
  `FECHA_ACTUALIZACION` datetime DEFAULT NULL,
  `USUARIO_MODIF` int(11) DEFAULT NULL,
  `ESTADO` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_ROL`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'administrador','2018-09-29 15:40:41','2018-09-29 15:40:41',1,1),(2,'coordinador','2018-09-29 15:42:57','2018-09-29 15:42:57',1,1),(3,'asistente','2018-09-29 15:43:21','2018-09-29 15:43:21',1,1),(4,'profesor','2018-09-29 15:43:28','2018-09-29 15:43:28',1,1);
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `semestres`
--

DROP TABLE IF EXISTS `semestres`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `semestres` (
  `ID_SEMESTRE` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `FECHA_INICIO` datetime DEFAULT NULL,
  `FECHA_FIN` datetime DEFAULT NULL,
  `FECHA_ALERTA` datetime DEFAULT NULL,
  `ANHO` int(11) DEFAULT NULL,
  `CICLO` int(11) DEFAULT NULL,
  `FECHA_REGISTRO` datetime DEFAULT NULL,
  `FECHA_ACTUALIZACION` datetime DEFAULT NULL,
  `USUARIO_MODIF` int(11) DEFAULT NULL,
  `ESTADO` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_SEMESTRE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `semestres`
--

LOCK TABLES `semestres` WRITE;
/*!40000 ALTER TABLE `semestres` DISABLE KEYS */;
/*!40000 ALTER TABLE `semestres` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sos`
--

DROP TABLE IF EXISTS `sos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sos` (
  `ID_SOS` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ID_ESPECIALIDAD` int(10) unsigned NOT NULL,
  `ID_SEMESTRE` int(10) unsigned NOT NULL,
  `DESCRIPCION` varchar(100) DEFAULT NULL,
  `FECHA_REGISTRO` datetime DEFAULT NULL,
  `FECHA_ACTUALIZACION` datetime DEFAULT NULL,
  `USUARIO_MODIF` int(11) DEFAULT NULL,
  `ESTADO` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_SOS`,`ID_ESPECIALIDAD`,`ID_SEMESTRE`),
  KEY `fk_SOS_Especialidades1` (`ID_ESPECIALIDAD`),
  KEY `fk_SOS_Semestres1` (`ID_SEMESTRE`),
  CONSTRAINT `fk_SOS_Especialidades1` FOREIGN KEY (`ID_ESPECIALIDAD`) REFERENCES `especialidades` (`ID_ESPECIALIDAD`),
  CONSTRAINT `fk_SOS_Semestres1` FOREIGN KEY (`ID_SEMESTRE`) REFERENCES `semestres` (`ID_SEMESTRE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sos`
--

LOCK TABLES `sos` WRITE;
/*!40000 ALTER TABLE `sos` DISABLE KEYS */;
/*!40000 ALTER TABLE `sos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sos_has_eos`
--

DROP TABLE IF EXISTS `sos_has_eos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sos_has_eos` (
  `ID_SOS` int(10) unsigned NOT NULL,
  `ID_ESPECIALIDAD` int(10) unsigned NOT NULL,
  `ID_SEMESTRE` int(10) unsigned NOT NULL,
  `ID_EOS` int(10) unsigned NOT NULL,
  `FECHA_REGISTRO` datetime DEFAULT NULL,
  `FECHA_ACTUALIZACION` datetime DEFAULT NULL,
  `USUARIO_MODIF` int(11) DEFAULT NULL,
  `ESTADO` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_SOS`,`ID_ESPECIALIDAD`,`ID_SEMESTRE`,`ID_EOS`),
  KEY `fk_SOS_has_EOS_EOS1` (`ID_EOS`),
  CONSTRAINT `fk_SOS_has_EOS_EOS1` FOREIGN KEY (`ID_EOS`) REFERENCES `eos` (`ID_EOS`),
  CONSTRAINT `fk_SOS_has_EOS_SOS1` FOREIGN KEY (`ID_SOS`, `ID_ESPECIALIDAD`, `ID_SEMESTRE`) REFERENCES `sos` (`ID_SOS`, `ID_ESPECIALIDAD`, `ID_SEMESTRE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sos_has_eos`
--

LOCK TABLES `sos_has_eos` WRITE;
/*!40000 ALTER TABLE `sos_has_eos` DISABLE KEYS */;
/*!40000 ALTER TABLE `sos_has_eos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subcriterios`
--

DROP TABLE IF EXISTS `subcriterios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subcriterios` (
  `ID_SUBCRITERIO` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ID_CRITERIO` int(10) unsigned NOT NULL,
  `ID_ESPECIALIDAD` int(10) unsigned NOT NULL,
  `ID_SEMESTRE` int(10) unsigned NOT NULL,
  `NOMBRE` varchar(45) DEFAULT NULL,
  `DESCRIPCION_1` varchar(145) DEFAULT NULL,
  `DESCRIPCION_2` varchar(145) DEFAULT NULL,
  `DESCRIPCION_3` varchar(145) DEFAULT NULL,
  `DESCRIPCION_4` varchar(145) DEFAULT NULL,
  `FECHA_REGISTRO` datetime DEFAULT NULL,
  `FECHA_ACTUALIZACON` datetime DEFAULT NULL,
  `USUARIO_MODIF` int(11) DEFAULT NULL,
  `ESTADO` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_SUBCRITERIO`,`ID_CRITERIO`,`ID_ESPECIALIDAD`,`ID_SEMESTRE`),
  KEY `fk_Subcriterios_Criterios1` (`ID_CRITERIO`,`ID_ESPECIALIDAD`,`ID_SEMESTRE`),
  CONSTRAINT `fk_Subcriterios_Criterios1` FOREIGN KEY (`ID_CRITERIO`, `ID_ESPECIALIDAD`, `ID_SEMESTRE`) REFERENCES `criterio` (`ID_CRITERIO`, `ID_ESPECIALIDAD`, `ID_SEMESTRE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subcriterios`
--

LOCK TABLES `subcriterios` WRITE;
/*!40000 ALTER TABLE `subcriterios` DISABLE KEYS */;
/*!40000 ALTER TABLE `subcriterios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subcriterios_has_alumnos_has_horarios`
--

DROP TABLE IF EXISTS `subcriterios_has_alumnos_has_horarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subcriterios_has_alumnos_has_horarios` (
  `ID_SUBCRITERIO` int(10) unsigned NOT NULL,
  `ID_CRITERIO` int(10) unsigned NOT NULL,
  `ID_ESPECIALIDAD` int(10) unsigned NOT NULL,
  `ID_SEMESTRE` int(10) unsigned NOT NULL,
  `ID_ALUMNO` int(10) unsigned NOT NULL,
  `ID_HORARIO` int(10) unsigned NOT NULL,
  `ID_ESCALA` int(10) unsigned NOT NULL,
  `semestres_ID_SEMESTRE` int(10) unsigned NOT NULL,
  `FECHA_REGISTRO` datetime DEFAULT NULL,
  `FECHA_ACTUALIZACION` datetime DEFAULT NULL,
  `USUARIO_MODIF` int(11) DEFAULT NULL,
  `ESTADO` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_SUBCRITERIO`,`ID_CRITERIO`,`ID_ESPECIALIDAD`,`ID_SEMESTRE`,`ID_ALUMNO`,`ID_HORARIO`,`ID_ESCALA`,`semestres_ID_SEMESTRE`),
  KEY `fk_Subcriterios_has_Alumnos_has_Horarios_Alumnos_has_Horarios1` (`ID_ALUMNO`,`ID_HORARIO`),
  KEY `fk_Subcriterios_has_Alumnos_has_Horarios_EscalaCalificacion1` (`ID_ESCALA`),
  KEY `fk_subcriterios_has_alumnos_has_horarios_semestres1_idx` (`semestres_ID_SEMESTRE`),
  CONSTRAINT `fk_Subcriterios_has_Alumnos_has_Horarios_Alumnos_has_Horarios1` FOREIGN KEY (`ID_ALUMNO`, `ID_HORARIO`) REFERENCES `alumnos_has_horarios` (`ID_ALUMNO`, `ID_HORARIO`),
  CONSTRAINT `fk_Subcriterios_has_Alumnos_has_Horarios_EscalaCalificacion1` FOREIGN KEY (`ID_ESCALA`) REFERENCES `escala_calificacion` (`ID_ESCALA`),
  CONSTRAINT `fk_Subcriterios_has_Alumnos_has_Horarios_Subcriterios1` FOREIGN KEY (`ID_SUBCRITERIO`, `ID_CRITERIO`, `ID_ESPECIALIDAD`, `ID_SEMESTRE`) REFERENCES `subcriterios` (`ID_SUBCRITERIO`, `ID_CRITERIO`, `ID_ESPECIALIDAD`, `ID_SEMESTRE`),
  CONSTRAINT `fk_subcriterios_has_alumnos_has_horarios_semestres1` FOREIGN KEY (`semestres_ID_SEMESTRE`) REFERENCES `semestres` (`ID_SEMESTRE`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subcriterios_has_alumnos_has_horarios`
--

LOCK TABLES `subcriterios_has_alumnos_has_horarios` WRITE;
/*!40000 ALTER TABLE `subcriterios_has_alumnos_has_horarios` DISABLE KEYS */;
/*!40000 ALTER TABLE `subcriterios_has_alumnos_has_horarios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subcriterios_has_cursos`
--

DROP TABLE IF EXISTS `subcriterios_has_cursos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subcriterios_has_cursos` (
  `ID_SUBCRITERIO` int(10) unsigned NOT NULL,
  `ID_CRITERIO` int(10) unsigned NOT NULL,
  `ID_ESPECIALIDAD` int(10) unsigned NOT NULL,
  `ID_SEMESTRE` int(10) unsigned NOT NULL,
  `ID_CURSO` int(10) unsigned NOT NULL,
  `FECHA_REGISTRO` datetime DEFAULT NULL,
  `FECHA_ACTUALIZACION` datetime DEFAULT NULL,
  `USUARIO_MODIF` int(11) DEFAULT NULL,
  `ESTADO` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID_SUBCRITERIO`,`ID_CRITERIO`,`ID_ESPECIALIDAD`,`ID_SEMESTRE`,`ID_CURSO`),
  KEY `fk_Subcriterios_has_Cursos_Cursos1` (`ID_CURSO`),
  CONSTRAINT `fk_Subcriterios_has_Cursos_Cursos1` FOREIGN KEY (`ID_CURSO`) REFERENCES `cursos` (`ID_CURSO`),
  CONSTRAINT `fk_Subcriterios_has_Cursos_Subcriterios1` FOREIGN KEY (`ID_SUBCRITERIO`, `ID_CRITERIO`, `ID_ESPECIALIDAD`, `ID_SEMESTRE`) REFERENCES `subcriterios` (`ID_SUBCRITERIO`, `ID_CRITERIO`, `ID_ESPECIALIDAD`, `ID_SEMESTRE`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subcriterios_has_cursos`
--

LOCK TABLES `subcriterios_has_cursos` WRITE;
/*!40000 ALTER TABLE `subcriterios_has_cursos` DISABLE KEYS */;
/*!40000 ALTER TABLE `subcriterios_has_cursos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuarios` (
  `ID_USUARIO` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `ID_ROL` int(10) unsigned NOT NULL,
  `USUARIO` varchar(45) DEFAULT NULL,
  `PASS` varchar(200) DEFAULT NULL,
  `CORREO` varchar(100) DEFAULT NULL,
  `FECHA_REGISTRO` datetime DEFAULT NULL,
  `FECHA_ACTUALIZACION` datetime DEFAULT NULL,
  `USUARIO_MODIF` int(11) DEFAULT NULL,
  `ESTADO` int(11) DEFAULT NULL,
  `NOMBRES` varchar(50) DEFAULT NULL,
  `APELLIDO_PATERNO` varchar(50) DEFAULT NULL,
  `APELLIDO_MATERNO` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`ID_USUARIO`,`ID_ROL`),
  UNIQUE KEY `ID_USUARIO_UNIQUE` (`ID_USUARIO`),
  KEY `fk_Usuarios_Roles1` (`ID_ROL`),
  CONSTRAINT `fk_Usuarios_Roles1` FOREIGN KEY (`ID_ROL`) REFERENCES `roles` (`ID_ROL`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES (1,1,'20142145','$2y$10$K0RfOqG2cOqXsK.Y9VW7FuQD1V6eV7ComEgQavbC48/R5AWaKcItu','andre.pando@pucp.pe','2018-09-29 15:49:45','2018-09-29 20:53:39',NULL,1,'Enrique André','Pando','Robles'),(2,2,'C0007',NULL,'luis.flores@pucp.pe','2018-09-29 15:49:45','2018-09-29 15:49:45',NULL,1,'Luis','Flores','García'),(3,3,'A0007',NULL,'jhair.sistema@pucp.pe','2018-09-29 15:49:45','2018-09-29 15:49:45',NULL,1,'Jhair','Sistema','Sistema'),(4,4,'P0007',NULL,'freddy.paz@pucp.pe','2018-09-29 15:49:45','2018-09-29 15:49:45',NULL,1,'Freddy','Paz','Arenas');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-09-30 10:59:34
