<?php

namespace App\Controllers;

class Controller
{
    protected $twig;

    public function __construct()
    {
        $this->twig = require __DIR__ . '/../../config/twig.php';
    }

    protected function render($view, $data = [])
    {
        echo $this->twig->render("$view.twig", $data);
    }
}
