-- Migration: newsletter
-- Created at: 2025-03-25 16:31:07

-- Write your SQL here

CREATE TABLE newsletters (
  id INT PRIMARY KEY AUTO_INCREMENT,
  title TEXT NOT NULL,
  summary TEXT NOT NULL,
  target_url TEXT,
  target_name TEXT,
  bg_url TEXT NOT NULL
);
