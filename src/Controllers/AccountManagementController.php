<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Config\database;
use App\Models\ManageAccountsService;

class AccountManagementController extends Controller
{
    private $account;

    public function __construct(database $db)
    {
        parent::__construct($db);
        $this->initializeAccountService();
    }

    private function initializeAccountService()
    {
        $this->account = new ManageAccountsService($this->db->getConnection());
    }

    public function getAccountManagement()
    {
        $this->render("admin-manage-account", ['accounts' => $this->account->getEmployees()]);
    }

    public function deleteAccount()
    {
        header("Content-Type: application/json");
        $json = file_get_contents('php://input');
        $data = json_decode($json, false);
        $id = $data->id;
        $this->account->deleteAccount($id);
        echo json_encode(["success" => true, "message" => "Deleted Successfully!"]);
    }

    public function activateAccount()
    {
        header("Content-Type: application/json");
        $json = file_get_contents('php://input');
        $data = json_decode($json, false);
        $id = $data->id;
        $this->account->activateAccount($id);
        echo json_encode(["success" => true, "message" => "Activated Successfully!"]);
    }

    public function deactivateAccount()
    {
        header("Content-Type: application/json");
        $json = file_get_contents('php://input');
        $data = json_decode($json, false);
        $id = $data->id;
        $this->account->deactivateAccount($id);
        echo json_encode(["success" => true, "message" => "Deactivated Successfully!"]);
    }

    public function getStatus()
    {
        header("Content-Type: application/json");
        $json = file_get_contents('php://input');
        $data = json_decode($json, false);
        $id = $data->id;
        $status = $this->account->getStatus($id);
        echo json_encode(["success" => true, "status" => $status]);
    }
}
