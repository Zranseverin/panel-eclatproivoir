-- Table for job applications
CREATE TABLE IF NOT EXISTS job_applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    civilite VARCHAR(20) NOT NULL,
    nom_complet VARCHAR(255) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL,
    adresse TEXT NOT NULL,
    poste VARCHAR(255) NOT NULL,
    cv_path VARCHAR(255),
    lettre_motivation_path VARCHAR(255),
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'reviewed', 'accepted', 'rejected') DEFAULT 'pending'
);

-- Index for faster queries
CREATE INDEX idx_poste ON job_applications(poste);
CREATE INDEX idx_status ON job_applications(status);
CREATE INDEX idx_submitted_at ON job_applications(submitted_at);