-- Table for job postings
CREATE TABLE IF NOT EXISTS job_postings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    employment_type VARCHAR(50),
    description TEXT,
    mission TEXT,
    responsibilities TEXT,
    profile_requirements TEXT,
    benefits TEXT,
    image_url VARCHAR(255),
    badge_text VARCHAR(50),
    badge_class VARCHAR(50) DEFAULT 'bg-success',
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample data
INSERT INTO job_postings (title, employment_type, description, mission, responsibilities, profile_requirements, benefits, image_url, badge_text, badge_class) VALUES
('Agent de Nettoyage Écologique', 'CDI - Temps plein', 'Effectuer le nettoyage avec des produits écologiques selon nos normes vertes.', 'Rejoignez notre équipe engagée dans la protection de l''environnement et contribuez à créer un espace de travail sain et durable.', 'Nettoyage avec produits biodégradables\nGestion écoresponsable des déchets\nDésinfection naturelle des sanitaires\nRespect des procédures écologiques', '1 an d\'expérience\nSensibilité écologique\nAutonome', 'CDI vert\nPrime écologique\nVélo électrique', 'img/job1.jpg', 'Éco-certifié', 'bg-success'),
('Jardinier Paysagiste Bio', 'CDI - Temps plein', 'Entretenir les espaces verts avec des méthodes de permaculture et biologiques.', 'Participez à la création et au maintien d\'espaces verts respectueux de l\'environnement.', 'Permaculture et jardinage bio\nTaille raisonnée des végétaux\nGestion des eaux de pluie\nCréation de jardins écologiques', 'Formation bio\n2 ans d\'expérience\nPassion nature', 'CDI durable\nOutils bio fournis\nFormations écologie', 'img/job2.jpg', 'Agriculture Bio', 'bg-success'),
('Technicien Énergies Vertes', 'CDI - Temps plein', 'Interventions techniques avec utilisation d\'énergies renouvelables et économies d\'eau.', 'Contribuez à la transition énergétique de nos clients grâce à des solutions techniques durables.', 'Nettoyage industriel écologique\nGestion des déchets spéciaux\nUtilisation machines économes\nBilans énergétiques', 'BTS Énergies\n3 ans expérience\nHabilité verte', 'CDI vert\nVéhicule électrique\nPrimes écologie', 'img/job3.jpg', 'Énergie verte', 'bg-success'),
('Coordinateur Écologie', 'CDI - Temps plein', 'Superviser des équipes engagées dans des pratiques écologiques durables.', 'Encadrez et inspirez des équipes passionnées par la protection de l\'environnement.', 'Management d\'équipes vertes
Contrôle qualité écologique
Sensibilisation environnement
Innovation durable', '5 ans management
Formation RSE
Leadership vert', 'CDI vert
Voiture hybride
Participation RSE', 'img/job4.jpg', 'Management vert', 'bg-success');