<?php

// call read method for quote
$result = $quote->read();

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

        // push to the array
        array_push($quotes_arr, $quote_item);
    }

    // convert to JSON and output
    echo json_encode($quotes_arr);

} else {
    echo json_encode(
        array('message' => 'No Quotes Found')
    );
}