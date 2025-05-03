-- Migration: faqs
-- Created at: 2024-03-02 00:00:02

CREATE TABLE IF NOT EXISTS faqs (
  id VARCHAR(36) PRIMARY KEY,
  question TEXT NOT NULL,
  answer TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO faqs (id, question, answer) VALUES 
(UUID(), 'What services do you offer?', 'We offer a wide range of services including web development, mobile app development, digital marketing, and IT consulting. Our team of experts is ready to help you with your specific needs.'),
(UUID(), 'How can I contact your support team?', 'You can reach our support team through multiple channels:
- Email: support@example.com
- Phone: +1 (555) 123-4567
- Live Chat: Available on our website during business hours
- Contact Form: Fill out the form on our Contact page'),
(UUID(), 'What are your business hours?', 'Our business hours are:
Monday - Friday: 9:00 AM - 6:00 PM
Saturday: 10:00 AM - 4:00 PM
Sunday: Closed'),
(UUID(), 'Do you offer free consultations?', 'Yes, we offer free initial consultations to understand your requirements and provide you with the best possible solution. You can schedule a consultation through our website or by calling us directly.'),
(UUID(), 'What payment methods do you accept?', 'We accept various payment methods including:
- Credit/Debit Cards (Visa, MasterCard, American Express)
- Bank Transfers
- PayPal
- Digital Wallets'); 