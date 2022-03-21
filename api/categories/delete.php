<?php

// delete category
$category->delete();

// create array for JSON data
$category_arr = array (
    'id' => $category->id
);
    
print_r(json_encode($category_arr));
