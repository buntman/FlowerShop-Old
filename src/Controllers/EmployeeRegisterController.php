<?php

namespace App\Controllers;

use App\Config\database;
use App\Models\EmployeeService;
use App\Validations\FormValidator;
use App\Validations\InputSanitizer;
use App\Controllers\Controller;
use App\Models\Authenticate;

class EmployeeRegisterController extends Controller
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
            if (!$form->validateEmployeeRegister()) {
                echo json_encode(["success" => false, "errors" => $form->getErrors()]);
                return;
            }

            $authenticateUser = new Authenticate($clean_form, $this->db->getConnection());
            if (!$authenticateUser->authenticateEmployeeRegistration()) {
                echo json_encode(["success" => false, "errors" => $authenticateUser->getErrors()]);
                return;
            }

            $employee = new EmployeeService($this->db->getConnection(), $clean_form);
            $employee->save();
            echo json_encode(["success" => true, "redirect" => "/employee/login"]);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
