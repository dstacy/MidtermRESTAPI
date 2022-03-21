<?php

// delete category
$quote->delete();

// create array for JSON data
$category_arr = array (
    'id' => $quote->id
);
    
print_r(json_encode($category_arr));
