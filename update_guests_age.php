<?php

require_once __DIR__ . '/app/Core/Database.php';

use App\Core\Database;

try {
    $db = Database::getInstance()->getConnection();

    // Add age column
    $stmt = $db->prepare("ALTER TABLE guests ADD COLUMN age INT NULL AFTER last_name");
    try {
        $stmt->execute();
        echo "Column 'age' added successfully.\n";
    } catch (PDOException $e) {
        echo "Column 'age' might already exist or error: " . $e->getMessage() . "\n";
    }

    // Add plus_one_age column
    $stmt = $db->prepare("ALTER TABLE guests ADD COLUMN plus_one_age INT NULL AFTER plus_one");
    try {
        $stmt->execute();
        echo "Column 'plus_one_age' added successfully.\n";
    } catch (PDOException $e) {
        echo "Column 'plus_one_age' might already exist or error: " . $e->getMessage() . "\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
