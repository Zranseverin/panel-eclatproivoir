-- Table for testimonials
CREATE TABLE IF NOT EXISTS testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_name VARCHAR(100) NOT NULL,
    client_position VARCHAR(100),
    company VARCHAR(100),
    testimonial_text TEXT NOT NULL,
    client_image_url VARCHAR(255),
    rating TINYINT DEFAULT 5,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert sample data
INSERT INTO testimonials (client_name, client_position, company, testimonial_text, client_image_url, rating) VALUES
('Sophie Koffi', 'Directrice RH', 'ABC Corporation', 'Depuis que EclatPro Ivoire s\'occupe de nos bureaux, nos employés sont plus productifs. Un service irréprochable et ponctuel!', 'img/testimonial-1.jpg', 5),
('Marc Assi', 'Propriétaire', 'Villa Les Oliviers', 'L\'équipe a transformé notre espace vert en un véritable paradis. Leur expertise en jardinage est remarquable!', 'img/testimonial-2.jpg', 5),
('Awa Touré', 'Gérante', 'Hôtel Palmier', 'Après leur intervention de nettoyage intensif, notre bâtiment semblait neuf! Un professionnalisme exemplaire.', 'img/testimonial-3.jpg', 5);