<?php

namespace App\Controllers;

use App\Core\Controller;

class DressCodeController extends Controller
{
    public function index()
    {
        $this->view('dress_code', [
            'title' => 'Dress Code - Marcy et Leroy'
        ]);
    }
}
