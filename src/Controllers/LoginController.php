<?php 

namespace App\Controllers;
use App\Controller;

class LoginController extends Controller {
    public function login() {
        $this->render("login");
    }
}
?>
