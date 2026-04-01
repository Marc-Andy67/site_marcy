<?php

namespace App\Controllers;

use App\Core\Controller;

class ProgramController extends Controller
{
    public function index()
    {
        $events = [
            [
                'time' => '14:30',
                'title' => 'Cérémonie',
                'icon' => '❤️',
                'desc' => 'Échange des vœux sous les étoiles.',
                'address' => 'Eglise St Jean Baptiste , 8 Rue Alexandre Zonzon, Rivière Salée 97215, Martinique'
            ],
            ['time' => '18:30', 'title' => 'Vin d\'honneur', 'icon' => '🥂', 'desc' => 'Cocktails et amuse-bouches dans le jardin.'],
            ['time' => '20:00', 'title' => 'Dîner', 'icon' => '🍽️', 'desc' => 'Repas gastronomique.'],
            ['time' => '22:00', 'title' => 'Soirée Dansante', 'icon' => '💃', 'desc' => 'Ouverture du bal et fête jusqu\'au bout de la nuit.'],
            ['time' => '00:00', 'title' => 'Gâteau', 'icon' => '🎂', 'desc' => 'Pièce montée et champagne.']
        ];

        $this->view('program', [
            'title' => 'Programme - Marcy et Leroy',
            'events' => $events
        ]);
    }
}
