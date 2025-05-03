-- Migration: introduction
-- Created at: 2025-03-19 14:44:16

-- Write your SQL here

CREATE TABLE introductions (
  title TEXT NOT NULL,
  paragraphs JSON NOT NULL
);

INSERT INTO introductions(title, paragraphs) VALUES (
  'Welcome to hiPHop – Your Ultimate Music Destination',
  '["Discover the joy of music with premium instruments and expert-led courses tailored for all skill levels. Whether you are a beginner picking up your first guitar or a seasoned musician refining your craft, we provide everything you need to create, learn, and master your sound.", "- Shop Top-Quality Instruments – Guitars, keyboards, drums, and more from the best brands.", "- Learn from the Best – Step-by-step courses from industry professionals.", "- Everything in One Place – Accessories, sheet music, and expert advice at your fingertips.", "Start your musical journey today – Shop Now or Explore Courses and unleash your potential!"]'
);
