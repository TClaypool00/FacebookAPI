<?php
include '../../partial_files/delete_headers.php';
include '../../partial_files/object_partial_files/new_friend.php';
include '../../global_functions.php';

$friend->friend_id = set_id();

if ($friend->delete()) {
    http_response_code(200);
    echo custom_array('Friend request has been deleted');
} else {
    http_response_code(404);
    echo custom_array('Friend request has been deleted');
}