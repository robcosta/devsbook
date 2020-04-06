<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;

class LoginController extends Controller {
    
    public function signin() {
        $flash = "";        
        if(!empty($_SESSION['flash'])){
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }
        $this->render('signin', [
            'flash' => $flash
        ]);
    }
    
    public function signinAction(){
        $email = filter_input(INPUT_POST,'email',FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, 'password');

        if($email && $password){
            //Verifica a existência do uauário e inicia a sessão
            $token = UserHandler::verifyLogin($email, $password);
            if($token){
                $_SESSION['token'] = $token;
                $this->redirect('/');
            } else {
                $_SESSION['flash'] = "E-mail e/ou senha não conferem!";
                $this->redirect('/signin');
            }
        } else {
            $this->redirect("/signin");
        }
    }

    public function signup() {
        $flash = "";        
        if(!empty($_SESSION['flash'])){
            $flash = $_SESSION['flash'];
            $_SESSION['flash'] = '';
        }
        $this->render('signup', [
            'flash' => $flash
        ]);
    }

    public function signupAction(){
        $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        $password = filter_input(INPUT_POST, "password");
        $birthDate = filter_input(INPUT_POST, "birthdate");       

        if($name && $email && $password && $birthDate ){
            //Verifica a data de nascimento e já coloca no formato internacional do DB (aaa-mm-dd)
           $birthDate = explode("/", $birthDate);
           if(!checkdate($birthDate[1], $birthDate[0],$birthDate[2])){
               $_SESSION['flash'] = "Data de nascimento inválida!";
               $this->redirect("/signup");
           }
           $birthDate = $birthDate[2].'-'.$birthDate[1].'-'.$birthDate[0]; 
           //verifica se á maior de 16 anos
           if(strtotime($birthDate) > strtotime(date('Y-m-d'))-(16 * 31536000 )){
                $_SESSION['flash'] = "Menor de 16 anos!";
               $this->redirect("/signup");
           }
           
           //Verifica se o email já foi cadastrado anteriormente
           if(UserHandler::emailExists($email) === false){
                $token = UserHandler::addUser($name, $email, $password, $birthDate);
                $_SESSION['token'] = $token;
                $this->redirect("/");
           } else {
                $_SESSION['flash'] = 'E-mail já cadastrado!';
                $this->redirect("/signup");
           } 

        } else {
           $this->redirect('/signup');
        }
    }

    public function logout(){
        $_SEEION['token'] = '';
        $this->redirect('/signin');
    }
}