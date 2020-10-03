--
-- Table structure for table `user`
-- mysql -u root slim < user.sql;
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'ROLE_USER',
  `createdAt` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX (`username`, `email`)
) ENGINE=InnoDB CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'admin','admin@mail.com', '$2y$09$IbjFkFjjEfa16vy6RPUju.VhFXm.dAiQ9Wye0q/X.1wHfdETCGG9W', 'Админ Админович', 'ROLE_ADMIN', '2020-10-03 05:37:51');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
