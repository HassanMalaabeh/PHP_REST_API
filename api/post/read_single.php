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

//Get id
$post->id = isset($_GET['id']) ? $_GET['id'] :die();

//Get post
$post->readSingle();

$postArr = array(
    'id' => $post->id,
    'title' => $post->title,
    'body' => htmlentities($post->body),
    'author' => $post->author,
    'category_id' => $post->category_id,
    'category_name' => $post->caterory_name
);

print_r(json_encode($postArr));