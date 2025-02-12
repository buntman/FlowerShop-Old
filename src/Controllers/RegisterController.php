<?php

namespace App\Controllers;

use App\Validations\FormValidator;
use App\Controllers\Controller;

class RegisterController extends Controller
{
    public function register()
    {
        $this->render("register");
    }

    public function userRegister()
    {
        $data = $_POST;
        $form = new FormValidator($data);
        try {
            $form->sanitize();
            if (!$form->validateRegister()) {
                $this->render("register", ['errors' => $form->getErrors()]);
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
