-- Migration: photos
-- Created at: 2025-03-12 15:35:08

-- Write your SQL here

CREATE TABLE photos (
  id INT PRIMARY KEY AUTO_INCREMENT,
  name TEXT,
  url TEXT
);
