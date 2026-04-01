<?php

namespace App\Controllers;

use App\Core\Controller;

class AboutController extends Controller
{
    public function index()
    {
        $this->view('about', [
            'title' => 'À Propos - Marcy et Leroy',
            'weddingDate' => '20 Juin 2026'
        ]);
    }
}
