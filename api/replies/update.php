<?php
include_once '../../partial_files/update_headers.php';
include_once '../../partial_files/object_partial_files/new_reply.php';
include '../../global_functions.php';


$reply->reply_id = set_id();

$reply->reply_body = $data->replyBody;

if ($reply->update()) {
    echo custom_array('reply has been updated');
} else {
    echo custom_array('reply could not be updated');
}