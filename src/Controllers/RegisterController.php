<?php

namespace App\Controllers;

use App\Controllers\Controller;

class RegisterController extends Controller
{
    public function register()
    {
        $this->render("register");
    }
}
