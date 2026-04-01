<?php

namespace App\Models;

use App\Core\Model;
use PDO;

class Guest extends Model
{
    public function create($data)
    {
        $sql = "INSERT INTO guests (first_name, last_name, age, email, phone, is_attending, dietary_restrictions, message, is_approved) 
                VALUES (:first_name, :last_name, :age, :email, :phone, :is_attending, :dietary_restrictions, :message, :is_approved)";

        $stmt = $this->db->prepare($sql);

        $success = $stmt->execute([
            ':first_name' => $data['first_name'],
            ':last_name' => $data['last_name'],
            ':age' => $data['age'],
            ':email' => $data['email'],
            ':phone' => $data['phone'],
            ':is_attending' => $data['is_attending'],
            ':dietary_restrictions' => $data['dietary_restrictions'] ?? null,
            ':message' => $data['message'] ?? null,
            ':is_approved' => $data['is_approved'] ?? 0
        ]);

        if ($success) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function getAll()
    {
        $stmt = $this->db->query("SELECT id, first_name, last_name, email, phone, is_attending, is_approved, message, created_at FROM guests ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT id, first_name, last_name, email, phone, is_attending, is_approved, message, created_at FROM guests WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch();
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT id, first_name, last_name, email, phone, is_attending, is_approved, message, created_at FROM guests WHERE id = :id");
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
        $stmt = $this->db->query("SELECT first_name, last_name FROM guests WHERE is_approved = 1 ORDER BY created_at DESC");
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
            ':dietary_restrictions' => $data['dietary_restrictions'],
            ':message' => $data['message'],
            ':is_approved' => $isApproved
        ]);
    }

    public function getWithCompanions($id)
    {
        $guest = $this->findById($id);
        if ($guest) {
            $stmt = $this->db->prepare("SELECT guest_id, first_name, age, children_menu FROM companions WHERE guest_id = :id");
            $stmt->execute([':id' => $id]);
            $guest['companions'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $guest;
    }

    public function getAllWithCompanions()
    {
        $guests = $this->getAll();
        
        $stmt = $this->db->query("SELECT guest_id, first_name, age, children_menu FROM companions");
        $companions = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $companionsByGuest = [];
        foreach ($companions as $comp) {
            $companionsByGuest[$comp['guest_id']][] = $comp;
        }
        
        foreach ($guests as &$guest) {
            $guest['companions'] = $companionsByGuest[$guest['id']] ?? [];
        }
        
        return $guests;
    }
}
