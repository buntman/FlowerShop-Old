<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Config\database;
use App\Models\ManageAccountsService;

class AccountManagementController extends Controller
{
    public function __construct(database $db)
    {
        parent::__construct($db);
    }

    public function getAccountManagement()
    {
        $accounts = new ManageAccountsService($this->db->getConnection());
        $this->render("admin-manage-account", ['accounts' => $accounts->getEmployees()]);
    }
}
