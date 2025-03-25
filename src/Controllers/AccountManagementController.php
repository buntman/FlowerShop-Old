<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Config\database;

class AccountManagementController extends Controller
{
    public function __construct(database $db)
    {
        parent::__construct($db);
    }

    public function getAccountManagement()
    {
        $this->render("admin-manage-account");
    }
}
