<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Config\database;

class ReportsController extends Controller
{
    public function __construct(database $db)
    {
        parent::__construct($db);
    }

    public function getReports()
    {
        $this->render("admin-reports");
    }
}
