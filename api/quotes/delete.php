<?php

// delete category
$quote->delete();

// create array for JSON data
$quote_arr = array (
    'id' => $quote->id
);
    
print_r(json_encode($quote_arr));
