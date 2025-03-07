-- Migration: users
-- Created at: 2025-03-07 12:04:48

-- Write your SQL here

CREATE TABLE users (
  id INT PRIMARY KEY,
  first_name TEXT NOT NULL,
  last_name TEXT NOT NULL,
  address TEXT NOT NULL,
  email TEXT UNIQUE,
  dob TIMESTAMP NOT NULL,
  username TEXT NOT NULL UNIQUE,
  password TEXT NOT NULL
)

CREATE INDEX idx_users__username ON users(username);
