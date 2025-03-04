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
        $data = $_POST;
        $input = new inputSanitizer($data);
        $clean_form = $input->sanitize();
        $form = new FormValidator($clean_form);
        try {
            $authenticateUser = new authenticate($clean_form, $this->db->getConnection());
            if (!$form->validateRegister()) {
                $this->render("register", ['errors' => $form->getErrors()]);
                return;
            }
            if (!$authenticateUser->authenticateRegistration()) {
                $this->render("register", ['errors' => $authenticateUser->getErrors()]);
                return;
            }
            $user = new userService($clean_form, $this->db->getConnection());
            $user->save();
            header("Location: /login");
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
