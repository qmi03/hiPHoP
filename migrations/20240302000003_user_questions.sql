-- Migration: user_questions
-- Created at: 2024-03-02 00:00:03
-- Description: Creates table for tracking user questions

DROP TABLE IF EXISTS user_questions;

CREATE TABLE IF NOT EXISTS user_questions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    answer TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
