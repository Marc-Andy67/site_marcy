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
        $approvedGuests = array_filter($guestModel->getAllWithCompanions(), function($g) {
            return $g['is_approved'] == 1 && $g['is_attending'] == 1;
        });

        $this->view('guest_list', [
            'title' => 'Les Invités - Marcy et Leroy',
            'guests' => $approvedGuests
        ]);
    }
}
