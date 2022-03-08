<?php
include_once '../../partial_files/update_headers.php';
include '../../partial_files/object_partial_files/new_reply.php';
include '../../global_functions.php';

$reply->reply_id = set_id();

if ($reply->delete()) {
    http_response_code(200);

    echo custom_array('reply has been deleted');
} else {
    http_response_code(400);

    echo custom_array('reply could not deleted');
}