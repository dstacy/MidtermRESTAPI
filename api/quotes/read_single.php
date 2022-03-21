<?php

// get quote
$quote->read_single();

// create array for JSON data
$quote_arr = array (
    'id' => $quote->id,
    'quote' => $quote->quote,
    'author' => $quote->author,
    'category' => $quote->category
);

// convert to JSON
print_r(json_encode($quote_arr));
