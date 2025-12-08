CREATE DATABASE IF NOT EXISTS `apieclat`;
USE `apieclat`;

CREATE TABLE IF NOT EXISTS `team_members` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `role` VARCHAR(255) NOT NULL,
  `bio` TEXT NOT NULL,
  `image_url` VARCHAR(255) NOT NULL,
  `twitter_url` VARCHAR(255) DEFAULT NULL,
  `facebook_url` VARCHAR(255) DEFAULT NULL,
  `linkedin_url` VARCHAR(255) DEFAULT NULL,
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample data for the team members
INSERT INTO `team_members` (`name`, `role`, `bio`, `image_url`, `twitter_url`, `facebook_url`, `linkedin_url`, `is_active`) VALUES
('Koffi Jean', 'Chef d\'Équipe Nettoyage', 'Expert en techniques de nettoyage professionnel avec 10 ans d\'expérience.', 'img/AdobeStock_529073935-scaled.jpeg', '#!', '#!', '#!', 1),
('Adjoua Marie', 'Spécialiste Espaces Verts', 'Horticultrice passionnée avec expertise en aménagement paysager.', 'img/team2.png', '#!', '#!', '#!', 1),
('Konan Philippe', 'Technicien Spécialisé', 'Expert en nettoyage industriel et désinfection de haute qualité.', 'img/team3.png', '#!', '#!', '#!', 1);