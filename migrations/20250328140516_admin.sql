-- Migration: admin
-- Created at: 2025-03-28 14:05:16

-- Write your SQL here

INSERT INTO users(first_name, last_name, address, email, dob, username, password, is_admin, avatar_url) VALUES (
  "root",
  "root",
  "602 Vo Nguyen Giap, Thu Duc",
  "root@admin.com",
  "2003-01-01",
  "root",
  "$2y$10$SYpevsTClIZ2ApknlIO5u.dU1ppsQOSt3Vld.N/IhOVEalkaCzs0S",
  true,
  "/public/assets/default-avatar.jpg"
);
