<?php
include '../../partial_files/create_headers.php';
include '../../partial_files/object_partial_files/new_reply.php';
include_once '../../global_functions.php';

$reply->reply_body = $data->replyBody;
$reply->user_id = $data->userId;
$reply->comment_id = $data->commentId;

if ($reply->create()) {
    http_response_code(201);

    echo custom_array('reply has been created');
} else {
    http_response_code(400);

    echo custom_array('Reply could not be added');
}