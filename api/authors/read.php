<?php

// call read method for author
$result = $author->read();

// get row count
$num = $result->rowCount();

// check if any authors
if($num > 0) {

    // create empty author array
    $authors_arr = array();

    // loop through all rows (results) and assign 
    // keys/values to associative array
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
            
        $author_item = array(
            'id' => $id,
            'author' => $author
        );

        // push to the array
        array_push($authors_arr, $author_item);
    }

    // convert to JSON and output
    print_r(json_encode($authors_arr));

} else {
    echo json_encode(
        array('message' => 'No Authors Found')
    );
}

