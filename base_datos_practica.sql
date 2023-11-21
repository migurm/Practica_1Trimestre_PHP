CREATE DATABASE  IF NOT EXISTS `db_tienda` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_tienda`;
-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: localhost    Database: db_tienda
-- ------------------------------------------------------
-- Server version	8.0.34

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
-- Table structure for table `cestas`
--

DROP TABLE IF EXISTS `cestas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cestas` (
  `idCesta` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(12) NOT NULL,
  `precioTotal` decimal(8,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`idCesta`),
  KEY `usuario` (`usuario`),
  CONSTRAINT `cestas_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cestas`
--

LOCK TABLES `cestas` WRITE;
/*!40000 ALTER TABLE `cestas` DISABLE KEYS */;
INSERT INTO `cestas` VALUES (9,'pruebafinal',0.00),(10,'admin',0.00);
/*!40000 ALTER TABLE `cestas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lineas_pedidos`
--

DROP TABLE IF EXISTS `lineas_pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lineas_pedidos` (
  `lineaPedido` int NOT NULL,
  `idProducto` int DEFAULT NULL,
  `idPedido` int NOT NULL,
  `precioUnitario` float DEFAULT NULL,
  `cantidad` int DEFAULT NULL,
  PRIMARY KEY (`lineaPedido`,`idPedido`),
  KEY `idProducto` (`idProducto`),
  KEY `idPedido` (`idPedido`),
  CONSTRAINT `lineas_pedidos_ibfk_1` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`idProducto`),
  CONSTRAINT `lineas_pedidos_ibfk_2` FOREIGN KEY (`idPedido`) REFERENCES `pedidos` (`idPedido`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lineas_pedidos`
--

