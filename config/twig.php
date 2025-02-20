<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

$twig_config = require __DIR__. '/config.php';

$twig_path = $twig_config['twig']['twig_template'];
$loader = new FilesystemLoader($twig_path);
$twig = new Environment($loader, [
    'cache' => false,
]);

return $twig;
