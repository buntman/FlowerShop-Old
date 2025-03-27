<?php

namespace App\Controllers;

use App\Validations\FormValidator;
use App\Validations\inputSanitizer;
use App\Controllers\Controller;
use App\Config\database;
use App\Models\authenticate;
use App\Models\userService;

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

    public function userLogin()
    {
        header("Content-Type: application/json");
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $input = new inputSanitizer($data);
        $clean_form = $input->sanitize();
        $form = new FormValidator($clean_form);
        try {
            $authenticateUser = new authenticate($clean_form, $this->db->getConnection());
            $userService = new userService($clean_form, $this->db->getConnection());
            $user = $userService->findByUsername();

            if (!$form->validateLogin()) {
                echo json_encode(["success" => false, "errors" => $form->getErrors()]);
                return;
            }
            if (!$authenticateUser->authenticateLogin()) {
                echo json_encode(["success" => false, "errors" => $authenticateUser->getErrors()]);
                return;
            }
            if ($user['role'] == 'UNASSIGNED') {
                echo json_encode(["authorized" => false, "redirect" => "/pending-request"]);
                return;
            }
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];

            if ($user['role'] == 'ADMIN') {
                echo json_encode(["success" => true, "redirect" => "/admin-inventory"]);
            }
            if ($user['role'] == 'DESIGNER') {
                echo json_encode(["success" => true, "redirect" => "/designer-dashboard"]);
            }
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
}
