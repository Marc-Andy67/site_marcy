<?php
$config = require __DIR__ . '/config/database.php';

try {
    $pdo = new PDO(
        "mysql:host={$config['db_host']};dbname={$config['db_name']};charset={$config['db_charset']}",
        $config['db_user'],
        $config['db_pass'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Run migration first
    $sql = file_get_contents(__DIR__ . '/migration_companions.sql');
    // Splitting by semicolon isn't perfect but allows multiple statements if exec fails on multi-query
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);
    $pdo->exec($sql);
    echo "Migration effectuée.\n";

    // Disable foreign key checks to allow truncation
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
    
    // Truncate tables
    $pdo->exec("TRUNCATE TABLE companions");
    $pdo->exec("TRUNCATE TABLE guests");
    
    // Re-enable foreign key checks
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");

    echo "Base de données purifiée avec succès.";
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
