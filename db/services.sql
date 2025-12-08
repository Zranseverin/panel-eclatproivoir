CREATE DATABASE IF NOT EXISTS `apiEclat`;
USE `apiEclat`;

CREATE TABLE IF NOT EXISTS `services` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `icon_class` VARCHAR(100) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample data for the services
INSERT INTO `services` (`icon_class`, `title`, `description`) VALUES
('fa-building', 'Nettoyage de Bureaux', 'Service de nettoyage quotidien ou hebdomadaire pour maintenir vos bureaux impeccables et favoriser la productivité.'),
('fa-tree', 'Entretien des Espaces Verts', 'Tonte, taille, désherbage et aménagement paysager pour des espaces verts entretenus et attrayants.'),
('fa-broom', 'Nettoyage Spécialisé', 'Services de nettoyage après travaux, nettoyage industriel et autres interventions spécialisées.'),
('fa-window-clean', 'Nettoyage de Vitres', 'Nettoyage professionnel de vitres intérieures et extérieures pour une propreté cristalline.'),
('fa-couch', 'Nettoyage de Tapis', 'Nettoyage en profondeur des tapis et moquettes pour éliminer poussières, taches et allergènes.'),
('fa-pump-soap', 'Désinfection', 'Services de désinfection complète pour assurer un environnement sain et sécuritaire.');