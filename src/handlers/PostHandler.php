<?php
namespace src\handlers;
use \src\models\Post;
use \src\models\User;
use \src\models\UserRelation;

class PostHandler {

public static function addPost($idUser, $type, $body, $date){

    $date = empty($date) ? date('Y-m-d H:i:s') : $date;
    if(!empty($idUser)){
        Post::insert([
            'id_user' => $idUser,
            'type' => $type,
            'created_at' => $date,
            'body' => $body
        ])->execute();
    }

    return true;
}

private static function _postListToObject($postList, $userId){
    // 3. Transformar o resultado em objetos dos models (Post).
    $posts = [];
    foreach ($postList as $postItem) {
        $newPost = new Post();
        $newPost->id = $postItem['id'];
        $newPost->type = $postItem['type'];
        $newPost->createdAt = date($postItem['created_at']);
        $newPost->body = $postItem['body'];
        $newPost->mine = false;

        if($postItem['id_user'] == $userId){
            $newPost->mine = true;
        }

        // 4. Preencher as informações adicionais no post.
        $newUser = User::select()->where('id',$postItem['id_user'])->one();
        $newPost->user = new User();
        $newPost->user->id = $newUser['id'];
        $newPost->user->name = $newUser['name'];
        $newPost->user->avatar = $newUser['avatar'];
        // TODO: 4.1 Preencher informações de LIKE
        // TODO: 4.2 Preenche informações de COMENTS

        $posts[] = $newPost;
    }
    return $posts;
}

public static function getUserFeed($idUser, $page){
    $perPage = 2;

    // 2. Pegar os posts dessa galera ordenado pela data.
    $postList = Post::select()
        ->where('id_user',$idUser)
        ->orderby('created_at','desc')
        ->page($page, $perPage)
    ->get();

    $total = Post::select()
        ->where('id_user',$idUser)
    ->count();

    $pageCount = ceil($total/$perPage);

    //Retorna todos os posts do usuário
    $posts =  self::_postListToObject($postList, $idUser);
    //echo "<pre>"; print_r($posts);exit;

    // 5. Retornar. 
    return [
        'posts' => $posts,
        'pageCount' => $pageCount,
        'currentPage' => $page
    ];

}


public static function getHomeFeed($loggedUserId, $page){
    $perPage = 2;
    // 1. Pegar a lista de usuarios que Eu sigo
    $userList = UserRelation::select()->where('id',$loggedUserId)->get();
    
    $users = [];
    foreach ($userList as $userItem) {
        $users[] = $userItem['user_to']; 
    }
    $users[] = $loggedUserId;
        
    // 2. Pegar os posts dessa galera ordenado pela data.
    $postList = Post::select()
    ->where('id_user','in',$users)
    ->orderby('created_at','desc')
    ->page($page, $perPage)
    ->get();
    
    
    $total = Post::select()
    ->where('id_user','in',$users)
    ->count();
    
    $pageCount = ceil($total/$perPage);
    
    // 3. Transformar o resultado em objetos dos models (Post).
    $posts = self::_postListToObject($postList, $loggedUserId);  
    
    // 5. Retornar. 
    return [
        'posts' => $posts,
        'pageCount' => $pageCount,
        'currentPage' => $page
    ];
}

public static function getPhotosFrom($idUser){
    $photosData = Post::select()
        ->where('id_user', $idUser)
        ->where('type', "photo")
    ->get();
    $photos= [];
    foreach ($photosData as $photo) {
        $newPost = new Post();
        $newPost->id = $photo['id']; 
        $newPost->type = $photo['type']; 
        $newPost->createdAt = $photo['created_at']; 
        $newPost->body = $photo['body']; 

        $photos[] = $newPost;
    }
    return $photos;
}

}//fim da classe