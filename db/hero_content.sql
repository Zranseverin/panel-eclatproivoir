-- Table for hero section content
CREATE TABLE IF NOT EXISTS hero_content (
    id INT AUTO_INCREMENT PRIMARY KEY,
    headline VARCHAR(255) NOT NULL,
    subheading VARCHAR(255),
    primary_button_text VARCHAR(50),
    primary_button_link VARCHAR(255),
    secondary_button_text VARCHAR(50),
    secondary_button_link VARCHAR(255),
    background_image_url VARCHAR(255),
    background_color VARCHAR(20) DEFAULT '#009900',
    text_color VARCHAR(20) DEFAULT '#ffffff',
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample data
INSERT INTO hero_content (headline, subheading, primary_button_text, primary_button_link, secondary_button_text, secondary_button_link, background_image_url) VALUES
('Votre Partenaire de Confiance pour un Environnement de Travail Impeccable', 'Bienvenu à EclatPro Ivoire', 'Nos Services', '#services', 'Recrutement', 'recruitment.php', 'img/hero-bg.jpg');