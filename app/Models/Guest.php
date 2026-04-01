<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Guest extends Model
{
    public function create($data)
    {
        $sql = "INSERT INTO guests (first_name, last_name, age, email, phone, is_attending, plus_one, plus_one_age, dietary_restrictions, message, is_approved) 
                VALUES (:first_name, :last_name, :age, :email, :phone, :is_attending, :plus_one, :plus_one_age, :dietary_restrictions, :message, :is_approved)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':first_name' => $data['first_name'],
            ':last_name' => $data['last_name'],
            ':age' => $data['age'],
            ':email' => $data['email'],
            ':phone' => $data['phone'],
            ':is_attending' => $data['is_attending'],
            ':plus_one' => $data['plus_one'] ?? 0,
            ':plus_one_age' => $data['plus_one_age'] ?? null,
            ':dietary_restrictions' => $data['dietary_restrictions'] ?? null,
            ':message' => $data['message'] ?? null,
            ':is_approved' => $data['is_approved'] ?? 0
        ]);
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM guests ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM guests WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM guests WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function approve($id)
    {
        $stmt = $this->db->prepare("UPDATE guests SET is_approved = 1 WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function getApproved()
    {
        $stmt = $this->db->query("SELECT * FROM guests WHERE is_approved = 1 ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function reject($id)
    {
        $stmt = $this->db->prepare("UPDATE guests SET is_approved = 2 WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function update($id, $data)
    {
        $isApproved = isset($data['is_approved']) ? $data['is_approved'] : 0; // Default to pending if not specified

        $sql = "UPDATE guests SET 
                first_name = :first_name,
                last_name = :last_name,
                age = :age,
                phone = :phone,
                is_attending = :is_attending,
                plus_one = :plus_one,
                plus_one_age = :plus_one_age,
                dietary_restrictions = :dietary_restrictions,
                message = :message,
                is_approved = :is_approved,
                created_at = NOW()
                WHERE id = :id";

        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':first_name' => $data['first_name'],
            ':last_name' => $data['last_name'],
            ':age' => $data['age'] ?? null,
            ':phone' => $data['phone'],
            ':is_attending' => $data['is_attending'],
            ':plus_one' => $data['plus_one'],
            ':plus_one_age' => $data['plus_one_age'] ?? null,
            ':dietary_restrictions' => $data['dietary_restrictions'],
            ':message' => $data['message'],
            ':is_approved' => $isApproved
        ]);
    }
}
