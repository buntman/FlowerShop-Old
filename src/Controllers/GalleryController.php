<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\GalleryService;
use App\Config\database;

class GalleryController extends Controller
{
    private $gallery;

    public function __construct(database $db)
    {
        parent::__construct($db);
        $this->initializeGalleryService();
    }

    private function initializeGalleryService()
    {
        $this->gallery = new GalleryService($this->db->getConnection());
    }

    public function getBouquets()
    {
        header("Content-Type: application/json");
        $bouquets = $this->gallery->getBouquets();
        foreach ($bouquets as &$bouquet) { //pass by reference
            $bouquet['image_path'] = "http://10.0.2.2:8080" . $bouquet['image_path'];
        }
        unset($bouquet);
        echo json_encode($bouquets);
    }
}
