-- Migration: quotes
-- Created at: 2025-03-19 15:12:35

-- Write your SQL here

CREATE TABLE quotes (
  id INT PRIMARY KEY AUTO_INCREMENT,
  content TEXT NOT NULL,
  author TEXT NOT NULL
);

INSERT INTO quotes(content, author) VALUES
  ('Your instruments aspire me to be a great musician', 'Huy-DNA'),
  ('You are the best teachers that I have ever met!', 'Jill Jay'),
  ('I was very surprised by the thoroughness of your courses', 'Rose Mallet');
