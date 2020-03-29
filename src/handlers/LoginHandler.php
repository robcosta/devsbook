<?php
namespace src\handlers;
use \core\Model;
use \src\models\User;

class LoginHandler {

    public static function checkLogin(){
        if(!empty($_SESSION['token'])){
            $token = $_SESSION['token'];

            $data = User::select()->where('token', $token)->one();
            
            if(count($data)>0){
                $loggedUser = new User();
               // $loggedUser->setId($data['id']);
               // $loggedUser->setEmail($data['email']);
               // $loggedUser->setName($data['name']);


                return $data;
            }
        }    
        return false;
    }
}