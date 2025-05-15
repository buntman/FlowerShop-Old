<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Config\database;
use App\Models\ReportsService;

class ReportsController extends Controller
{
    public function __construct(database $db)
    {
        parent::__construct($db);
    }

    public function getReports()
    {
        $reports = new ReportsService($this->db->getConnection());
        $this->render("admin-reports", ['reports' => $reports->fetchReports()]);
    }
}
