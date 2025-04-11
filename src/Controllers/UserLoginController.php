<?php

namespace App\Controllers;

use App\Controller;
use App\Validations\FormValidator;
use App\Validations\InputSanitizer;
use App\database;

class UserLoginController extends Controller
{
    public function __construct(database $db)
    {
        parent::__construct($db);
    }

    public function userLogin()
    {
        header("Content-Type: application/json");
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $input = new InputSanitizer($data);
        $clean_form = $input->sanitize();
        $validate_user = new FormValidator($clean_form);

        if (!$validate_user->validateUserLogin()) {
            echo json_encode(["success" => false, "errors" => $validate_user->getErrors()]);
            return;
        }

        // need to query db to authenticate user
    }
}
