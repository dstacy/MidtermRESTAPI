<?php

// delete author
$author->delete();

// create array for JSON data
$author_arr = array (
    'id' => $author->id
);
    
print_r(json_encode($author_arr));


