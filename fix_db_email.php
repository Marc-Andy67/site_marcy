<?php
require_once __DIR__ . '/app/Core/Database.php';

use App\Core\Database;

$db = Database::getInstance()->getConnection();

try {
    // 1. Delete rows where email is empty or NULL (Invalid data from early tests)
    $db->exec("DELETE FROM guests WHERE email = '' OR email IS NULL");
    echo "Deleted rows with empty emails.\n";

    // 2. Add UNIQUE constraint
    $sql = "ALTER TABLE guests ADD CONSTRAINT unique_email UNIQUE (email)";
    $db->exec($sql);
    echo "Successfully added UNIQUE constraint to email column.\n";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
