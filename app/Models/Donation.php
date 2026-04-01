<?php

namespace App\Models;

use App\Core\Model;

class Donation extends Model
{
    public function create($data)
    {
        $sql = "INSERT INTO donations (name, email, amount, message, payment_method, status) 
                VALUES (:name, :email, :amount, :message, :payment_method, :status)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':amount' => $data['amount'],
            ':message' => $data['message'] ?? null,
            ':payment_method' => $data['payment_method'] ?? 'online',
            ':status' => 'pending'
        ]);
    }

    public function getAll()
    {
        $sql = "SELECT id, name, email, amount, message, payment_method, status, created_at FROM donations ORDER BY created_at DESC";
        return $this->db->query($sql)->fetchAll();
    }

    public function getTotalAmount()
    {
        $sql = "SELECT SUM(amount) as total FROM donations WHERE status != 'cancelled'";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch();
        return $result['total'] ?? 0;
    }
}
