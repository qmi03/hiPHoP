-- Migration: intruments
-- Created at: 2025-03-28 07:10:08

-- Write your SQL here

CREATE TABLE instrument_types (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL UNIQUE,
    category ENUM('keyboard', 'string', 'wind', 'percussion', 'electronic', 'traditional', 'accessory') NOT NULL
);

CREATE TABLE instruments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    type_id INT NOT NULL,
    FOREIGN KEY (type_id) REFERENCES instrument_types(id),
    brand VARCHAR(255) NOT NULL,
    description TEXT NULL,
    price DECIMAL(10, 2) NOT NULL,
    stock_quantity INT NOT NULL,
    img_id INT NULL,
    FOREIGN KEY (img_id) REFERENCES photos(id),
    serial_number VARCHAR(100) NULL,
    is_buyable BOOLEAN NOT NULL DEFAULT TRUE,
    is_rentable BOOLEAN NOT NULL DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
