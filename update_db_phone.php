<?php
require_once __DIR__ . '/app/Core/Database.php';

use App\Core\Database;

$db = Database::getInstance()->getConnection();

try {
    // Add phone column
    $sql = "ALTER TABLE guests ADD COLUMN phone VARCHAR(20) NOT NULL DEFAULT ''";
    $db->exec($sql);
    echo "Successfully added phone column to guests table.\n";
} catch (PDOException $e) {
    // Ignore if column already exists or other non-critical error for idempotent run
    echo "Note: " . $e->getMessage() . "\n";
}
