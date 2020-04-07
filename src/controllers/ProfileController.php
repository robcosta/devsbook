<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;
use \src\handlers\PostHandler;

class ProfileController extends Controller {
    
    private $loggedUser;

    public function __construct() {
        $this->loggedUser = UserHandler::checkLogin();
        if($this->loggedUser === false){
            $this->redirect('/signin');
        }

    }

    public function index($atts = []){
        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);

         //Detectando se o usuário existe, caso contrário usa o logado
        $id = $this->loggedUser->id;
        if(isset($atts['id'])){
            if(UserHandler::userExists(intval($atts['id']))){ 
                $id = intval($atts['id']);
            }
        }

        //Pegando informações do usuário
        $user = UserHandler::getUser($id, true);
        if(!$user){
            $this->redirect("/");
        }
        
        //Cálculo da idade do usuário
        $dateFrom = new \DateTime($user->birthdate);
        $dateTo = new \DateTime('today');
        $user->ageYears = $dateFrom->diff($dateTo)->y;

        //Pegando o feed do usuário
        $feed = PostHandler::getUserFeed(
            $user->id,
            $page,
            $this->loggedUser->id                  
        );

        //Verificar se EU sigo o usuário
        $isFollowing = false;
        if($user->id != $this->loggedUser->id){
            $isFollowing = UserHandler::isFollowing($this->loggedUser->id, $user->id);       
        }
        
        //Montnado a tela de perfil do usuário
        $this->render('profile',[
            'loggedUser' => $this->loggedUser,
            'user' => $user,
            'feed' => $feed,
            'isFollowing' => $isFollowing
        ]);
    }

    public function follow($atts){
        $to = intval($atts['id']);
        //verifica se o usuario a ser seguido existe
        if(UserHandler::userExists($to)){
            //verifica se o usuário é seguido
            if(UserHandler::isFollowing($this->loggedUser->id, $to)){
                //Deixar de seguir
                UserHandler::unFollow($this->loggedUser->id, $to);
            } else {
                //seguir
                UserHandler::follow($this->loggedUser->id, $to);
            } 
        }
        $this->redirect('/perfil/'.$to);
        
    }

}//fim da classe