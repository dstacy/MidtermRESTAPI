
<?php

// checks for valid ids in database using a call to read_single for specified model
function isValid($id, $model) {
    $model->id = $id;    
    $result = $model->read_single();
    return $result;
}