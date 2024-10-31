-- Adminer 4.8.1 MySQL 9.0.1 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS `tag`;
CREATE TABLE `tag` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `tag` (`id`, `name`) VALUES
(1,	'Urgent'),
(2,	'Important'),
(3,	'En attente'),
(4,	'Développement'),
(5,	'Révision'),
(6,	'Recherche'),
(7,	'Formation'),
(8,	'Documentation'),
(9,	'Maintenance'),
(10,	'Suivi');

DROP TABLE IF EXISTS `task`;
CREATE TABLE `task` (
  `id` int NOT NULL AUTO_INCREMENT,
  `author_id` int DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_done` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_527EDB25F675F31B` (`author_id`),
  CONSTRAINT `FK_527EDB25F675F31B` FOREIGN KEY (`author_id`) REFERENCES `user` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `task` (`id`, `author_id`, `created_at`, `title`, `content`, `is_done`) VALUES
(1,	1,	'2023-09-30 15:59:54',	'Créer une maquette de l\'application',	'Créer une maquette pour l\'application de gestion de tâches.',	0),
(2,	1,	'2022-06-25 02:03:51',	'Rédiger la documentation utilisateur',	'Documenter les fonctionnalités de l\'application.',	0),
(3,	2,	'2021-10-02 01:58:39',	'Corriger les bugs signalés',	'Réparer les bugs identifiés par les utilisateurs.',	1),
(4,	3,	'2021-05-13 03:36:57',	'Mettre à jour le système de gestion',	'Mettre à jour la base de données avec les nouvelles fonctionnalités.',	1),
(5,	4,	'2020-09-07 12:11:58',	'Planifier la prochaine réunion',	'Organiser une réunion pour discuter des progrès.',	0),
(6,	5,	'2021-03-09 05:33:40',	'Suivre l\'évolution des tâches',	'Vérifier l\'état d\'avancement des tâches.',	0),
(7,	6,	'2024-07-21 11:41:51',	'Effectuer une formation sur l\'outil',	'Former l\'équipe sur le nouvel outil de gestion.',	0),
(8,	7,	'2023-03-05 23:48:56',	'Préparer une présentation',	'Préparer une présentation pour le comité de direction.',	1),
(9,	8,	'2024-06-30 22:34:46',	'Faire une recherche sur les nouvelles technologies',	'Explorer les nouvelles technologies pour les intégrer dans l\'application.',	0),
(10,	1,	'2024-02-07 09:12:14',	'Mettre à jour les dépendances du projet',	'S\'assurer que toutes les dépendances du projet sont à jour.',	0),
(11,	2,	'2024-07-01 05:11:55',	'Réviser le code de l\'application',	'Revoir le code pour s\'assurer qu\'il respecte les normes.',	1);

DROP TABLE IF EXISTS `task_tag`;
CREATE TABLE `task_tag` (
  `task_id` int NOT NULL,
  `tag_id` int NOT NULL,
  PRIMARY KEY (`task_id`,`tag_id`),
  KEY `IDX_6C0B4F048DB60186` (`task_id`),
  KEY `IDX_6C0B4F04BAD26311` (`tag_id`),
  CONSTRAINT `FK_6C0B4F048DB60186` FOREIGN KEY (`task_id`) REFERENCES `task` (`id`) ON DELETE CASCADE,
  CONSTRAINT `FK_6C0B4F04BAD26311` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `task_tag` (`task_id`, `tag_id`) VALUES
(1,	1),
(1,	4),
(2,	2),
(2,	9),
(3,	1),
(3,	6),
(4,	2),
(4,	10),
(5,	3),
(6,	3),
(6,	5),
(7,	7),
(8,	2),
(9,	8),
(10,	10),
(11,	5);

DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(25) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8D93D649F85E0677` (`username`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `user` (`id`, `email`, `roles`, `password`, `username`) VALUES
(1,	'anonyme@todolist.com',	'[\"ROLE_USER\"]',	'',	'Anonyme'),
(2,	'admin@todolist.com',	'[\"ROLE_ADMIN\"]',	'$2y$13$dNImEW8px23rQTOW5OeQG.3LG0ZlMnn7PwuNmOSa2jXwuvU62BWAS',	'AdminUser'),
(3,	'john.doe@todolist.com',	'[\"ROLE_USER\"]',	'$2y$13$UG3Cx5Sujo4Sns.bfNLMYuAfvrZ8WDxTb3Dew89TEefhG/8iexiGy',	'John Doe'),
(4,	'jane.smith@todolist.com',	'[\"ROLE_USER\"]',	'$2y$13$CuRDhOM/7xAzBoQKJtFORuPUTB/0NUw.6pKFp5EL754PjmRMKk5RC',	'Jane Smith'),
(5,	'alice.johnson@todolist.com',	'[\"ROLE_USER\"]',	'$2y$13$JEPBVEmYORn4bUBCWVxM1u6kBNXHLSF80gLZPDlb85dzJrpsQQdw6',	'Alice Johnson'),
(6,	'bob.brown@todolist.com',	'[\"ROLE_USER\"]',	'$2y$13$u/HksZJUQ8qrBdsTm9QmuuqX/ThSfkiibsCVWzu0O1v8T400gZQLC',	'Bob Brown'),
(7,	'charlie.davis@todolist.com',	'[\"ROLE_USER\"]',	'$2y$13$WXPjU3QvqMz3ap1nTiJZh.IsSmLR7kFtk/orCchfBH/b1XpWN2G7y',	'Charlie Davis'),
(8,	'diana.evans@todolist.com',	'[\"ROLE_USER\"]',	'$2y$13$sJtyItKsRKRgojFTNYXGBOZZqjW6MnNQ3sJkS9XPXQMalAJaJ9qV6',	'Diana Evans'),
(9,	'eva.green@todolist.com',	'[\"ROLE_USER\"]',	'$2y$13$FioZ8Y5/TFdYASJbFqceyenxY.vEB0z82PbwXfKAGgjMlYu/LJh76',	'Eva Green'),
(10,	'frank.harris@todolist.com',	'[\"ROLE_USER\"]',	'$2y$13$ORYQ72Uw/6qdAcrogQqOKuRe95tgkPy/iZrG7VNMWVspOjBrtCt6W',	'Frank Harris');

-- 2024-10-31 13:03:53
