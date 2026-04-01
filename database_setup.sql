CREATE DATABASE IF NOT EXISTS wedding_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE wedding_db;

-- Drop existing tables for a clean slate
DROP TABLE IF EXISTS guests;
DROP TABLE IF EXISTS users;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE guests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(100) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    age INT NULL,
    email VARCHAR(255) NULL,
    phone VARCHAR(20) NULL,
    is_attending BOOLEAN NOT NULL DEFAULT 0,
    dietary_restrictions TEXT NULL,
    message TEXT NULL,
    is_approved BOOLEAN NOT NULL DEFAULT 0, -- 0=Pending, 1=Approved, 2=Rejected
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE companions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    guest_id INT NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    age INT NULL,
    children_menu BOOLEAN NOT NULL DEFAULT 0,
    FOREIGN KEY (guest_id) REFERENCES guests(id) ON DELETE CASCADE
);
