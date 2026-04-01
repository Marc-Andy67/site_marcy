<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Guest;

class GuestListController extends Controller
{
    public function __construct()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }

    public function index()
    {
        $guestModel = new Guest();
        // Only fetch approved guests
        $approvedGuests = $guestModel->getApproved();

        $this->view('guest_list', [
            'title' => 'Les Invités - Marcy et Leroy',
            'guests' => $approvedGuests
        ]);
    }
}
