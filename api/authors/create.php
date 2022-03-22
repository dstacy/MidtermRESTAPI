<?php

// check if all parameters are present. Id not required as auto incremented by database.
if(!property_exists($data, 'author')) {
    echo json_encode( 
        array('message' => 'Missing Required Parameters')
        );
} else {
    
    // set author to create
    $author->author = $data->author;

    // create author
    $author->create();

    // create array for JSON data
    $author_arr = array (
        'id' => $db->lastInsertId(),
        'author' => $author->author
    );

    print_r(json_encode($author_arr));
}