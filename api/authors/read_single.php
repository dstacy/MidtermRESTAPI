<?php

// get author
$author->read_single(); 

// create array for JSON data
$author_arr = array (
    'id' => $author->id,
    'author' => $author->author
);

// convert to JSON
print_r(json_encode($author_arr));


