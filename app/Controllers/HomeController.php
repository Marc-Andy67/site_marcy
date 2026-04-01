<?php

namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $this->view('index', [
            'title' => 'Nuit Étoilée - Mariage',
            'weddingDate' => '22-08-2026' // Example date
        ]);
    }
}
