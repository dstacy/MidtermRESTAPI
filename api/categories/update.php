<?php

// check if all parameters are present. 
if(!property_exists($data, 'id') || !property_exists($data, 'category'))  {
    echo json_encode( 
        array('message' => 'Missing Required Parameters')
        );
} else {

    // set category to update
    $category->category = $data->category;

    // update category
    $category->update();

    // create array for JSON data
    $category_arr = array (
        'id' => $category->id,
        'category' => $category->category
    );
    
    print_r(json_encode($category_arr));
}