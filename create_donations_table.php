<?php
require_once __DIR__ . '/app/Core/Database.php';
require_once __DIR__ . '/config/database.php';

use App\Core\Database;

$db = Database::getInstance()->getConnection();

$sql = "CREATE TABLE IF NOT EXISTS donations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    amount DECIMAL(10, 2) NOT NULL,
    message TEXT,
    payment_method VARCHAR(50) DEFAULT 'online',
    status VARCHAR(50) DEFAULT 'pending', -- pending, confirmed
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

try {
    $db->exec($sql);
    echo "Table 'donations' created successfully within 'wedding_db'.\n";
} catch (PDOException $e) {
    echo "Error creating table: " . $e->getMessage() . "\n";
}
