<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once './../../config/Database.php';
include_once './../../models/Post.php';

//Instantiate & DB connect
$database = new Database();
$db = $database->connect();

//Instantiate blog post object
$post = new Post($db);

//Blog post query
$result = $post->read();

//Get row count
$num = $result->rowCount();

//Check if any post
if($num > 0){
    //post array
    $postArr = array();
    $postArr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $postItem = array(
            'id' => $id,
            'title' => $title,
            'body' => htmlentities($body),
            'author' => $author,
            'category_id' => $category_id,
            'category_name' => $caterory_name
        );

        //Push to data
        array_push($postArr['data'], $postItem);
    }

    //Turn to json & output
    echo json_encode($postArr);
}else{
    //No Posts
    echo json_encode(array(
        'message' => 'No Posts Found'
    ));
}

