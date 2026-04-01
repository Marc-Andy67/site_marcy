<?php
require_once __DIR__ . '/app/Core/Database.php';

use App\Core\Database;

$db = Database::getInstance()->getConnection();

try {
    // Add is_approved column, default to 0 (false)
    $sql = "ALTER TABLE guests ADD COLUMN is_approved BOOLEAN NOT NULL DEFAULT 0";
    $db->exec($sql);
    echo "Successfully added is_approved column.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
