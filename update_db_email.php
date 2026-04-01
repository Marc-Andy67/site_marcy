<?php
require_once __DIR__ . '/app/Core/Database.php';

use App\Core\Database;

$db = Database::getInstance()->getConnection();

try {
    // Add UNIQUE constraint
    $sql = "ALTER TABLE guests ADD CONSTRAINT unique_email UNIQUE (email)";
    $db->exec($sql);
    echo "Successfully added UNIQUE constraint to email column.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
