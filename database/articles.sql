--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE `articles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `articles`
--

LOCK TABLES `articles` WRITE;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
INSERT INTO `articles` VALUES (1,'art1','content art1','2020-09-16 23:01:51'),(2,'art2','big content in art2','2020-09-16 23:01:51'),(19,'new art','content new art','2020-09-18 21:53:32'),(20,'my last art','last art is good content','2020-09-17 21:53:32'),(30,'Article 1','Content article 1','2020-09-30 03:40:41'),(32,'article from curl','content article','2020-09-30 10:15:11');
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;
UNLOCK TABLES;
