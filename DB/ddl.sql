DROP TABLE IF EXISTS `skills`;
CREATE TABLE `skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `s_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `r_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `cities`;
CREATE TABLE `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(170) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `c_name_unique` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `birthday` datetime NOT NULL,
  `password` varchar(255) NOT NULL,
  `about` text,
  `hide_profile` tinyint(1) DEFAULT NULL,
  `hide_contacts` tinyint(1) DEFAULT NULL,
  `id_role` int(11) NOT NULL,
  `id_city` int(11) DEFAULT NULL,
  `rating` float DEFAULT NULL,
  `phone` varchar(11) DEFAULT NULL,
  `skype` varchar(255) DEFAULT NULL,
  `telegram` varchar(64) DEFAULT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `u_email_unique` (`email`),
  KEY `u_roles` (`id_role`),
  KEY `u_cities` (`id_city`),
  CONSTRAINT `u_roles` FOREIGN KEY (`id_role`) REFERENCES `roles` (`id`),
  CONSTRAINT `u_cities` FOREIGN KEY (`id_city`) REFERENCES `cities` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `notifications`;
CREATE TABLE `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_user` int(11) NOT NULL,
  `new_message` tinyint(1) NOT NULL,
  `actions_task` tinyint(1) NOT NULL,
  `new_reviews` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `notifications_id_user_unique` (`id_user`),
  CONSTRAINT `notifications_users` FOREIGN KEY (`id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `users_skills`;
CREATE TABLE `users_skills` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_specialist` int(11) NOT NULL,
  `id_skill` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_skills_specialist_skill_unique` (`id_specialist`,`id_skill`),
  KEY `users_skills_skills` (`id_skill`),
  CONSTRAINT `users_skills_skills` FOREIGN KEY (`id_skill`) REFERENCES `skills` (`id`),
  CONSTRAINT `users_skills_users` FOREIGN KEY (`id_specialist`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `files`;
CREATE TABLE `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `path` varchar(255) NOT NULL,
  `id_user` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_types` varchar(100) NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `files_users` (`id_user`),
  CONSTRAINT `files_users` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `tasks`;
CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_specialist` int(11) DEFAULT NULL,
  `id_customer` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` int(11) DEFAULT NULL,
  `deadline` int(11) DEFAULT NULL COMMENT 'UTC Fortmat',
  `remote` tinyint(1) NOT NULL,
  `id_skill` int(11) NOT NULL,
  `id_city` int(11) DEFAULT NULL,
  `longitude` float DEFAULT NULL,
  `latitude` float DEFAULT NULL,
  `address` text,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tasks_customer` (`id_customer`),
  KEY `tasks_skill` (`id_skill`),
  KEY `tasks_city` (`id_city`),
  KEY `tasks_specialist` (`id_specialist`),
  CONSTRAINT `tasks_specialist` FOREIGN KEY (`id_specialist`) REFERENCES `users` (`id`),
  CONSTRAINT `tasks_customer` FOREIGN KEY (`id_customer`) REFERENCES `users` (`id`),
  CONSTRAINT `tasks_skill` FOREIGN KEY (`id_skill`) REFERENCES `skills` (`id`),
  CONSTRAINT `tasks_city` FOREIGN KEY (`id_city`) REFERENCES `cities` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `tasks_files`;
CREATE TABLE `tasks_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_task` int(11) NOT NULL,
  `id_file` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tasks_files_task_file` (`id_task`,`id_file`),
  KEY `tasks_files_file` (`id_file`),
  CONSTRAINT `tasks_files_tasks` FOREIGN KEY (`id_task`) REFERENCES `tasks` (`id`),
  CONSTRAINT `tasks_files_file` FOREIGN KEY (`id_file`) REFERENCES `files` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_task` int(11) NOT NULL,
  `review` text NOT NULL COMMENT 'Описание отзыва на работу',
  `grade` tinyint(4) NOT NULL COMMENT 'Оценка за работу',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reviews_task_unique` (`id_task`),
  CONSTRAINT `reviews_tasks` FOREIGN KEY (`id_task`) REFERENCES `tasks` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `responds`;
CREATE TABLE `responds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_specialist` int(11) NOT NULL,
  `description` text COMMENT 'Описание отклика',
  `rate` int(11) DEFAULT NULL COMMENT 'Исполнитель предлагает свою цену за работу',
  `id_task` int(11) NOT NULL,
  `rejected` tinyint(1) NOT NULL COMMENT 'Заказчик отклонил данный отклик',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `responds_specialist_unique` (`id_specialist`,`id_task`),
  KEY `responds_task` (`id_task`),
  CONSTRAINT `responds_specialist` FOREIGN KEY (`id_specialist`) REFERENCES `users` (`id`),
  CONSTRAINT `responds_task` FOREIGN KEY (`id_task`) REFERENCES `tasks` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `chat`;
CREATE TABLE `chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_task` int(11) NOT NULL,
  `id_customer` int(11) NOT NULL,
  `id_specialist` int(11) NOT NULL,
  `message` text NOT NULL,
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `chat_customer` (`id_customer`),
  KEY `chat_specialist` (`id_specialist`),
  KEY `chat_task` (`id_task`),
  CONSTRAINT `chat_customer` FOREIGN KEY (`id_customer`) REFERENCES `users` (`id`),
  CONSTRAINT `chat_specialist` FOREIGN KEY (`id_specialist`) REFERENCES `users` (`id`),
  CONSTRAINT `chat_task` FOREIGN KEY (`id_task`) REFERENCES `tasks` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
