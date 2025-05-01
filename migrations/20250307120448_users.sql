-- Migration: users
-- Created at: 2025-03-07 12:04:48

-- Write your SQL here

CREATE TABLE users (
  id INT PRIMARY KEY AUTO_INCREMENT,
  first_name TEXT NOT NULL,
  last_name TEXT NOT NULL,
  address TEXT NOT NULL,
  email VARCHAR(255) UNIQUE,
  dob TIMESTAMP NOT NULL,
  username VARCHAR(255) NOT NULL UNIQUE,
  password TEXT NOT NULL,
  is_admin BOOL NOT NULL,
  avatar_url TEXT NOT NULL
);

CREATE INDEX idx_users__username ON users(username);
