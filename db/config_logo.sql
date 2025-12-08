-- Table for logo configuration
CREATE TABLE IF NOT EXISTS config_logo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    logo_path VARCHAR(255) NOT NULL,
    alt_text VARCHAR(255) DEFAULT 'Logo',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert default logo configuration
INSERT IGNORE INTO config_logo (id, logo_path, alt_text) VALUES (1, 'img/logo.jpg', 'EclatPro Logo');