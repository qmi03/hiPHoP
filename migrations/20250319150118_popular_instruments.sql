-- Migration: popular_instruments
-- Created at: 2025-03-19 15:01:18

-- Write your SQL here

CREATE TABLE popular_instruments (
  paragraphs JSON NOT NULL,
  image_urls JSON NOT NULL
);

INSERT INTO popular_instruments(paragraphs, image_urls) VALUES (
  '["Insert your paragraphs here!"]',
  '[]'
);
