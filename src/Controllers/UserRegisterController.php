<?php

namespace App\Controllers;

use App\Controllers\Controller;
use App\Models\Authenticate;
use App\Models\UserService;
use App\Validations\FormValidator;
use App\Validations\InputSanitizer;
use App\Config\database;

class UserRegisterController extends Controller
{
    public function __construct(database $db)
    {
        parent::__construct($db);
    }

    public function userRegister()
    {
        header("Content-Type: application/json");
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $input = new InputSanitizer($data);
        $clean_form = $input->sanitize();

        $validate_user = new FormValidator($clean_form);

        if (!$validate_user->validateUserRegister()) {
            echo json_encode(["success" => false, "errors" => $validate_user->getErrors()]);
            return;
        }

        $authenticate_user = new Authenticate($clean_form, $this->db->getConnection());

        if (!$authenticate_user->authenticateUserRegistration()) {
            echo json_encode(["success" => false, "errors" => $authenticate_user->getErrors()]);
            return;
        }

        $user = new UserService($clean_form, $this->db->getConnection());
        $user->save();
        echo json_encode(["success" => true, "message" => "Successfully registered!"]);
    }
}
