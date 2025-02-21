<?php

namespace App\Controllers;

use App\Config\database;
use App\Models\storeData;
use App\Validations\FormValidator;
use App\Validations\inputSanitizer;
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
        $input = new inputSanitizer($data);
        $clean_form = $input->sanitize();
        $form = new FormValidator($clean_form);
        $db = new database();
        try {
            if (!$form->validateRegister()) {
                $this->render("register", ['errors' => $form->getErrors()]);
                return;
            }
            $store = new storeData($clean_form, $db);
            $store->save();
            header("Location: /login");
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
