<?php

// check if all parameters are present. 
if(!property_exists($data, 'id') || !property_exists($data, 'author'))  {
    echo json_encode( 
        array('message' => 'Missing Required Parameters')
        );
} else {
    // set author to update
    $author->author = $data->author;

    // update author
    $author->update();

    // create array for JSON data
    $author_arr = array (
        'id' => $author->id,
        'author' => $author->author
    );
    
    print_r(json_encode($author_arr));

}
