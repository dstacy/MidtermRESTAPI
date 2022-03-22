<?php

// include models for isValid
include_once '../../models/Author.php';
include_once '../../models/Category.php';

// check if all parameters are present
if(!property_exists($data, 'quote') || !property_exists($data, 'authorId') || !property_exists($data, 'categoryId'))  {
    echo json_encode( 
        array('message' => 'Missing Required Parameters')
        );
} else {

    // instantiate objects for isValid
    $author = new Author($db);
    $category = new Category($db);

    if(!isValid($data->authorId, $author)) {
        echo json_encode( 
            array('message' => 'authorId Not Found')
        );
    } elseif (!isValid($data->categoryId, $category)) {
        echo json_encode( 
            array('message' => 'categoryId Not Found')
        );
    } else {

        // set properties to create
        $quote->quote = $data->quote;
        $quote->authorId = $data->authorId;
        $quote->categoryId = $data->categoryId;

        // create author
        $quote->create();

        // create array for JSON data
        $quote_arr = array (
            'id' => $db->lastInsertId(),
            'quote' => $quote->quote,
            'authorId' => $quote->authorId,
            'categoryId' => $quote->categoryId
        );

        print_r(json_encode($quote_arr));
    }
}
