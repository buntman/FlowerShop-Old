<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\InventoryService;
use App\config\database;

class GalleryController extends Controller
{
    private $inventory;

    public function __construct(database $db)
    {
        parent::__construct($db);
        $this->initializeInventoryService();
    }

    private function initializeInventoryService()
    {
        $this->inventory = new InventoryService($this->db->getConnection());
    }

    public function getBouquets()
    {
        header("Content-Type: application/json");
        $bouquets = $this->inventory->getBouquets();
        foreach ($bouquets as &$bouquet) { //pass by reference
            $bouquet['image_path'] = "http://10.0.2.2:8080" . $bouquet['image_path'];
        }
        unset($bouquet);
        echo json_encode($bouquets);
    }
}
