<?php

include_once '../../models/Author.php';
include_once '../../models/Category.php';


// check if all parameters are present
if(!property_exists($data, 'quote') || !property_exists($data, 'authorId') || !property_exists($data, 'categoryId'))  {
    echo json_encode( 
        array('message' => 'Missing Required Parameters')
        );
} else {

    // set properties to create
    $quote->quote = $data->quote;
    $quote->authorId = $data->authorId;
    $quote->categoryId = $data->categoryId;

    $author = new Author($db);
    $category = new Category($db);

    // create author
    $quote->create();

    if(!isValid($data->authorId, $author)) {
        echo json_encode( 
            array('message' => 'authorId Not Found')
            );
        return;
    }

    if(!isValid($data->categoryId, $category)) {
            echo json_encode( 
                array('message' => 'categoryId Not Found')
            );
        return;
    }

    // create array for JSON data
    $quote_arr = array (
        'id' => $db->lastInsertId(),
        'quote' => $quote->quote,
        'authorId' => $quote->authorId,
        'categoryId' => $quote->categoryId
        );

        print_r(json_encode($quote_arr));
}
