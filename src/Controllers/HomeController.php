<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\HomePageService;
use App\config\database;

class HomeController extends Controller
{
    private $bouquetService;

    public function __construct(database $db)
    {
        parent::__construct($db);
        $this->initializeHomePageService();
    }

    private function initializeHomePageService()
    {
        $this->bouquetService = new HomePageService($this->db->getConnection());
    }

    public function getBouquets()
    {
        header("Content-Type: application/json");
        $bouquets = $this->bouquetService->getBouquets();
        foreach ($bouquets as &$bouquet) { //pass by reference
            $bouquet['image_path'] = "http://10.0.2.2:8080" . $bouquet['image_path'];
        }
        unset($bouquet);
        echo json_encode($bouquets);
    }
}
