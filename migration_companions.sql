-- Migration Script: Phase 1 - Refactor Companions

-- 1. Create the new companions table
CREATE TABLE IF NOT EXISTS companions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    guest_id INT NOT NULL,
    first_name VARCHAR(100) NOT NULL,
    age INT NULL,
    children_menu BOOLEAN NOT NULL DEFAULT 0,
    FOREIGN KEY (guest_id) REFERENCES guests(id) ON DELETE CASCADE
);

-- 2. Drop the redundant columns from guests table safely
ALTER TABLE guests 
DROP COLUMN plus_one,
DROP COLUMN plus_one_age;
