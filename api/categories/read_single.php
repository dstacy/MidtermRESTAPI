<?php

// get category
$category->read_single();

// create array for JSON data
$category_arr = array (
    'id' => $category->id,
    'category' => $category->category
);

// convert to JSON
print_r(json_encode($category_arr));
