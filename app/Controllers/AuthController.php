<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;

class AuthController extends Controller
{
    public function login()
    {
        // If already logged in, redirect to admin
        if (isset($_SESSION['user_id'])) {
            header('Location: /admin');
            exit;
        }

        $this->view('auth/login', [
            'title' => 'Connexion Admin'
        ]);
    }

    public function attemptLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            $db = Database::getInstance();
            $pdo = $db->getConnection();

            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password_hash'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                header('Location: /admin');
                exit;
            } else {
                $this->view('auth/login', [
                    'title' => 'Connexion Admin',
                    'error' => 'Identifiants incorrects.'
                ]);
            }
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: /login');
        exit;
    }
}
