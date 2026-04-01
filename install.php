<?php
// Production Setup Script
// Run this script to initialize the database schema and seed default users.
// WARNING: This will WIPE existing data in the configured database.

header('Content-Type: text/plain');

echo "Starting installation...\n";

// 1. Load Configuration
$configFile = __DIR__ . '/config/database.php';
if (!file_exists($configFile)) {
    die("Error: Config file not found at " . $configFile . "\n");
}
$config = require $configFile;

echo "Configuration loaded.\n";

// 2. Connect to Database Server (without selecting DB first, to create it if needed)
try {
    $dsn = "mysql:host={$config['db_host']};charset={$config['db_charset']}";
    $pdo = new PDO($dsn, $config['db_user'], $config['db_pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    echo "Connected to MySQL server.\n";
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage() . "\n");
}

// 3. Create/Re-Create Database
$dbName = $config['db_name'];
try {
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "Database '$dbName' ensures.\n";
    $pdo->exec("USE `$dbName`");
} catch (PDOException $e) {
    die("Error creating/selecting database: " . $e->getMessage() . "\n");
}

// 4. Drop Tables (Reset)
echo "Resetting tables...\n";
$pdo->exec("DROP TABLE IF EXISTS guests");
$pdo->exec("DROP TABLE IF EXISTS users");

// 5. Create Tables
echo "Creating tables...\n";

// Users Table
$pdo->exec("
    CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");

// Guests Table (Full Schema)
$pdo->exec("
    CREATE TABLE guests (
        id INT AUTO_INCREMENT PRIMARY KEY,
        first_name VARCHAR(100) NOT NULL,
        last_name VARCHAR(100) NOT NULL,
        age INT NULL,
        email VARCHAR(255) NULL, 
        phone VARCHAR(20) NULL,
        is_attending BOOLEAN NOT NULL DEFAULT 0,
        plus_one INT DEFAULT 0,
        plus_one_age INT NULL,
        dietary_restrictions TEXT NULL,
        message TEXT NULL,
        is_approved BOOLEAN NOT NULL DEFAULT 0, -- 0=Pending, 1=Approved, 2=Rejected
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");

echo "Tables created successfully.\n";

// 6. Seed Admin Users
echo "Seeding admin users...\n";
$admins = [
    'marcy' => 'admin123',
    'leroy' => 'admin123',
    'marc-andy' => 'admin123'
];

$stmt = $pdo->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");

foreach ($admins as $user => $pass) {
    $hash = password_hash($pass, PASSWORD_DEFAULT);
    try {
        $stmt->execute([$user, $hash]);
        echo "User '$user' created.\n";
    } catch (PDOException $e) {
        echo "Error creating user '$user': " . $e->getMessage() . "\n";
    }
}

echo "\nInstallation completed successfully!\n";
echo "You can now delete this file if you wish to secure the installation endpoint.\n";
