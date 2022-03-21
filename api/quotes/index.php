<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
}

include_once '../../config/Database.php';
include_once '../../models/Quote.php';
include_once '../../functions/isValid.php';

// Instantiate database & connect
$database = new Database();
$db = $database->connect();

// instantiate quote object
$quote = new Quote($db);

$data = json_decode(file_get_contents("php://input"));
$id;
$authorId;
$categoryId;

// get id if set
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $quoteExists = isValid($id, $quote);
} elseif (isset($data->id)) {
    $id = $data->id; 
    $quoteExists = isValid($id, $quote);
}

if(isset($_GET['authorId'])) {
    $authorId = $_GET['authorId'];
} 

if(isset($_GET['categoryId'])) {
    $categoryId = $_GET['categoryId'];
}

    switch($method) {
        case "POST":
            include_once 'create.php';
            break;
        case "GET":
            if(isset($id)) {
                if(!$quoteExists) {
                    echo json_encode( 
                    array('message' => 'No Quotes Found')
                    );
                } else {
                    include_once 'read_single.php';
                }
            } elseif(isset($authorId)) {
                if(isset($categoryId)) {
                    include_once 'read_authorAndCategory.php';
                } else {
                    include_once 'read_author.php';  
                } 
            } elseif(isset($categoryId)) {
                include_once 'read_category.php';
            } else {
                include_once 'read.php';
            }
            break;
        case "PUT":
            if(!$quoteExists) {
                echo json_encode( 
                array('message' => 'No Quotes Found')
                );
            } else {
                include_once 'update.php';
            }
            break;
        case "DELETE": 
            if(!$quoteExists) {
                echo json_encode( 
                array('message' => 'No Quotes Found')
                );
            } else {
            include_once 'delete.php';
            }
            break;
    }



