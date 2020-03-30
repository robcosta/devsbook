<?php
namespace src\handlers;
use \core\Model;
use \src\models\User;

class LoginHandler {

    public static function checkLogin(){
        if(!empty($_SESSION['token'])){
            $token = $_SESSION['token'];

            $user = User::select()->where('token', $token)->one();
                       
            if(count($user)>0){
                $loggedUser = new User();
               // $loggedUser->setId($user['id']);
               // $loggedUser->setEmail($user['email']);
               // $loggedUser->setName($user['name']);


                return $user;
            }
        }    
        return false;
    }

    public static function verifyLogin($email, $password){
        //$user = User::select()->where('email',$email && 'password',$password)->one();
        $user = User::select()->where('email',$email)->one();

        if($user){
            if(password_verify($password, $user['password'])){
                //Gerando token
                $token = md5(time().rand(0,9999).time());
                USER::update()
                    ->set('token', $token)
                    ->where('id',$user['id'])
                ->execute();
                return $token;
            }
        }
        return false;
    }

    public static function emailExists($email){
        $user = User::select()->where('email', $email)->one();
        return $user ? true : false;
    }

    public static function addUser($name, $email, $password, $birthDate){
        //Gera o hash da senha
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $token = md5(time().rand(0,9999).time());
        User::insert([
            'email' => $email,
            'password' => $hash,
            'name' => $name,
            'birthdate' => $birthDate,
            'token' => $token
        ])->execute();

        return$token;
    }
}