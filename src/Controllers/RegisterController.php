<?php

namespace App\Controllers;

use App\Config\database;
use App\Models\userService;
use App\Validations\FormValidator;
use App\Validations\inputSanitizer;
use App\Controllers\Controller;
use App\Models\authenticate;

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

    public function userRegister()
    {
        header("Content-Type: application/json");
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $input = new inputSanitizer($data);
        $clean_form = $input->sanitize();
        $form = new FormValidator($clean_form);
        try {
            $authenticateUser = new authenticate($clean_form, $this->db->getConnection());
            if (!$form->validateRegister()) {
                echo json_encode(["success" => false, "errors" => $form->getErrors()]);
                return;
            }
            if (!$authenticateUser->authenticateRegistration()) {
                echo json_encode(["success" => false, "errors" => $authenticateUser->getErrors()]);
                return;
            }
            $user = new userService($clean_form, $this->db->getConnection());
            $user->save();
            echo json_encode(["success" => true, "redirect" => "/login"]);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
