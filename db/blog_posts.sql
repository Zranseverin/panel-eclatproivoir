-- Table for blog posts
CREATE TABLE IF NOT EXISTS blog_posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    subtitle VARCHAR(255),
    content TEXT,
    image_url VARCHAR(255),
    author VARCHAR(100),
    author_image_url VARCHAR(255),
    views INT DEFAULT 0,
    comments INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample data
INSERT INTO blog_posts (title, subtitle, content, image_url, author, author_image_url, views, comments) VALUES
('5 Astuces pour Maintenir un Bureau Propre', 'Conseils de nettoyage', 'Découvrez des conseils simples mais efficaces pour garder votre espace de travail toujours impeccable.', 'img/carpet-cleaning.png', 'Admin', 'img/user.jpg', 12345, 123),
('L\'Importance de l\'Entretien des Espaces Verts', 'Conseils d\'entretien', 'Pourquoi investir dans l\'entretien régulier de vos espaces verts pour le bien-être de tous.', 'img/garden-care.png', 'Admin', 'img/user.jpg', 12345, 123),
('Guide de la Désinfection Professionnelle', 'Protocoles de désinfection', 'Tout ce que vous devez savoir sur les protocoles de désinfection pour un environnement sain.', 'img/disinfection.png', 'Admin', 'img/user.jpg', 12345, 123);