<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,
Access-Control-Allow-Methods, Authorization');

include_once './../../config/Database.php';
include_once './../../models/Post.php';

//Instantiate & DB connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$post = new Post($db);

//Get raw posted date
$data = json_decode(file_get_contents('php://input'));

//Set id to delete
$post->id = $data->id;


if($post->delete()){
    echo json_encode(array(
            'message' => 'Post deleted'
        )
    );
}else{
    echo json_encode(array(
            'message' => 'Post not deleted'
        )
    );
}
