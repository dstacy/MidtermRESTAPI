<?php

    // call read method for category
    $result = $category->read();

    // get row count
    $num = $result->rowCount();

    // check if any categories
    if($num > 0) {

        // create empty category array
        $category_arr = array();

        // loop through all rows (results) and assign 
        // keys/values to associative array
        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            
            $category_item = array(
                'id' => $id,
                'category' => $category
            );

            // push to the array
            array_push($category_arr, $category_item);
        }

        // convert to JSON and output
        print_r(json_encode($category_arr));

    } else {
        echo json_encode(
            array('message' => 'No categories Found')
        );
    }