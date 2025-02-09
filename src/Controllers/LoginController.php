<?php

namespace App\Controllers;

use App\Validations\FormValidator;
use App\Controllers\Controller;

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
        try {
            $form->sanitize();
            $form->validateLogin();
            $this->render("adminInventory");
        } catch (Exception $e) {
            echo "Hello";
        }
    }
}
