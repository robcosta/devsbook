<?php
namespace src\controllers;

use \core\Controller;

class LoginController extends Controller {
    
    public function sigin() {
        $this->render('login');
    }
    
    public function sigup() {
        echo "Tela de cadastro";
    }
    
}