<?php

// check if all parameters are present. Id not required as auto incremented by database.
if(!property_exists($data, 'category')) {
    echo json_encode( 
        array('message' => 'Missing Required Parameters')
        );
} else {
// set category to create
$category->category = $data->category;

// create category
$category->create();

// create array for JSON data
$category_arr = array (
    'id' => $db->lastInsertId(),
    'category' => $category->category
);

print_r(json_encode($category_arr));
}