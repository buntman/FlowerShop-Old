<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Config\database;
use App\Models\ReportsService;
use App\Models\EmployeeService;

class ReportsController extends Controller
{
    public function __construct(database $db)
    {
        parent::__construct($db);
    }

    public function getReports()
    {
        $reports = new ReportsService($this->db->getConnection());
        $employee = new EmployeeService($this->db->getConnection());
        $this->render("admin-reports", ['reports' => $reports->fetchReports(), 'name' =>$employee->fetchEmployeeName()]);
    }
}
