<?php


namespace App\Controllers;

use App\Validations\FormValidator;
use App\Validations\inputSanitizer;
use App\Controllers\Controller;
use App\Config\database;
use App\Models\authenticate;
use App\Models\userService;

class LoginController extends Controller
{
    public function login()
    {
        $this->render("login");
    }

    public function userLogin()
    {
        $data = $_POST;
        $input = new inputSanitizer($data);
        $clean_form = $input->sanitize();
        $form = new FormValidator($clean_form);
        $db = new database();
        try {
            $authenticateUser = new authenticate($clean_form, $db);
            if (!$form->validateLogin()) {
                $this->render("login", ['errors' => $form->getErrors()]);
                return;
            }
            if (!$authenticateUser->authenticateLogin()) {
                $this->render("login", ['errors' => $authenticateUser->getErrors()]);
                return;
            }
            $userService = new userService($clean_form, $db);
            $user = $userService->findByUsername();
            $_SESSION['user_id'] = $user['id'];
            header("Location: /inventory");
            exit();
        } catch (\Exception $e) {
            die("An error occured: ". $e->getMessage());
        }
    }


    public function logout()
    {
        session_unset();
        session_destroy();
        header("Location: /login");
        exit();
    }
}
