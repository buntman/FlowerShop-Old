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

    public function deleteAccount()
    {
        header("Content-Type: application/json");
        $json = file_get_contents('php://input');
        $data = json_decode($json, false);
        $id = $data->id;
        $accounts = new ManageAccountsService($this->db->getConnection());
        $accounts->deleteAccount($id);
        echo json_encode(["success" => true, "message" => "Deleted Successfully!"]);
    }
}