LOCK TABLES `lineas_pedidos` WRITE;
/*!40000 ALTER TABLE `lineas_pedidos` DISABLE KEYS */;
/*!40000 ALTER TABLE `lineas_pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pedidos`
--

DROP TABLE IF EXISTS `pedidos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pedidos` (
  `idPedido` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(255) DEFAULT NULL,
  `precioTotal` float DEFAULT '0',
  `fechaPedido` date DEFAULT (curdate()),
  PRIMARY KEY (`idPedido`),
  KEY `usuario` (`usuario`),
  CONSTRAINT `pedidos_ibfk_1` FOREIGN KEY (`usuario`) REFERENCES `usuarios` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pedidos`
--

LOCK TABLES `pedidos` WRITE;
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
INSERT INTO `pedidos` VALUES (9,'pruebafinal',123.75,'2023-11-21'),(10,'pruebafinal',129.83,'2023-11-21'),(11,'pruebafinal',64.6,'2023-11-21'),(12,'pruebafinal',129.2,'2023-11-21'),(13,'pruebafinal',79.8,'2023-11-21'),(14,'pruebafinal',149.75,'2023-11-21'),(15,'pruebafinal',49.9,'2023-11-21'),(16,'pruebafinal',75.95,'2023-11-21'),(17,'pruebafinal',45,'2023-11-21'),(18,'pruebafinal',112.5,'2023-11-21'),(19,'pruebafinal',28,'2023-11-21');
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos`
--

DROP TABLE IF EXISTS `productos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos` (
  `idProducto` int NOT NULL AUTO_INCREMENT,
  `nombreProducto` varchar(40) NOT NULL,
  `precio` decimal(7,2) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `cantidad` decimal(5,0) NOT NULL,
  `imagen` varchar(100) NOT NULL,
  PRIMARY KEY (`idProducto`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos`
--

LOCK TABLES `productos` WRITE;
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` VALUES (3,'C The Programming Language',34.60,'Probablemente el mejor libro de la historia para el lenguaje de programación C.',0,'images/programminC.jpg'),(4,'Álgebra lineal y geometría',30.00,'Libro básico para la asignatura de álgebra de la Universidad de Málaga.',0,'images/algebraUMA.jpg'),(5,'Estructuras de datos y algoritmos',19.95,'Estructuras de datos y algoritmos, introducción.',9,'images/algoritmos.jpg'),(7,'Desarrollo de aplicaciones web con PHP',22.50,'Lenguaje php, estructuras condicionales, estructuras repetitivas, funciones y arreglos.',21,'images/appWebPHP.jpg'),(8,'Aprender a programar en C',29.95,'Programación en C de 0 a 99 en un solo libro, escrito por Amador Mohedano',6,'images/aprenderC.jpg'),(9,'Aprende a programar con Java',19.95,'Probablemente el mejor libro para aprender a programar desde cero.',30,'images/aprenderJava.jpg'),(10,'Arquitectura limpia',40.00,'Guía para especialistas en la estructura y el diseño de software.',8,'images/arquitecturaLimpia.jpg'),(11,'Ciencia de datos desde cero',14.99,'Principios básicos en el lenguaje de programación Python.',8,'images/cienciaDeDatos.jpg'),(12,'Clean Code',35.95,'Consejos y recopilación de buenas prácticas para un código limpio y sostenible en el tiempo.',10,'images/cleanCode.jpg'),(13,'Cobol estructurado',39.99,'Conceptos básicos del lenguaje de programación Cobol, tercera edición.',12,'images/cobol.jpg'),(14,'Curso de desarrollo web HTML CSS JS',19.99,'Curso básico de iniciación en desarrollo web, con sus tres tecnologías principales.',13,'images/desarrolloWeb.jpg'),(15,'Eloquent Javascript',9.99,'Uno de los libros más famosos del lenguaje de programación Javascript',17,'images/eloquentJS.jpg'),(16,'Dónde esconder un cadáver',23.50,'Quién no se ha puesto nervioso alguna vez y ha tenido que salvar la situación',4,'images/esconderCadaver.jpg'),(17,'GitHub desde cero',19.95,'Guía de estudio teórico práctico paso a paso y curso en video.',20,'images/gitHub.jpg'),(18,'Curso intensivo de Python',45.00,'El libro más vendido del mundo sobre el lenguaje Python',15,'images/intensivoPython.jpg'),(19,'Introducción a la programación',19.90,'Conceptos básicos de programación, manual imprescindible.',8,'images/introProgramacion.jpg'),(20,'King C Programming',35.90,'Un enfoque moderno al lenguaje de programación C, uno de los libros más famosos.',12,'images/kingC.jpg'),(21,'El libro negro del Programador',22.75,'Conseguir una carrera de éxito desarrollando software y cómo evitar los errores habituales.',16,'images/libroNegro.jpg'),(22,'Matemática discreta',23.00,'Uma introduçao do matematica du ginga e traduçao da 3 ediçao norte-americana',5,'images/matematicaDiscreta.jpg'),(23,'Matemáticas en la primaria',13.00,'Primer paso antes del álgebra lineal',7,'images/matematicasPrimaria.jpg'),(24,'PHP for Dummies',12.00,'No te sabes la de dolar post, esta es tu solución',10,'images/phpDummies.jpg'),(25,'Curso de php 8 y mysql 8',29.95,'Curso imprescindible para la gestión web de lado del servidor enlazado a baso de datos.',20,'images/phpMysql.jpg'),(26,'Aprende a programar con Java y chatGPT',25.00,'El libro idóneo si estás a punto de ir de prácticas',20,'images/pibeDePracticas.jpg'),(27,'Curso de programación Java',19.95,'Curso completo sobre el lenguaje de programación Java, el papá',19,'images/prograJava.jpg'),(28,'El programador pragmático',55.00,'Un libro para programadores medianamente experimentados, para subir un grado más la eficiencia.',12,'images/programadorPragmatico.jpg'),(29,'Curso de Programación Python',26.00,'Curso básico muy recomendable de la editorial Anaya',15,'images/prograPython.jpg'),(30,'Curso de programación Videojuegos',22.50,'Curso de iniciación de programación enfocada al mundo de los videojuegos, conceptos en C#',21,'images/prograVideojuegos.jpg'),(31,'Teoría de autómatas lenguajes y co',60.00,'No te termina de cuadrar ningún humano, construye tu propia unidad para interactuar con ella',7,'images/teoriaAutomatas.jpg'),(32,'La vuelta del Comunismo',23.00,'Su retorno al Gobierno de España dice, la enésima chifladura de este entrañable e inefable personaje',10,'images/vueltaComunismo.JPG'),(33,'Donde está Wally',17.00,'Pasa un buen rato de entretenimiento en familia buscando a este terrible delincuente sexual antes de que sea tarde',9,'images/wally.jpg');
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `productos_cestas`
--

DROP TABLE IF EXISTS `productos_cestas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `productos_cestas` (
  `idProducto` int NOT NULL,
  `idCesta` int NOT NULL,
  `cantidad` decimal(2,0) NOT NULL,
  PRIMARY KEY (`idProducto`,`idCesta`),
  KEY `fk_productosCestas_cestas` (`idCesta`),
  CONSTRAINT `fk_productosCestas_cestas` FOREIGN KEY (`idCesta`) REFERENCES `cestas` (`idCesta`),
  CONSTRAINT `fk_productosCestas_productos` FOREIGN KEY (`idProducto`) REFERENCES `productos` (`idProducto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `productos_cestas`
--

LOCK TABLES `productos_cestas` WRITE;
/*!40000 ALTER TABLE `productos_cestas` DISABLE KEYS */;
/*!40000 ALTER TABLE `productos_cestas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuarios` (
  `usuario` varchar(12) NOT NULL,
  `contrasena` varchar(255) NOT NULL,
  `fechaNacimiento` date NOT NULL,
  `rol` varchar(10) DEFAULT 'cliente',
  PRIMARY KEY (`usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuarios`
--

LOCK TABLES `usuarios` WRITE;
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` VALUES ('admin','$2y$10$qNyn04uv2xw8emR2yT4jbOhOnfB1DARivgJ9Pi97MoVCc1PqpGsbq','2000-10-10','admin'),('pruebafinal','$2y$10$CR.xmXzvd3K8JewH47YRRejXAuEAZBW1NjmnIr6SuT2ePW6hhDgfG','2000-10-10','admin');
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

-- Dump completed on 2023-11-21 21:14:36
