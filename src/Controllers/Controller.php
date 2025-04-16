<?php

namespace App\Controllers;

class Controller
{
    protected $twig;
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
        $this->twig = require __DIR__ . '/../../Config/twig.php';
    }

    protected function render($view, $data = [])
    {
        echo $this->twig->render("$view.twig", $data);
    }
}
