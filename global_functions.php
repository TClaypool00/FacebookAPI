<?php
function checks_date_is_null($date) {
    if(is_null($date)) {
        return 'N/A';
    }

    return $date;
}

function number_is_numeric($id) {
    if (is_numeric($id)) {
        return true;
    }

    return false;
}

function get_isset($get_name) {
    if (isset($_GET[$get_name])) {
        return true;
    }

    return false;
}

function set_get_variable($get_name) {
    return $_GET[$get_name];
}

function custom_array($message) {
    return json_encode(array('message' => $message));
}