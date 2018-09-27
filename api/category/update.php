<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,
Access-Control-Allow-Methods, Authorization');

include_once './../../config/Database.php';
include_once './../../models/Category.php';

//Instantiate & DB connect
$database = new Database();
$db = $database->connect();

//Instantiate blog category object
$cat = new Category($db);

//Get raw category date
$data = json_decode(file_get_contents('php://input'));

//Set id to update
$cat->id = $data->id;

$cat->name = $data->name;


if($cat->update()){
    echo json_encode(array(
            'message' => 'Category updated'
        )
    );
}else{
    echo json_encode(array(
            'message' => 'Category not updated'
        )
    );
}
