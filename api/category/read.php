<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once './../../config/Database.php';
include_once './../../models/Category.php';

//Instantiate & DB connect
$database = new Database();
$db = $database->connect();

//Instantiate blog category object
$cat = new Category($db);

//Blog category query
$result = $cat->read();

//Get row count
$num = $result->rowCount();

//Check if any category
if($num > 0){
    //category array
    $catArr = array();
    $catArr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $catItem = array(
            'id' => $id,
            'name' => $name
        );

        //Push to data
        array_push($catArr['data'], $catItem);
    }

    //Turn to json & output
    echo json_encode($catArr);
}else{
    //No Categories
    echo json_encode(array(
        'message' => 'No Categories Found'
    ));
}

