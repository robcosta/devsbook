<?php
namespace src\handlers;
use \src\models\Post;
use \src\models\User;
use \src\models\UserRelations;

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


public static function getHomeFeed($idUser, $page){
    $perPage = 2;
    // 1. Pegar a lista de usuarios que Eu sigo
    $userList = UserRelations::select()->where('id',$idUser)->get();
    $users = [];
    foreach ($userList as $userItem) {
        $users = $userItem->user_to; 
    }
    $users[] = $idUser;
    
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
    $posts = [];
    foreach ($postList as $postItem) {
        $newPost = new Post();
        $newPost->id = $postItem['id'];
        $newPost->type = $postItem['type'];
        $newPost->createdAt = date('d/m/Y H:i:s', strtotime($postItem['created_at']));
        $newPost->body = $postItem['body'];
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
    // 5. Retornar. 
    return [
        'posts' => $posts,
        'pageCount' => $pageCount,
        'currentPage' => $page
    ];
}

}
