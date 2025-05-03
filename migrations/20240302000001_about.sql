-- Migration: about
-- Created at: 2024-03-02 00:00:01

CREATE TABLE IF NOT EXISTS about (
  id VARCHAR(36) PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  content TEXT NOT NULL,
  image_url VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO about (id, title, content, image_url) VALUES (
  UUID(),
  'Welcome to Our Website',
  'We are a passionate team dedicated to providing the best services to our customers. Our mission is to make your experience with us exceptional and memorable.

Our Story:
Founded in 2024, we have grown from a small startup to a trusted name in the industry. We believe in innovation, quality, and customer satisfaction.

Our Values:
- Quality: We never compromise on quality
- Innovation: We constantly strive to improve
- Customer Focus: Your satisfaction is our priority
- Integrity: We conduct business with honesty and transparency

Join us on this journey as we continue to grow and serve you better!',
  '/public/images/about-us.jpg'
); 