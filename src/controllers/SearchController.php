<?php
namespace src\controllers;

use \core\Controller;
use \src\handlers\UserHandler;

class SearchController extends Controller {
     
    private $loggedUser;

    public function __construct() {
        $this->loggedUser = UserHandler::checkLogin();
        if($this->loggedUser === false){
            $this->redirect('/signin');
        }

    }

    public function index($atts = []){
        $searchTerm = filter_input(INPUT_GET, 's', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        //Verifica se o termo de pesquisa está em branco
        if(empty($searchTerm)){
            $this->redirect("/");
        }
        
        //Retorna ous usuários localizados
        $users = UserHandler::searchUser($searchTerm);

        //Montnado a tela de perfil do usuário
        $this->render('search',[
            'loggedUser' => $this->loggedUser,
            'searchTerm' => $searchTerm,
            'users' => $users        
        ]);
    }
    
}//fim da classe 