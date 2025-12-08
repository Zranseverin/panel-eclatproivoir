CREATE DATABASE IF NOT EXISTS `apieclat`;
USE `apieclat`;

CREATE TABLE IF NOT EXISTS `pricing_plans` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `subtitle` VARCHAR(255) NOT NULL,
  `price` DECIMAL(10, 2) NOT NULL,
  `currency` VARCHAR(10) NOT NULL DEFAULT 'FCFA',
  `period` VARCHAR(50) NOT NULL DEFAULT 'Mois',
  `image_url` VARCHAR(255) NOT NULL,
  `features` TEXT NOT NULL,
  `cta_text` VARCHAR(100) NOT NULL DEFAULT 'Choisir',
  `is_active` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample data for the pricing plans
INSERT INTO `pricing_plans` (`title`, `subtitle`, `price`, `currency`, `period`, `image_url`, `features`, `cta_text`, `is_active`) VALUES
('Bureau Standard', 'Nettoyage de Bureaux', 50000.00, 'FCFA', 'Mois', 'img/index.jpg', 'Nettoyage quotidien,Salle de bains et cuisines,Vidage des poubelles,Remplacement du papier', 'Choisir', 1),
('Espaces Verts', 'Entretien des Espaces Verts', 80000.00, 'FCFA', 'Mois', 'img/ok.jpg', 'Tonte et taille,Arrosage automatique,Désherbage,Aménagement paysager', 'Choisir', 1),
('Nettoyage Intensif', 'Nettoyage Intensif', 77777.00, 'FCFA', 'Mois', 'img/techniques-nettoyage.jpg', 'Nettoyage en profondeur,Désinfection complète,Nettoyage de vitres,Nettoyage de tapis', 'Choisir', 1),
('Sur Mesure', 'Service Sur Mesure', 0.00, 'FCFA', 'Mois', 'img/AdobeStock_529073935-scaled.jpeg', 'Formule personnalisée,Selon vos besoins,Planning flexible,Équipe dédiée', 'Contacter', 1);