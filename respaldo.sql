-- MySQL dump 10.13  Distrib 8.0.44, for Linux (x86_64)
--
-- Host: localhost    Database: PROYECTO
-- ------------------------------------------------------
-- Server version	8.0.44-0ubuntu0.24.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `autor`
--

DROP TABLE IF EXISTS `autor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `autor` (
  `id_autor` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(32) DEFAULT NULL,
  `apellido` varchar(64) DEFAULT NULL,
  `nacionalidad` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id_autor`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `autor`
--

LOCK TABLES `autor` WRITE;
/*!40000 ALTER TABLE `autor` DISABLE KEYS */;
INSERT INTO `autor` VALUES (1,'Miguel','de Cervantes','Española'),(2,'Gabriel','García Márquez','Colombiana'),(3,'Jane','Austen','Británica'),(4,'George','Orwell','Británica'),(5,'Antoine','de Saint-Exupéry','Francesa'),(6,'Fyodor','Dostoievski','Rusa'),(7,'J.R.R.','Tolkien','Británica'),(8,'J.K.','Rowling','Británica'),(9,'Stephen','King','Estadounidense'),(10,'Ernest','Hemingway','Estadounidense'),(11,'Julio','Cortázar','Argentina'),(12,'Jorge Luis','Borges','Argentina'),(13,'Isabel','Allende','Chilena'),(14,'Mark','Twain','Estadounidense'),(15,'Oscar','Wilde','Irlandesa'),(16,'Edgar Allan','Poe','Estadounidense'),(17,'Charles','Dickens','Británica'),(18,'Victor','Hugo','Francesa'),(19,'Leo','Tolstói','Rusa'),(20,'Franz','Kafka','Checa');
/*!40000 ALTER TABLE `autor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compra`
--

DROP TABLE IF EXISTS `compra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `compra` (
  `id_compra` int NOT NULL AUTO_INCREMENT,
  `cliente` int NOT NULL,
  `fecha_venta` date NOT NULL,
  `id_empleado` int DEFAULT NULL,
  PRIMARY KEY (`id_compra`),
  KEY `fkComprasEmpleado` (`id_empleado`),
  KEY `fk_cliente` (`cliente`),
  CONSTRAINT `fk_cliente` FOREIGN KEY (`cliente`) REFERENCES `usuario` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fkComprasEmpleado` FOREIGN KEY (`id_empleado`) REFERENCES `empleado` (`id_empleado`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compra`
--

LOCK TABLES `compra` WRITE;
/*!40000 ALTER TABLE `compra` DISABLE KEYS */;
INSERT INTO `compra` VALUES (8,1,'2025-11-29',NULL),(9,4,'2025-11-29',NULL),(10,4,'2025-11-29',NULL),(11,1,'2025-11-29',NULL),(12,4,'2025-11-29',NULL);
/*!40000 ALTER TABLE `compra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `editorial`
--

DROP TABLE IF EXISTS `editorial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `editorial` (
  `id_editorial` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(32) DEFAULT NULL,
  `pais` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id_editorial`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `editorial`
--

LOCK TABLES `editorial` WRITE;
/*!40000 ALTER TABLE `editorial` DISABLE KEYS */;
INSERT INTO `editorial` VALUES (1,'Harper Collins','Estados Unidos'),(2,'Grupo Planeta','España'),(3,'Editorial Anagrama','España'),(4,'Ediciones Norma','Colombia'),(5,'Bloomsburry Publishing','Reino Unido'),(6,'Gallimard','Francia'),(7,'FCE','Mexico'),(8,'Sexto Piso','Mexico'),(9,'Penguin Random House','Mexico'),(10,'Editorial Planeta Chile','Chile');
/*!40000 ALTER TABLE `editorial` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `empleado`
--

DROP TABLE IF EXISTS `empleado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `empleado` (
  `id_empleado` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(32) DEFAULT NULL,
  `apellidos` varchar(64) DEFAULT NULL,
  `fecha_nacimiento` date DEFAULT (curdate()),
  `telefono` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id_empleado`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `empleado`
--

LOCK TABLES `empleado` WRITE;
/*!40000 ALTER TABLE `empleado` DISABLE KEYS */;
INSERT INTO `empleado` VALUES (1,'Venta','En Linea','2025-11-27','4432611287'),(2,'Ricardo','Lopez Castro','1998-05-16','4433154260'),(3,'Roberto','Lazaro Castillo','1995-01-29','4431021845'),(4,'Fabian','Cisneros Vela','2000-12-15','4434758420'),(5,'Felix','Valle Pineda','2001-11-09','4438451203'),(6,'Renata','Ruiz Rivera','1999-08-11','4433120564'),(7,'Rosa','Sanchez Hernandez','1995-06-22','4431284560'),(8,'Alicia','Perez Pineda','1998-10-09','4430124875'),(9,'Andres','Calles Peña','1997-01-21','4433201546');
/*!40000 ALTER TABLE `empleado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `genero`
--

DROP TABLE IF EXISTS `genero`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `genero` (
  `id_genero` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(256) NOT NULL,
  `descripcion` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id_genero`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `genero`
--

LOCK TABLES `genero` WRITE;
/*!40000 ALTER TABLE `genero` DISABLE KEYS */;
INSERT INTO `genero` VALUES (1,'Clasicos',''),(2,'Romance',''),(3,'Terror',''),(4,'Ciencia Ficcion',''),(5,'Aventura',''),(6,'Biografia',''),(7,'Novela Negra',''),(8,'Infantil',''),(9,'Autoayuda',''),(10,'Arte','');
/*!40000 ALTER TABLE `genero` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `informacion`
--

DROP TABLE IF EXISTS `informacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `informacion` (
  `id_informacion` int NOT NULL AUTO_INCREMENT,
  `year_publicacion` date DEFAULT NULL,
  `stock` int NOT NULL,
  `precio_compra` float DEFAULT NULL,
  `precio_venta` float DEFAULT NULL,
  PRIMARY KEY (`id_informacion`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `informacion`
--

LOCK TABLES `informacion` WRITE;
/*!40000 ALTER TABLE `informacion` DISABLE KEYS */;
INSERT INTO `informacion` VALUES (1,'1605-01-16',13,120,180),(2,'1967-05-30',12,150,230),(3,'1813-01-28',7,130,200),(4,'1949-06-08',20,140,220),(5,'1943-04-06',25,110,180),(6,'1866-01-01',7,160,250),(7,'1954-07-29',15,200,320),(8,'1997-06-26',30,180,310),(9,'1977-01-28',4,190,330),(10,'1952-09-01',10,125,210),(11,'1963-06-28',6,145,240),(12,'1944-01-01',10,135,220),(13,'1982-01-01',14,155,260),(14,'1876-01-01',18,120,195),(15,'1890-06-20',8,140,225),(16,'1845-01-29',9,130,210),(17,'1838-02-01',10,150,240),(18,'1862-01-01',7,170,280),(19,'1869-01-01',15,210,350),(20,'1915-01-01',12,135,220);
/*!40000 ALTER TABLE `informacion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `libro`
--

DROP TABLE IF EXISTS `libro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `libro` (
  `id_libro` int NOT NULL AUTO_INCREMENT,
  `titulo` varchar(256) NOT NULL,
  `editorial` int DEFAULT NULL,
  `genero` int DEFAULT NULL,
  `autor` int DEFAULT NULL,
  `informacion` int DEFAULT NULL,
  PRIMARY KEY (`id_libro`),
  KEY `fkLibroInformacion` (`informacion`),
  KEY `fkLibroEditorial` (`editorial`),
  CONSTRAINT `fkLibroInformacion` FOREIGN KEY (`informacion`) REFERENCES `informacion` (`id_informacion`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `libro`
--

LOCK TABLES `libro` WRITE;
/*!40000 ALTER TABLE `libro` DISABLE KEYS */;
INSERT INTO `libro` VALUES (1,'Don Quijote de la Mancha',2,1,1,1),(2,'Cien años de soledad',2,1,2,2),(3,'Orgullo y prejuicio',9,2,3,3),(4,'1984',1,4,4,4),(5,'El principito',2,5,5,5),(6,'Crimen y castigo',6,1,6,6),(7,'El Señor de los Anillos',5,5,7,7),(8,'Harry Potter y la piedra filosofal',5,5,8,8),(9,'El resplandor',1,3,9,9),(10,'El viejo y el mar',1,1,10,10),(11,'Rayuela',3,1,11,11),(12,'Ficciones',3,1,12,12),(13,'La casa de los espíritus',10,1,13,13),(14,'Las aventuras de Tom Sawyer',1,5,14,14),(15,'El retrato de Dorian Gray',3,1,15,15),(16,'El cuervo',1,3,16,16),(17,'Oliver Twist',9,1,17,17),(18,'Los Miserables',9,1,18,18),(19,'Guerra y paz',6,1,19,19),(20,'La metamorfosis',3,1,20,20);
/*!40000 ALTER TABLE `libro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `libro_autor`
--

DROP TABLE IF EXISTS `libro_autor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `libro_autor` (
  `id_libro` int NOT NULL,
  `id_autor` int NOT NULL,
  PRIMARY KEY (`id_libro`,`id_autor`),
  KEY `fk_aut_lib` (`id_autor`),
  CONSTRAINT `fk_aut_lib` FOREIGN KEY (`id_autor`) REFERENCES `autor` (`id_autor`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_lib_aut` FOREIGN KEY (`id_libro`) REFERENCES `libro` (`id_libro`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `libro_autor`
--

LOCK TABLES `libro_autor` WRITE;
/*!40000 ALTER TABLE `libro_autor` DISABLE KEYS */;
INSERT INTO `libro_autor` VALUES (1,1),(2,2),(3,3),(4,4),(5,5),(6,6),(7,7),(8,8),(9,9),(10,10),(11,11),(12,12),(13,13),(14,14),(15,15),(16,16),(17,17),(18,18),(19,19),(20,20);
/*!40000 ALTER TABLE `libro_autor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `libro_compra`
--

DROP TABLE IF EXISTS `libro_compra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `libro_compra` (
  `id_libro` int NOT NULL,
  `id_compra` int NOT NULL,
  PRIMARY KEY (`id_libro`,`id_compra`),
  KEY `fk_com_lib` (`id_compra`),
  CONSTRAINT `fk_com_lib` FOREIGN KEY (`id_compra`) REFERENCES `compra` (`id_compra`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_lib_com` FOREIGN KEY (`id_libro`) REFERENCES `libro` (`id_libro`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `libro_compra`
--

LOCK TABLES `libro_compra` WRITE;
/*!40000 ALTER TABLE `libro_compra` DISABLE KEYS */;
INSERT INTO `libro_compra` VALUES (1,8),(2,8),(1,9),(2,9),(1,10),(20,11),(1,12),(2,12);
/*!40000 ALTER TABLE `libro_compra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `libro_editorial`
--

DROP TABLE IF EXISTS `libro_editorial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `libro_editorial` (
  `id_libro` int NOT NULL,
  `id_editorial` int NOT NULL,
  PRIMARY KEY (`id_libro`,`id_editorial`),
  KEY `fk_libedit` (`id_editorial`),
  CONSTRAINT `fk_lib_edi` FOREIGN KEY (`id_libro`) REFERENCES `libro` (`id_libro`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_libedit` FOREIGN KEY (`id_editorial`) REFERENCES `editorial` (`id_editorial`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `libro_editorial`
--

LOCK TABLES `libro_editorial` WRITE;
/*!40000 ALTER TABLE `libro_editorial` DISABLE KEYS */;
INSERT INTO `libro_editorial` VALUES (4,1),(9,1),(10,1),(14,1),(1,2),(2,2),(5,2),(11,3),(12,3),(15,3),(20,3),(7,5),(8,5),(6,6),(19,6),(3,9),(16,9),(17,9),(18,9),(13,10);
/*!40000 ALTER TABLE `libro_editorial` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `libro_genero`
--

DROP TABLE IF EXISTS `libro_genero`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `libro_genero` (
  `id_libro` int NOT NULL,
  `id_genero` int NOT NULL,
  PRIMARY KEY (`id_libro`,`id_genero`),
  KEY `fk_gen_lib` (`id_genero`),
  CONSTRAINT `fk_gen_lib` FOREIGN KEY (`id_genero`) REFERENCES `genero` (`id_genero`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_lib_gen` FOREIGN KEY (`id_libro`) REFERENCES `libro` (`id_libro`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `libro_genero`
--

LOCK TABLES `libro_genero` WRITE;
/*!40000 ALTER TABLE `libro_genero` DISABLE KEYS */;
INSERT INTO `libro_genero` VALUES (1,1),(2,1),(3,1),(5,1),(6,1),(10,1),(11,1),(12,1),(13,1),(15,1),(17,1),(18,1),(19,1),(20,1),(3,2),(9,3),(16,3),(4,4),(1,5),(5,5),(7,5),(8,5),(14,5),(5,8);
/*!40000 ALTER TABLE `libro_genero` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id_usuario` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(32) DEFAULT NULL,
  `apellido` varchar(64) DEFAULT NULL,
  `correo` varchar(128) DEFAULT NULL,
  `telefono` varchar(16) DEFAULT NULL,
  `domicilio` varchar(128) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`),
  UNIQUE KEY `correo` (`correo`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'Gerardo','Miranda','gera@gmail.com','4432611287','kldnsnfjlsnjlfsn','55151'),(4,'Anibal','Zavala','zava@gmail.com','4431302114','kfnrgrfjfgn','123456'),(5,'Pedro','Fernandez','pedro@gmail.com','443236548','kfrekgekgnjenje','987654321'),(6,'Registro','Prueba','prueba@gmail.com','443568555','ewouiwuoiwei','12345'),(10,'hola','hola','1234@gmail.com','445897858','wqioeoqwihd','1234566');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-11-30 19:19:56
