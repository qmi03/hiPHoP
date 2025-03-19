-- Migration: introduction
-- Created at: 2025-03-19 14:44:16

-- Write your SQL here

CREATE TABLE introductions (
  title TEXT NOT NULL,
  paragraphs JSON NOT NULL
);

INSERT INTO introductions(title, paragraphs) VALUES (
  'Insert your introduction title',
  '["Insert your introduction content here!"]'
);
