<?php

namespace App\Controllers;

use App\Config\database;
use App\Models\EmployeeService;
use App\Validations\FormValidator;
use App\Validations\InputSanitizer;
use App\Controllers\Controller;
use App\Models\Authenticate;

class RegisterController extends Controller
{
    public function __construct(database $db)
    {
        parent::__construct($db);
    }

    public function register()
    {
        $this->render("register");
    }

    public function employeeRegister()
    {
        header("Content-Type: application/json");
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $input = new InputSanitizer($data);
        $clean_form = $input->sanitize();
        $form = new FormValidator($clean_form);
        try {
            $authenticateUser = new Authenticate($clean_form, $this->db->getConnection());
            if (!$form->validateRegister()) {
                echo json_encode(["success" => false, "errors" => $form->getErrors()]);
                return;
            }
            if (!$authenticateUser->authenticateRegistration()) {
                echo json_encode(["success" => false, "errors" => $authenticateUser->getErrors()]);
                return;
            }
            $employee = new EmployeeService($clean_form, $this->db->getConnection());
            $employee->save();
            echo json_encode(["success" => true, "redirect" => "/login"]);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
