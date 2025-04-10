<?php

namespace App\Controllers;

use App\Validations\FormValidator;
use App\Validations\InputSanitizer;
use App\Controllers\Controller;
use App\Config\database;
use App\Models\Authenticate;
use App\Models\EmployeeService;

class LoginController extends Controller
{
    public function __construct(database $db)
    {
        parent::__construct($db);
    }

    public function login()
    {
        $this->render("login");
    }

    public function employeeLogin()
    {
        header("Content-Type: application/json");
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $input = new InputSanitizer($data);
        $clean_form = $input->sanitize();
        $form = new FormValidator($clean_form);
        try {
            $authenticateUser = new Authenticate($clean_form, $this->db->getConnection());
            $employeeService = new EmployeeService($clean_form, $this->db->getConnection());
            $employee = $employeeService->findByUsername();

            if (!$form->validateLogin()) {
                echo json_encode(["success" => false, "errors" => $form->getErrors()]);
                return;
            }
            if (!$authenticateUser->authenticateLogin()) {
                echo json_encode(["success" => false, "errors" => $authenticateUser->getErrors()]);
                return;
            }
            if ($employee['status'] == 'INACTIVE') {
                echo json_encode(["authorized" => false, "redirect" => "/pending-request"]);
                return;
            }
            session_regenerate_id(true);
            $_SESSION['user_id'] = $employee['id'];
            $_SESSION['user_role'] = $employee['role'];
            $this->redirectUser($employee['role']);
        } catch (\Exception $e) {
            die("An error occured: ". $e->getMessage());
        }
    }


    public function logout()
    {
        session_unset();
        session_destroy();
        header("Location: /login");
        exit();
    }


    private function redirectUser($role)
    {
        $routes = [
            'ADMIN' => '/admin-inventory',
            'DESIGNER' => '/designer-dashboard'
        ];
        if (isset($routes[$role])) {
            echo json_encode(["success" => true, "redirect" => $routes[$role]]);
        }
    }
}
