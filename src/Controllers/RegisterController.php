<?php

namespace App\Controllers;

use App\config\database;
use App\Models\storeData;
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
        $db = new database();
        try {
            $form->sanitize();
            if (!$form->validateRegister()) {
                $this->render("register", ['errors' => $form->getErrors()]);
                return;
            }
            $clean_form = $form->sanitize();
            $store = new storeData($clean_form, $db);
            $store->save();
            header("Location: /login");
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
