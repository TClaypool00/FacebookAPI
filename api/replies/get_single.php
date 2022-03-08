<?php
include '../../partial_files/get_single_headers.php';
include_once '../../partial_files/object_partial_files/new_reply.php';
include_once '../../global_functions.php';

$reply->reply_id = set_id();

$reply->get_single();

if ($reply->reply_body != null) {
    $reply_arr = array(
        'replyId' => $reply->reply_id,
        'replyBody' => $reply->reply_body,
        'datePosted' => $reply->date_posted,
        'commentId' => $reply->comment_id,
        'userId' => $reply->user_id,
        'firstName' => $reply->user_first_name,
        'lastName' => $reply->user_last_name
    );

    http_response_code(200);
    echo json_encode($reply_arr);
} else {
    http_response_code(404);
    echo custom_array('No reply found.');
}