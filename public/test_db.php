<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$config = require __DIR__ . '/../config/database.php';

echo "Attempting to connect with:\n";
echo "Host: " . $config['db_host'] . "\n";
echo "User: " . $config['db_user'] . "\n";
echo "Pass: " . ($config['db_pass'] ? '******' : 'EMPTY') . "\n";

try {
    $dsn = "mysql:host={$config['db_host']};dbname={$config['db_name']};charset={$config['db_charset']}";
    $pdo = new PDO($dsn, $config['db_user'], $config['db_pass']);
    echo "Connection SUCCESS!";
} catch (PDOException $e) {
    echo "Connection FAILED: " . $e->getMessage();
}
