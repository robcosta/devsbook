<?php
namespace src\handlers;
use \src\models\Post;

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

}
