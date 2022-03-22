<?php

// set authorId to read
$quote->authorId = $authorId;

// get quote by authorId
$result = $quote->read_author();

// get row count
$num = $result->rowCount();

// check if any quotes
if($num > 0) {

    // create empty quote array
    $quotes_arr = array();

    // loop through all rows (results) and assign 
    // keys/values to associative array
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $quote_item = array(
            'id' => $id,
            'quote' => $quote,
            'author' => $author,
            'category' => $category
        );

        array_push($quotes_arr, $quote_item);
    }

    // convert to JSON and output
    print_r(json_encode($quotes_arr));
    // return true;

} else {
    echo json_encode(
        array('message' => 'authorId Not Found')
    );
    // return false;
}




