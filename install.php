<?php
// Database configuration
$host = 'localhost';
$db_name = 'apiEclat';
$username = 'root';
$password = '';

try {
    // Connect to MySQL
    $pdo = new PDO("mysql:host=$host", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create database
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Database '$db_name' created successfully<br>";

    // Select database
    $pdo->exec("USE `$db_name`");

    // Create services table
    $sql = "CREATE TABLE IF NOT EXISTS `services` (
        `id` INT(11) NOT NULL AUTO_INCREMENT,
        `icon_class` VARCHAR(100) NOT NULL,
        `title` VARCHAR(255) NOT NULL,
        `description` TEXT NOT NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

    $pdo->exec($sql);
    echo "Table 'services' created successfully<br>";

    // Check if services table is empty, then insert sample data
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM services");
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        // Insert sample data
        $insert_sql = "INSERT INTO `services` (`icon_class`, `title`, `description`) VALUES
        ('fa-building', 'Nettoyage de Bureaux', 'Service de nettoyage quotidien ou hebdomadaire pour maintenir vos bureaux impeccables et favoriser la productivité.'),
        ('fa-tree', 'Entretien des Espaces Verts', 'Tonte, taille, désherbage et aménagement paysager pour des espaces verts entretenus et attrayants.'),
        ('fa-broom', 'Nettoyage Spécialisé', 'Services de nettoyage après travaux, nettoyage industriel et autres interventions spécialisées.'),
        ('fa-window-clean', 'Nettoyage de Vitres', 'Nettoyage professionnel de vitres intérieures et extérieures pour une propreté cristalline.'),
        ('fa-couch', 'Nettoyage de Tapis', 'Nettoyage en profondeur des tapis et moquettes pour éliminer poussières, taches et allergènes.'),
        ('fa-pump-soap', 'Désinfection', 'Services de désinfection complète pour assurer un environnement sain et sécuritaire.')";

        $pdo->exec($insert_sql);
        echo "Sample data inserted successfully<br>";
    } else {
        echo "Data already exists in the services table<br>";
    }

    // Create appointments table
    $appointments_sql = "CREATE TABLE IF NOT EXISTS `appointments` (
      `id` INT(11) NOT NULL AUTO_INCREMENT,
      `service_type` VARCHAR(100) NOT NULL,
      `frequency` VARCHAR(50) NOT NULL,
      `name` VARCHAR(255) NOT NULL,
      `email` VARCHAR(255) NOT NULL,
      `desired_date` DATE NOT NULL,
      `phone` VARCHAR(20) NOT NULL,
      `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
      `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
      PRIMARY KEY (`id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

    $pdo->exec($appointments_sql);
    echo "Table 'appointments' created successfully<br>";

    // Create pricing plans table
    $pricing_sql = "CREATE TABLE IF NOT EXISTS `pricing_plans` (
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
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

    $pdo->exec($pricing_sql);
    echo "Table 'pricing_plans' created successfully<br>";

    // Check if pricing plans table is empty, then insert sample data
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM pricing_plans");
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        // Insert sample data
        $insert_sql = "INSERT INTO `pricing_plans` (`title`, `subtitle`, `price`, `currency`, `period`, `image_url`, `features`, `cta_text`, `is_active`) VALUES
        ('Bureau Standard', 'Nettoyage de Bureaux', 50000.00, 'FCFA', 'Mois', 'img/index.jpg', 'Nettoyage quotidien,Salle de bains et cuisines,Vidage des poubelles,Remplacement du papier', 'Choisir', 1),
        ('Espaces Verts', 'Entretien des Espaces Verts', 80000.00, 'FCFA', 'Mois', 'img/ok.jpg', 'Tonte et taille,Arrosage automatique,Désherbage,Aménagement paysager', 'Choisir', 1),
        ('Nettoyage Intensif', 'Nettoyage Intensif', 77777.00, 'FCFA', 'Mois', 'img/techniques-nettoyage.jpg', 'Nettoyage en profondeur,Désinfection complète,Nettoyage de vitres,Nettoyage de tapis', 'Choisir', 1),
        ('Sur Mesure', 'Service Sur Mesure', 0.00, 'FCFA', 'Mois', 'img/AdobeStock_529073935-scaled.jpeg', 'Formule personnalisée,Selon vos besoins,Planning flexible,Équipe dédiée', 'Contacter', 1)";

        $pdo->exec($insert_sql);
        echo "Sample pricing plans data inserted successfully<br>";
    } else {
        echo "Data already exists in the pricing plans table<br>";
    }

    // Create team members table
    $team_sql = "CREATE TABLE IF NOT EXISTS `team_members` (
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
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";

    $pdo->exec($team_sql);
    echo "Table 'team_members' created successfully<br>";

    // Check if team members table is empty, then insert sample data
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM team_members");
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count == 0) {
        // Insert sample data
        $insert_sql = "INSERT INTO `team_members` (`name`, `role`, `bio`, `image_url`, `twitter_url`, `facebook_url`, `linkedin_url`, `is_active`) VALUES
        ('Koffi Jean', 'Chef d\'Équipe Nettoyage', 'Expert en techniques de nettoyage professionnel avec 10 ans d\'expérience.', 'img/AdobeStock_529073935-scaled.jpeg', '#!', '#!', '#!', 1),
        ('Adjoua Marie', 'Spécialiste Espaces Verts', 'Horticultrice passionnée avec expertise en aménagement paysager.', 'img/team2.png', '#!', '#!', '#!', 1),
        ('Konan Philippe', 'Technicien Spécialisé', 'Expert en nettoyage industriel et désinfection de haute qualité.', 'img/team3.png', '#!', '#!', '#!', 1)";

        $pdo->exec($insert_sql);
        echo "Sample team members data inserted successfully<br>";
    } else {
        echo "Data already exists in the team members table<br>";
    }

    echo "<br>Installation completed successfully!";
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>