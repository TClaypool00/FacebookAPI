<?php
include '../../partial_files/update_headers.php';
include '../../partial_files/object_partial_files/new_comment.php';
include '../../global_functions.php';

$comment->comment_id = set_id();
$comment->comment_body = $data->commentBody;

if ($comment->update()) {
    http_response_code(200);
    echo custom_array('comment has been update');
} else {
    http_response_code(400);
    echo custom_array('comment could not be updated');
}