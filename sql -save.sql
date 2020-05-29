DROP TABLE IF EXISTS `role`;
CREATE TABLE IF NOT EXISTS `role` (
  `ID` int(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_faction` int(1) NOT NULL,
  `Name` varchar(50) COLLATE utf8_bin NOT NULL,
  `Description` varchar(1000) COLLATE utf8_bin NOT NULL,
  `is_unique` tinyint(1) NOT NULL DEFAULT '1',
  `active_at_night` tinyint(1) NOT NULL DEFAULT '0',
  `image_path` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT 'DEFAULT.png',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

INSERT INTO `role` (`ID`, `id_faction`, `Name`, `Description`, `is_unique`, `active_at_night`, `image_path`) VALUES
(1, 2, 'Loup-Garou', 'La nuit venue, les Loups-Garous se mettent d’accord pour mettre à mort un membre du village.\r\n\r\n<br><br>\r\n\r\nEn cas d’égalité des votes (ou d’incapacité à choisir une victime), aucun villageois ne sera assassiné cette nuit.', 0, 1, 'img/roles/1.jpg'),
(2, 2, 'Loup Blanc', 'Créature particulièrement rare, elle se mêle aux Loups-Garous ‘‘normaux’’ pour exterminer le village, mais a pour but ultime d’être le dernier survivant.\r\n<br><br>\r\nSa soif de sang lui permet d’assassiner un joueur supplémentaire (Villageois / Loup-Garou / Indépendant) tous les 2 tours. ', 1, 1, 'img/roles/2.png'),
(3, 2, 'Grand Méchant Loup', 'Mâle Alpha des Loups-Garous, c’est lui qui départage les votes des Loups en cas d’égalité.\r\n<br><br>\r\nTous les 2 tours, il peut tuer un joueur supplémentaire (uniquement Villageois et Indépendants). Contrairement au Loup Blanc, il fait entièrement partie du camp des Loups-Garous, et non pas bande à part.\r\n<br><br>\r\nS’il se fait tuer lors d’un vote, sa meute est tellement désemparée qu’elle ne tue personne la nuit suivante.', 1, 1, 'img/roles/3.jpg'),
(4, 1, 'Villageois', 'Il s\'agit du personnage de base.\r\n<br><br>\r\nSans pouvoir, il ne peut que débattre et voter au cours des bûchers.', 0, 0, 'img/roles/4.jpg'),
(5, 1, 'Barbier', 'Il peut choisir à tout moment de \"raser\" un joueur.\r\n<br><br>\r\nS’il s’agit d’un Loup-Garou, celui-ci meurt ;\r\nDans le cas contraire, c’est le barbier qui décède.\r\n<br><br>\r\nIl ne peut utiliser son pouvoir qu’une seule fois.', 1, 1, 'img/roles/5.jpg'),
(6, 1, 'Chasseur', 'Dès qu\'il meurt, et ce quelle que soit la méthode,\r\nil peut désigner un joueur qui mourra également sur-le-champ.', 1, 2, 'img/roles/6.jpg'),
(7, 1, 'Corbeau', 'Il peut désigner un joueur chaque nuit, qui recevra un vote le lendemain.', 1, 1, 'img/roles/7.jpg'),
(8, 1, 'Cupidon', 'Durant la toute première nuit de la partie, il va désigner 2 personnes qui seront secrètement amoureuses jusqu\'à la fin du jeu. Si l\'une des deux personnes vient à mourir, l\'autre meurt immédiatement de désespoir. Les Amoureux ne peuvent en aucune façon voter l\'un contre l\'autre.\r\n<br><br>\r\nSi les 2 amoureux font partie de la même faction (2 Villageois, 2 Loups-Garous), ils conservent leur objectif. Sinon (ex : 1 Villageois + 1 Loup-Garou), ils ont pour but d’être les 2 derniers survivants.', 1, 2, 'img/roles/8.jpg'),
(9, 1, 'Fouine', 'Elle peut savoir chaque nuit si la personne qu’elle désigne s\'est réveillée ou non. Si oui, le MJ lui dit si le joueur assis à droite de cette dernière s’est réveillée ou non.\r\n<br><br>\r\nPar exemple, le Chasseur ne se réveille jamais, car il n\'a rien à faire de nuit.\r\n<br>\r\nLa Sorcière ne se réveillera plus quand elle n\'aura plus de potion, Cupidon ne se réveille que la 1ère nuit, etc...\r\n<br>\r\nEn revanche, des rôles comme la Voyante, les Loups-Garous ou encore le Joueur de Flûte se réveillent chaque nuit.', 1, 1, 'img/roles/9.jpg'),
(10, 1, 'Honnête Homme', 'Au début d’un tour de son choix, il peut révéler sa véritable nature :\r\n<br><br>celle d’être un simple Villageois.', 1, 2, 'img/roles/10.jpg');