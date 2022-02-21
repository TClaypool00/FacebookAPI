<?php
include '../../partial_files/update_headers.php';
include '../../partial_files/object_partial_files/new_friend.php';
include '../../global_functions.php';

$friend->friend_id = set_id();

if ($friend->accept()) {
    http_response_code(201);
    echo custom_array('friend request has been accepted');
} else {
    http_response_code(400);
    echo custom_array('Friend request could not be accepted');
}