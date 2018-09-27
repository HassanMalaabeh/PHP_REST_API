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

//Get id
$cat->id = isset($_GET['id']) ? $_GET['id'] :die();

//Get category
$cat->readSingle();

$catArr = array(
    'id' => $cat->id,
    'name' => $cat->name,

);

print_r(json_encode($catArr));