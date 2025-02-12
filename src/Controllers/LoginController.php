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
            if (!$form->validateLogin()) {
                $this->render("login", ['errors' => $form->getErrors()]);
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
