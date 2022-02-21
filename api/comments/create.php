<?php
include_once '../../partial_files/create_headers.php';
include '../../partial_files/object_partial_files/new_comment.php';
include '../../global_functions.php';

$data = json_decode(file_get_contents("php://input"));

$comment->comment_body = $data->commentBody;
$comment->user_id = $data->userId;
$comment->post_id = $data->postId;

if ($comment->create()) {
    http_response_code(201);
    echo custom_array('Comment has been added.');
} else {
    http_response_code(404);
    echo custom_array('comment could not be added.');
}