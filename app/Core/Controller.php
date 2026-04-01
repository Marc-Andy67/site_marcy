<?php

namespace App\Core;

class Controller
{
    public function view($view, $data = [])
    {
        extract($data);
        $viewPath = __DIR__ . '/../Views/' . $view . '.php';

        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            echo "View file not found: $viewPath";
        }
    }
}
