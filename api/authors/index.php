<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
}

// include files 
include_once '../../config/Database.php';
include_once '../../models/Author.php';
include_once '../../functions/isValid.php';

// Instantiate database & connect
$database = new Database();
$db = $database->connect();

// instantiate author object
$author = new Author($db);
$data = json_decode(file_get_contents("php://input"));
$id;

// get id if set
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $authorExists = isValid($id, $author);
} elseif (isset($data->id)) {
    $id = $data->id; 
    $authorExists = isValid($id, $author);
}

switch($method) {
    case "POST":
        include_once 'create.php';
        break;
    case "GET":
        if(isset($id)) {
            if(!$authorExists) {
                echo json_encode( 
                    array('message' => 'authorId Not Found')
                );
            } else {
                include_once 'read_single.php';
            }
        } else {
            include_once 'read.php';
        }
        break;
    case "PUT":
        if(!$authorExists) {
            echo json_encode( 
                array('message' => 'authorId Not Found')
            );
        } else {
            include_once 'update.php';
        }
        break;
    case "DELETE": 
        if(!$authorExists) {
            echo json_encode( 
                array('message' => 'authorId Not Found')
            );
        } else {
            include_once 'delete.php';
        }
        break;
}