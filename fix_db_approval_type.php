<?php
require_once __DIR__ . '/app/Core/Database.php';

use App\Core\Database;

$db = Database::getInstance()->getConnection();

try {
    // Modify is_approved column to INT to safely store '2'
    $sql = "ALTER TABLE guests MODIFY COLUMN is_approved INT NOT NULL DEFAULT 0";
    $db->exec($sql);
    echo "Successfully modified is_approved column to INT.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
