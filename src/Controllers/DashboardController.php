<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Config\database;

class DashboardController extends Controller
{
    public function __construct(database $db)
    {
        parent::__construct($db);
    }

    public function getDashboard()
    {
        $this->render("designer-dashboard");
    }
}
