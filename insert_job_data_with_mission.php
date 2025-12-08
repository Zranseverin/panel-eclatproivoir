<?php
require_once 'config/db_config.php';
require_once 'classes/JobPosting.php';

// Create job posting object
$job = new JobPosting();

// Sample data with mission
$jobs = [
    [
        'title' => 'Agent de Nettoyage Écologique',
        'employment_type' => 'CDI - Temps plein',
        'description' => 'Effectuer le nettoyage avec des produits écologiques selon nos normes vertes.',
        'mission' => 'Rejoignez notre équipe engagée dans la protection de l\'environnement et contribuez à créer un espace de travail sain et durable.',
        'responsibilities' => "Nettoyage avec produits biodégradables\nGestion écoresponsable des déchets\nDésinfection naturelle des sanitaires\nRespect des procédures écologiques",
        'profile_requirements' => "1 an d'expérience\nSensibilité écologique\nAutonome",
        'benefits' => "CDI vert\nPrime écologique\nVélo électrique",
        'image_url' => 'img/job1.jpg',
        'badge_text' => 'Éco-certifié',
        'badge_class' => 'bg-success',
        'is_active' => 1
    ],
    [
        'title' => 'Jardinier Paysagiste Bio',
        'employment_type' => 'CDI - Temps plein',
        'description' => 'Entretenir les espaces verts avec des méthodes de permaculture et biologiques.',
        'mission' => 'Participez à la création et au maintien d\'espaces verts respectueux de l\'environnement.',
        'responsibilities' => "Permaculture et jardinage bio\nTaille raisonnée des végétaux\nGestion des eaux de pluie\nCréation de jardins écologiques",
        'profile_requirements' => "Formation bio\n2 ans d'expérience\nPassion nature",
        'benefits' => "CDI durable\nOutils bio fournis\nFormations écologie",
        'image_url' => 'img/job2.jpg',
        'badge_text' => 'Agriculture Bio',
        'badge_class' => 'bg-success',
        'is_active' => 1
    ],
    [
        'title' => 'Technicien Énergies Vertes',
        'employment_type' => 'CDI - Temps plein',
        'description' => 'Interventions techniques avec utilisation d\'énergies renouvelables et économies d\'eau.',
        'mission' => 'Contribuez à la transition énergétique de nos clients grâce à des solutions techniques durables.',
        'responsibilities' => "Nettoyage industriel écologique\nGestion des déchets spéciaux\nUtilisation machines économes\nBilans énergétiques",
        'profile_requirements' => "BTS Énergies\n3 ans expérience\nHabilité verte",
        'benefits' => "CDI vert\nVéhicule électrique\nPrimes écologie",
        'image_url' => 'img/job3.jpg',
        'badge_text' => 'Énergie verte',
        'badge_class' => 'bg-success',
        'is_active' => 1
    ],
    [
        'title' => 'Coordinateur Écologie',
        'employment_type' => 'CDI - Temps plein',
        'description' => 'Superviser des équipes engagées dans des pratiques écologiques durables.',
        'mission' => 'Encadrez et inspirez des équipes passionnées par la protection de l\'environnement.',
        'responsibilities' => "Management d'équipes vertes\nContrôle qualité écologique\nSensibilisation environnement\nInnovation durable",
        'profile_requirements' => "5 ans management\nFormation RSE\nLeadership vert",
        'benefits' => "CDI vert\nVoiture hybride\nParticipation RSE",
        'image_url' => 'img/job4.jpg',
        'badge_text' => 'Management vert',
        'badge_class' => 'bg-success',
        'is_active' => 1
    ]
];

// Clear existing data
try {
    $pdo = new PDO("mysql:host=localhost;dbname=apieclat;charset=utf8mb4", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("DELETE FROM job_postings");
    echo "Existing data cleared.\n";
} catch (PDOException $e) {
    echo "Error clearing data: " . $e->getMessage() . "\n";
}

// Insert new data
foreach ($jobs as $jobData) {
    $job->title = $jobData['title'];
    $job->employment_type = $jobData['employment_type'];
    $job->description = $jobData['description'];
    $job->mission = $jobData['mission'];
    $job->responsibilities = $jobData['responsibilities'];
    $job->profile_requirements = $jobData['profile_requirements'];
    $job->benefits = $jobData['benefits'];
    $job->image_url = $jobData['image_url'];
    $job->badge_text = $jobData['badge_text'];
    $job->badge_class = $jobData['badge_class'];
    $job->is_active = $jobData['is_active'];
    
    if ($job->create()) {
        echo "Successfully inserted: " . $jobData['title'] . "\n";
    } else {
        echo "Failed to insert: " . $jobData['title'] . "\n";
    }
}
?>