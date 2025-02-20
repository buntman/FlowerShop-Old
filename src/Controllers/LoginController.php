<?php

namespace App\Controllers;

use App\Validations\FormValidator;
use App\Controllers\Controller;
use App\Config\database;
use App\Models\authenticate;

class LoginController extends Controller
{
    public function login()
    {
        $this->render("login");
    }

    public function userLogin()
    {
        $data = $_POST;
        $form = new FormValidator($data);
        $form->sanitize(); //not ideal approach
        $clean_form = $form->sanitize();
        $db = new database();
        try {
            $authenticateUser = new authenticate($clean_form, $db); //passing it as object instead of array
            if (!$form->validateLogin()) {
                $this->render("login", ['errors' => $form->getErrors()]);
                return;
            }
            if (!$authenticateUser->authenticateLogin()) {
                $this->render("login", ['errors' => $authenticateUser->getErrors()]);
                return;
            }
            header("Location: /inventory");
            exit();
        } catch (\Exception $e) {
            die("An error occured: ". $e->getMessage());
        }
    }
}
