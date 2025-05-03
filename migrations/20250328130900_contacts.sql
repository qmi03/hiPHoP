-- Migration: contacts
-- Created at: 2025-03-28 13:09:00

-- Write your SQL here

CREATE TABLE contacts (
  address TEXT NOT NULL,
  phone TEXT NOT NULL,
  email TEXT NOT NULL,
  facebook TEXT NOT NULL,
  github TEXT NOT NULL,
  latitude TEXT NOT NULL,
  longitude TEXT NOT NULL
);

INSERT INTO contacts(address, phone, email, facebook, github, latitude, longitude) VALUES (
  'BKU, Di An, Thu Duc, TP.HCM, Vietnam',
  '123-456-7890',
  'info@hiPHoP.com',
  'https://www.facebook.com/huydna',
  'https://github.com/Huy-DNA',
  '10.8806',
  '106.8054'
);
