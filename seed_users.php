<?php

require_once __DIR__ . '/vendor/autoload.php';

// Manual Autoloader
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/app/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

use App\Core\Database;

$db = Database::getInstance();
$pdo = $db->getConnection();

// Check if users table exists, if not create it (redundant if using updated setup, but good for safety)
$pdo->exec("
    CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
");

$users = [
    'marcy' => 'admin123',
    'leroy' => 'admin123',
    'marc-andy' => 'admin123'
];

echo "Seeding users...\n";

foreach ($users as $username => $password) {
    // Check if user exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);

    if ($stmt->fetch()) {
        echo "User '$username' already exists. Skipping.\n";
        continue;
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");

    if ($stmt->execute([$username, $hash])) {
        echo "User '$username' created successfully.\n";
    } else {
        echo "Error creating user '$username'.\n";
    }
}

echo "Done.\n";
