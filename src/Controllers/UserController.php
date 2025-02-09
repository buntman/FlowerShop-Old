<?php

namespace App\Controllers;

use App\Validations\FormValidator;
use App\Controllers\Controller;

class UserController extends Controller
{
    public function userLogin()
    {
        $data = $_POST;
        $form = new FormValidator($data);
        try {
            $form->validateLogin();
            $this->render("adminInventory");
        } catch (Exception $e) {
            echo "Hello";
        }
    }
}
