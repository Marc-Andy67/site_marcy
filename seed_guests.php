<?php
require_once __DIR__ . '/app/Core/Database.php';

use App\Core\Database;

$db = Database::getInstance()->getConnection();

try {
    // 1. Clear existing data
    $db->exec("DELETE FROM guests");
    // Reset auto-increment if possible (MySQL specific)
    $db->exec("ALTER TABLE guests AUTO_INCREMENT = 1");

    echo "Existing guests cleared.\n";

    // 2. Insert Mock Data
    $guests = [
        [
            'first_name' => 'Jean',
            'last_name' => 'Dupont',
            'email' => 'jean.dupont@example.com',
            'phone' => '0601020304',
            'is_attending' => 1,
            'plus_one' => 1,
            'dietary_restrictions' => 'Sans gluten',
            'message' => 'Hâte de vous voir !',
            'is_approved' => 1, // Approved
            'created_at' => date('Y-m-d H:i:s', strtotime('-5 days'))
        ],
        [
            'first_name' => 'Marie',
            'last_name' => 'Curie',
            'email' => 'marie.curie@science.com',
            'phone' => '0699887766',
            'is_attending' => 1,
            'plus_one' => 0,
            'dietary_restrictions' => null,
            'message' => 'Félicitations pour la découverte... de l\'amour !',
            'is_approved' => 0, // Pending
            'created_at' => date('Y-m-d H:i:s', strtotime('-1 hour'))
        ],
        [
            'first_name' => 'Paul',
            'last_name' => 'Personne',
            'email' => 'paul.nobody@example.com',
            'phone' => '0700000000',
            'is_attending' => 0, // Declined
            'plus_one' => 0,
            'dietary_restrictions' => null,
            'message' => 'Désolé, je ne pourrai pas venir.',
            'is_approved' => 0,
            'created_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
        ],
        [
            'first_name' => 'Troll',
            'last_name' => 'Internet',
            'email' => 'troll@spam.com',
            'phone' => '0123456789',
            'is_attending' => 1,
            'plus_one' => 5,
            'dietary_restrictions' => 'Mange des cailloux',
            'message' => 'Je viens avec toute ma famille !',
            'is_approved' => 2, // Refused
            'created_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
        ],
        [
            'first_name' => 'Claire',
            'last_name' => 'Fontaine',
            'email' => 'claire@water.com',
            'phone' => '0612341234',
            'is_attending' => 1,
            'plus_one' => 0,
            'dietary_restrictions' => null,
            'message' => null,
            'is_approved' => 1, // Approved
            'created_at' => date('Y-m-d H:i:s', strtotime('-4 hours'))
        ]
    ];

    $sql = "INSERT INTO guests (first_name, last_name, email, phone, is_attending, plus_one, dietary_restrictions, message, is_approved, created_at) 
            VALUES (:first_name, :last_name, :email, :phone, :is_attending, :plus_one, :dietary_restrictions, :message, :is_approved, :created_at)";

    $stmt = $db->prepare($sql);

    foreach ($guests as $guest) {
        $stmt->execute($guest);
    }

    echo "Inserted " . count($guests) . " mock guests successfully.\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
