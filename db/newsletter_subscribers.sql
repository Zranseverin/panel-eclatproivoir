-- Table for newsletter subscribers
CREATE TABLE IF NOT EXISTS newsletter_subscribers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_active TINYINT(1) DEFAULT 1
);

-- Index for faster email lookups
CREATE INDEX idx_email ON newsletter_subscribers(email);
CREATE INDEX idx_is_active ON newsletter_subscribers(is_active);
CREATE INDEX idx_subscribed_at ON newsletter_subscribers(subscribed_at);